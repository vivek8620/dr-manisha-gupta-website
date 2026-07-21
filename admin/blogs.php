<?php
require_once 'includes/config.php';
requireLogin();

$page_title = 'Blogs';
$db = getDB();
$msg = '';
$msg_type = '';
$form_mode = $_GET['form'] ?? '';
$edit_blog = null;

function makeBlogSlug(string $title): string
{
    return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $title), '-'));
}

// function saveBlogImage(string $field, string $current = '', string $category = ''): string
// {
//     if (empty($_FILES[$field]['name']) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) return $current;
//     if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) throw new RuntimeException('Image upload failed.');
//     $allowed = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'];
//     $tmp = $_FILES[$field]['tmp_name'];
//     $original = $_FILES[$field]['name'];
//     $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
//     $mime = mime_content_type($tmp);
//     if (!isset($allowed[$ext]) || $allowed[$ext] !== $mime) throw new RuntimeException('Only JPG, PNG, and WEBP images are allowed.');
//     if ($_FILES[$field]['size'] > 5 * 1024 * 1024) throw new RuntimeException('Image must be smaller than 5MB.');

//     // Category subfolder — same structure as existing DB images
//     $cat_folder = !empty($category) ? trim($category) : 'General';
//     $upload_dir = __DIR__ . '/../../drmanishagupta/images/Blogs/' . $cat_folder;
//     if (!is_dir($upload_dir)) mkdir($upload_dir, 0775, true);

//     $filename = 'blog-' . date('YmdHis') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
//     if (!move_uploaded_file($tmp, $upload_dir . '/' . $filename)) throw new RuntimeException('Unable to save uploaded image.');

//     // Store full URL with domain
//     $relative_path = 'images/Blogs/' . $cat_folder . '/' . $filename;
//     return 'https://drmanishagupta.in/' . $relative_path;
// }

function saveBlogImage(string $field, string $current = ''): string
{
    if (
        empty($_FILES[$field]['name']) ||
        $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE
    ) {
        return $current;
    }

    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Image upload failed.');
    }

    $allowed = [
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'webp' => 'image/webp'
    ];

    $tmp  = $_FILES[$field]['tmp_name'];
    $ext  = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    $mime = mime_content_type($tmp);

    if (!isset($allowed[$ext]) || $allowed[$ext] !== $mime) {
        throw new RuntimeException('Only JPG, PNG and WEBP images are allowed.');
    }

    if ($_FILES[$field]['size'] > 5 * 1024 * 1024) {
        throw new RuntimeException('Image must be smaller than 5MB.');
    }

    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/images/Blogs';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0775, true);
    }

    $filename = 'blog-' . time() . '-' . bin2hex(random_bytes(4)) . '.' . $ext;

    if (!move_uploaded_file($_FILES[$field]['tmp_name'], $upload_dir . '/' . $filename)) {
        throw new RuntimeException('Unable to save uploaded image.');
    }

    return 'https://drmanishagupta.in/images/Blogs/' . $filename;
}


if (isset($_GET['success'])) {
    $messages = ['added' => 'Blog added successfully!', 'updated' => 'Blog updated successfully!', 'deleted' => 'Blog deleted.'];
    $msg = $messages[$_GET['success']] ?? '';
    $msg_type = $msg ? 'success' : '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add' || $action === 'edit') {
        $title = trim($_POST['title'] ?? '');
        $category = trim($_POST['category'] ?? 'Diabetology');
        $content = trim($_POST['content'] ?? '');
        $short_description = trim($_POST['short_description'] ?? '');
        $status = $_POST['status'] ?? 'draft';
        $current_image = trim($_POST['current_featured_image'] ?? '');
        $slug = makeBlogSlug($title);
        try {
            // $featured_image = saveBlogImage('featured_image', $current_image, $category);
            $featured_image = saveBlogImage('featured_image', $current_image);
        } catch (RuntimeException $e) {
            $msg = $e->getMessage();
            $msg_type = 'error';
            $form_mode = $action === 'add' ? 'add' : 'edit';
            $featured_image = $current_image;
        }
        if (empty($title)) {
            $msg = 'Title is required.';
            $msg_type = 'error';
            $form_mode = $action === 'add' ? 'add' : 'edit';
        } elseif ($msg_type !== 'error' && $action === 'add') {
            $published_at = $status === 'published' ? date('Y-m-d H:i:s') : null;
            $admin_id = (int)($_SESSION['admin_id'] ?? 0);
            $stmt = $db->prepare("INSERT INTO blogs (title,slug,category,content,short_description,featured_image,author_id,status,published_at) VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param('ssssssiss', $title, $slug, $category, $content, $short_description, $featured_image, $admin_id, $status, $published_at);
            $stmt->execute();
            header('Location: blogs.php?success=added');
            exit;
        } elseif ($msg_type !== 'error' && $action === 'edit') {
            $id = (int)($_POST['id'] ?? 0);
            if ($id > 0) {
                $published_at = $status === 'published' ? date('Y-m-d H:i:s') : null;
                $stmt = $db->prepare("UPDATE blogs SET title=?,slug=?,category=?,content=?,short_description=?,featured_image=?,status=?,published_at=?,updated_at=NOW() WHERE id=?");
                $stmt->bind_param('ssssssssi', $title, $slug, $category, $content, $short_description, $featured_image, $status, $published_at, $id);
                $stmt->execute();
                header('Location: blogs.php?success=updated');
                exit;
            }
        }
    } elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $db->prepare("DELETE FROM blogs WHERE id=?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            header('Location: blogs.php?success=deleted');
            exit;
        }
    }
}

if ($form_mode === 'edit') {
    $id = (int)($_GET['id'] ?? 0);
    if ($id > 0) {
        $stmt = $db->prepare("SELECT * FROM blogs WHERE id=? LIMIT 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $edit_blog = $stmt->get_result()->fetch_assoc();
    }
    if (!$edit_blog) {
        header('Location: blogs.php');
        exit;
    }
}

$is_form_page = $form_mode === 'add' || $form_mode === 'edit';

$blogs_data = [];
if (!$is_form_page) {
    $filter = $_GET['status'] ?? 'all';
    $where = $filter !== 'all' ? "WHERE status='" . ($filter === 'published' ? 'published' : 'draft') . "'" : '';
    $result = $db->query("SELECT * FROM blogs $where ORDER BY created_at DESC");
    while ($row = $result->fetch_assoc()) $blogs_data[] = $row;
}

$categories = ['Diabetology', 'Cardiology Care', 'Thyroid Management', 'Gastrointestinal (Gastric) Care'];

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<style>
    body .card:hover,
    body .table-wrapper:hover {
        transform: none !important;
        box-shadow: none !important;
        border-color: var(--app-border) !important;
    }

    body .data-table tbody tr:hover td {
        background: var(--app-panel) !important;
    }

    body .card,
    body .table-wrapper,
    body .data-table tbody tr,
    body .data-table tbody td {
        transition: none !important;
    }

    .blog-category {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        background: #F0F4F8;
        color: #042A3F;
        white-space: nowrap;
    }

    .btn-edit,
    .btn-edit:hover,
    .btn-edit:focus {
        height: 34px;
        min-width: 72px;
        padding: 0 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        text-decoration: none !important;
        cursor: pointer;
        background: linear-gradient(135deg, #0EADAE, #05737C) !important;
        color: #fff !important;
        transform: none !important;
        box-shadow: none !important;
    }

    .btn-danger,
    .btn-danger:hover,
    .btn-danger:focus {
        height: 34px;
        min-width: 72px;
        padding: 0 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        cursor: pointer;
        background: #FEF2F2 !important;
        color: #DC2626 !important;
        border: 1px solid #FECACA !important;
        transform: none !important;
        box-shadow: none !important;
    }

    .action-btn-primary,
    .action-btn-primary:hover,
    .action-btn-primary:focus {
        background: linear-gradient(135deg, #0EADAE, #05737C) !important;
        color: #fff !important;
        border: none !important;
        box-shadow: none !important;
        transform: none !important;
    }

    .data-table td:last-child {
        white-space: nowrap;
    }

    .data-table td form {
        display: inline-flex;
        margin: 0;
        vertical-align: middle;
    }

    /* TABLE COLUMN WIDTHS — fix title wrapping on all screen sizes */
    .data-table {
        table-layout: fixed;
        width: 100%;
    }

    .data-table th:nth-child(1),
    .data-table td:nth-child(1) {
        width: 44px;
    }

    .data-table th:nth-child(2),
    .data-table td:nth-child(2) {
        width: auto;
        min-width: 200px;
    }

    .data-table th:nth-child(3),
    .data-table td:nth-child(3) {
        width: 160px;
    }

    .data-table th:nth-child(4),
    .data-table td:nth-child(4) {
        width: 100px;
        white-space: nowrap;
    }

    .data-table th:nth-child(5),
    .data-table td:nth-child(5) {
        width: 100px;
    }

    .data-table th:nth-child(6),
    .data-table td:nth-child(6) {
        width: 200px;
        text-align: center;
        white-space: nowrap;
    }

    /* Title cell: no vertical wrap, thumbnail + text side by side */
    .title-cell {
        display: flex;
        align-items: center;
        gap: 10px;
        overflow: hidden;
    }

    .title-cell-thumb {
        width: 52px;
        height: 42px;
        border-radius: 8px;
        overflow: hidden;
        background: #E2E8F0;
        flex-shrink: 0;
    }

    .title-cell-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .title-cell-text {
        min-width: 0;
        flex: 1;
    }

    .title-cell-text .t-name {
        font-weight: 600;
        color: #042A3F;
        font-size: 13px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .title-cell-text .t-desc {
        font-size: 11px;
        color: #6c7a79;
        margin-top: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* MOBILE CARD LAYOUT */
    @media (max-width: 767px) {
        .desktop-table {
            display: none !important;
        }

        .page-header {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 12px !important;
            padding: 14px 16px !important;
        }

        .content-area-pad {
            padding: 12px 14px !important;
        }

        .blog-card {
            background: #fff;
            border: 1.5px solid #E2E8F0;
            border-radius: 14px;
            padding: 14px;
            margin-bottom: 12px;
        }

        .blog-card-top {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .blog-card-thumb {
            width: 64px;
            height: 50px;
            border-radius: 8px;
            overflow: hidden;
            background: #E2E8F0;
            flex-shrink: 0;
        }

        .blog-card-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .blog-card-info {
            flex: 1;
            min-width: 0;
        }

        .blog-card-title {
            font-weight: 700;
            color: #042A3F;
            font-size: 14px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .blog-card-excerpt {
            font-size: 12px;
            color: #6c7a79;
            margin-top: 3px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .blog-card-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 10px;
        }

        .blog-card-date {
            font-size: 11px;
            color: #94a3b8;
        }

        .blog-card-actions {
            display: flex;
            gap: 8px;
            border-top: 1px solid #F1F5F9;
            padding-top: 10px;
        }

        .blog-card-actions .btn-edit {
            flex: 1;
            justify-content: center;
        }

        .blog-card-actions .delete-form {
            flex: 1;
        }

        .blog-card-actions .btn-danger {
            width: 100%;
            justify-content: center;
        }

        /* Form page mobile */
        .form-content-pad {
            padding: 14px !important;
        }

        .form-aside-desktop {
            display: none !important;
        }

        .form-aside-mobile {
            display: block !important;
        }

        .form-btns {
            flex-direction: column !important;
        }

        .form-btns a,
        .form-btns button {
            text-align: center;
            justify-content: center;
        }
    }

    @media (min-width: 768px) {
        .mobile-cards {
            display: none !important;
        }

        .desktop-table {
            display: table !important;
        }

        .form-aside-mobile {
            display: none !important;
        }

        .form-aside-desktop {
            display: block !important;
        }
    }
</style>

<?php if ($is_form_page): ?>
    <?php
    $form_title = $form_mode === 'edit' ? 'Edit Blog' : 'Add New Blog';
    $blog = ['id' => $edit_blog['id'] ?? '', 'title' => $edit_blog['title'] ?? '', 'category' => $edit_blog['category'] ?? 'Diabetology', 'status' => $edit_blog['status'] ?? 'draft', 'short_description' => $edit_blog['short_description'] ?? '', 'content' => $edit_blog['content'] ?? '', 'featured_image' => $edit_blog['featured_image'] ?? ''];
    ?>

    <div class="page-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;padding:20px 28px;">
        <div>
            <div class="page-title" style="color:#042A3F;"><?php echo $form_title; ?></div>
            <p class="text-sm mt-1" style="color:var(--app-muted);">Write and publish blog content</p>
        </div>
        <a href="blogs.php" class="btn-secondary" style="text-decoration:none;">← Back to Blogs</a>
    </div>

    <div class="form-content-pad" style="padding:24px 28px;">
        <?php if ($msg): ?><div class="alert alert-<?php echo $msg_type; ?> mb-5"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>

        <div style="display:flex;gap:24px;align-items:flex-start;flex-wrap:wrap;">

            <!-- MAIN FORM -->
            <div class="card" style="flex:1;min-width:0;width:100%;">
                <form method="POST" enctype="multipart/form-data" id="blogForm">
                    <input type="hidden" name="action" value="<?php echo $form_mode === 'edit' ? 'edit' : 'add'; ?>">
                    <input type="hidden" name="current_featured_image" value="<?php echo htmlspecialchars($blog['featured_image']); ?>">
                    <?php if ($form_mode === 'edit'): ?><input type="hidden" name="id" value="<?php echo (int)$blog['id']; ?>"><?php endif; ?>

                    <div class="mb-5">
                        <label class="block text-sm font-semibold mb-1" style="color:#042A3F;">Title *</label>
                        <input type="text" name="title" placeholder="Blog title" value="<?php echo htmlspecialchars($blog['title']); ?>" required
                            class="w-full rounded-xl border px-4 text-sm font-medium focus:outline-none"
                            style="height:48px;border-color:#DCE5EC;color:#042A3F;background:#fff;"
                            onfocus="this.style.borderColor='#0EADAE';this.style.boxShadow='0 0 0 3px rgba(14,173,174,.08)'"
                            onblur="this.style.borderColor='#DCE5EC';this.style.boxShadow='none'">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                        <div>
                            <label class="block text-sm font-semibold mb-1" style="color:#042A3F;">Category</label>
                            <div class="relative">
                                <select name="category" class="w-full rounded-xl border px-4 text-sm appearance-none focus:outline-none pr-10"
                                    style="height:48px;border-color:#DCE5EC;color:#042A3F;background:#fff;"
                                    onfocus="this.style.borderColor='#0EADAE';this.style.boxShadow='0 0 0 3px rgba(14,173,174,.08)'"
                                    onblur="this.style.borderColor='#DCE5EC';this.style.boxShadow='none'">
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $blog['category'] === $cat ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4" fill="none" stroke="#64748B" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-1" style="color:#042A3F;">Status</label>
                            <div class="relative">
                                <select name="status" class="w-full rounded-xl border px-4 text-sm appearance-none focus:outline-none pr-10"
                                    style="height:48px;border-color:#DCE5EC;color:#042A3F;background:#fff;"
                                    onfocus="this.style.borderColor='#0EADAE';this.style.boxShadow='0 0 0 3px rgba(14,173,174,.08)'"
                                    onblur="this.style.borderColor='#DCE5EC';this.style.boxShadow='none'">
                                    <option value="draft" <?php echo $blog['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                    <option value="published" <?php echo $blog['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                                </select>
                                <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4" fill="none" stroke="#64748B" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-semibold mb-1" style="color:#042A3F;">Excerpt</label>
                        <input type="text" name="short_description" placeholder="Short description" value="<?php echo htmlspecialchars($blog['short_description']); ?>"
                            class="w-full rounded-xl border px-4 text-sm focus:outline-none"
                            style="height:48px;border-color:#DCE5EC;color:#042A3F;background:#fff;"
                            onfocus="this.style.borderColor='#0EADAE';this.style.boxShadow='0 0 0 3px rgba(14,173,174,.08)'"
                            onblur="this.style.borderColor='#DCE5EC';this.style.boxShadow='none'">
                    </div>

                    <!-- FEATURED IMAGE — Mobile (inside form) -->
                    <div class="form-aside-mobile mb-5">
                        <label class="block text-sm font-bold mb-2" style="color:#042A3F;">Featured Image</label>
                        <div class="rounded-xl overflow-hidden mb-3 flex items-center justify-center"
                            style="aspect-ratio:16/10;border:1.5px dashed #CBD5E1;background:#F8FAFC;">
                            <?php if (!empty($blog['featured_image'])): ?>
                                <img src="<?php echo htmlspecialchars($blog['featured_image']); ?>" alt="" class="w-full h-full object-cover" id="imgPreviewM">
                            <?php else: ?>
                                <span style="color:#64748B;font-size:13px;" id="noImgM">No image selected</span>
                                <img id="imgPreviewM" src="" alt="" class="w-full h-full object-cover hidden">
                            <?php endif; ?>
                        </div>
                        <input type="file" name="featured_image" accept="image/jpeg,image/png,image/webp" form="blogForm" id="imageInputM"
                            class="w-full text-sm rounded-xl border px-3 py-2"
                            style="border-color:#DCE5EC;color:#042A3F;background:#fff;">
                        <p class="text-xs mt-2" style="color:#64748B;">JPG, PNG or WEBP · Max 5MB</p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold mb-1" style="color:#042A3F;">Content</label>
                        <textarea name="content" id="blogContent" rows="16" placeholder="Blog content..."
                            class="w-full rounded-xl border px-4 py-3 text-sm focus:outline-none resize-y"
                            style="border-color:#DCE5EC;color:#042A3F;background:#fff;min-height:160px;"
                            onfocus="this.style.borderColor='#0EADAE';this.style.boxShadow='0 0 0 3px rgba(14,173,174,.08)'"
                            onblur="this.style.borderColor='#DCE5EC';this.style.boxShadow='none'"><?php echo htmlspecialchars($blog['content']); ?></textarea>
                    </div>

                    <div class="form-btns" style="display:flex;justify-content:flex-end;gap:12px;">
                        <a href="blogs.php" class="btn-secondary" style="text-decoration:none;">Cancel</a>
                        <button type="submit" class="btn-primary" style="background:linear-gradient(135deg,#0EADAE,#05737C);color:#fff;border:none;">
                            <?php echo $form_mode === 'edit' ? 'Update Blog' : 'Save Blog'; ?>
                        </button>
                    </div>
                </form>
            </div>

            <!-- FEATURED IMAGE SIDEBAR — Desktop -->
            <aside class="form-aside-desktop card" style="width:300px;flex-shrink:0;padding:20px;">
                <div class="text-sm font-bold mb-3" style="color:#042A3F;">Featured Image</div>
                <div class="rounded-xl overflow-hidden mb-4 flex items-center justify-center"
                    style="aspect-ratio:16/10;border:1.5px dashed #CBD5E1;background:#F8FAFC;">
                    <?php if (!empty($blog['featured_image'])): ?>
                        <img src="<?php echo htmlspecialchars($blog['featured_image']); ?>" alt="" class="w-full h-full object-cover" id="imgPreview">
                    <?php else: ?>
                        <span style="color:#64748B;font-size:13px;" id="noImgText">No image selected</span>
                        <img id="imgPreview" src="" alt="" class="w-full h-full object-cover hidden">
                    <?php endif; ?>
                </div>
                <label class="block text-sm font-semibold mb-1" style="color:#042A3F;">Upload Image</label>
                <input type="file" name="featured_image" accept="image/jpeg,image/png,image/webp" form="blogForm" id="imageInput"
                    class="w-full text-sm rounded-xl border px-3 py-2"
                    style="border-color:#DCE5EC;color:#042A3F;background:#fff;">
                <p class="text-xs mt-3 leading-relaxed" style="color:#64748B;">JPG, PNG, or WEBP up to 5MB. Appears on blog cards and detail pages.</p>
            </aside>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#blogContent',
            license_key: 'gpl',
            height: 520,
            menubar: false,
            branding: false,
            promotion: false,
            plugins: 'lists link image table code autoresize',
            toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image table | code',
            images_upload_url: 'upload_blog_image.php',
            automatic_uploads: true,
            file_picker_types: 'image',
            content_style: 'body{font-family:Inter,Arial,sans-serif;font-size:16px;line-height:1.7;color:#334155;} img{max-width:100%;height:auto;border-radius:12px;}'
        });

        function wirePreview(inputId, previewId, noTextId) {
            const el = document.getElementById(inputId);
            if (!el) return;
            el.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = e => {
                    const p = document.getElementById(previewId),
                        n = document.getElementById(noTextId);
                    if (p) {
                        p.src = e.target.result;
                        p.classList.remove('hidden');
                    }
                    if (n) {
                        n.classList.add('hidden');
                    }
                };
                reader.readAsDataURL(file);
            });
        }
        wirePreview('imageInput', 'imgPreview', 'noImgText');
        wirePreview('imageInputM', 'imgPreviewM', 'noImgM');
    </script>

<?php else: ?>

    <!-- LIST VIEW -->
    <div class="page-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;padding:20px 28px;">
        <div>
            <div class="page-title" style="color:#042A3F;">Blogs Management</div>
            <p style="color:var(--app-muted);font-size:13px;margin:6px 0 0 0;">Create, edit, and manage all your blog posts</p>
        </div>
        <a href="blogs.php?form=add" class="btn-primary action-btn-primary" style="text-decoration:none;display:inline-flex;align-items:center;gap:8px;white-space:nowrap;">
            <svg fill="currentColor" viewBox="0 0 20 20" style="width:16px;height:16px;">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            New Blog
        </a>
    </div>

    <div class="content-area-pad" style="padding:20px 28px;">
        <?php if ($msg): ?><div class="alert alert-<?php echo $msg_type; ?> mb-4"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>

        <!-- Filter tabs -->
        <div style="display:flex;gap:8px;margin-bottom:18px;flex-wrap:wrap;">
            <?php
            $filter = $_GET['status'] ?? 'all';
            $tabs = ['all' => 'All Blogs', 'published' => 'Published', 'draft' => 'Draft'];
            foreach ($tabs as $k => $v): $active = $filter === $k; ?>
                <a href="?status=<?php echo $k; ?>" style="padding:7px 16px;border-radius:8px;font-size:13px;font-weight:500;text-decoration:none;<?php echo $active ? 'background:#0EADAE;color:#fff;' : 'background:#fff;color:#6c7a79;border:1.5px solid #E2E8F0;'; ?>">
                    <?php echo $v; ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- DESKTOP TABLE -->
        <div class="card table-wrapper desktop-table" style="padding:0;overflow-x:auto;-webkit-overflow-scrolling:touch;">
            <table class="data-table" style="width:100%;min-width:680px;">
                <thead>
                    <tr>
                        <th style="width:44px;">#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($blogs_data)): ?>
                        <tr>
                            <td colspan="6" style="text-align:center;padding:48px;color:#6c7a79;">No blogs found. <a href="blogs.php?form=add" style="color:#0EADAE;font-weight:600;">Add the first one</a></td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($blogs_data as $idx => $blog_row): ?>
                            <tr>
                                <td style="color:#6c7a79;font-size:13px;"><?php echo $idx + 1; ?></td>
                                <td>
                                    <div class="title-cell">
                                        <div class="title-cell-thumb">
                                            <?php if (!empty($blog_row['featured_image'])): ?><img src="<?php echo htmlspecialchars($blog_row['featured_image']); ?>" alt=""><?php endif; ?>
                                        </div>
                                        <div class="title-cell-text">
                                            <div class="t-name"><?php echo htmlspecialchars($blog_row['title']); ?></div>
                                            <?php if ($blog_row['short_description']): ?><div class="t-desc"><?php echo htmlspecialchars($blog_row['short_description']); ?></div><?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="blog-category"><?php echo htmlspecialchars($blog_row['category']); ?></span></td>
                                <td style="font-size:12px;color:#6c7a79;white-space:nowrap;"><?php echo date('d M Y', strtotime($blog_row['created_at'])); ?></td>
                                <td><span class="badge badge-<?php echo $blog_row['status'] === 'published' ? 'success' : 'warning'; ?>"><?php echo ucfirst($blog_row['status']); ?></span></td>
                                <td>
                                    <a href="blogs.php?form=edit&id=<?php echo (int)$blog_row['id']; ?>" class="btn-edit" style="margin-right:6px;">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this blog?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo (int)$blog_row['id']; ?>">
                                        <button type="submit" class="btn-danger">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <polyline points="3 6 5 6 21 6" />
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                                <path d="M10 11v6M14 11v6" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- MOBILE CARDS -->
        <div class="mobile-cards">
            <?php if (empty($blogs_data)): ?>
                <div style="text-align:center;padding:48px 16px;color:#6c7a79;">No blogs found. <a href="blogs.php?form=add" style="color:#0EADAE;font-weight:600;">Add the first one</a></div>
            <?php else: ?>
                <?php foreach ($blogs_data as $blog_row): ?>
                    <div class="blog-card">
                        <div class="blog-card-top">
                            <div class="blog-card-thumb">
                                <?php if (!empty($blog_row['featured_image'])): ?><img src="<?php echo htmlspecialchars($blog_row['featured_image']); ?>" alt=""><?php endif; ?>
                            </div>
                            <div class="blog-card-info">
                                <div class="blog-card-title"><?php echo htmlspecialchars($blog_row['title']); ?></div>
                                <?php if ($blog_row['short_description']): ?><div class="blog-card-excerpt"><?php echo htmlspecialchars($blog_row['short_description']); ?></div><?php endif; ?>
                            </div>
                        </div>
                        <div class="blog-card-meta">
                            <span class="blog-category"><?php echo htmlspecialchars($blog_row['category']); ?></span>
                            <span class="blog-card-date"><?php echo date('d M Y', strtotime($blog_row['created_at'])); ?></span>
                            <span class="badge badge-<?php echo $blog_row['status'] === 'published' ? 'success' : 'warning'; ?>" style="font-size:11px;"><?php echo ucfirst($blog_row['status']); ?></span>
                        </div>
                        <div class="blog-card-actions">
                            <a href="blogs.php?form=edit&id=<?php echo (int)$blog_row['id']; ?>" class="btn-edit">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Edit
                            </a>
                            <form class="delete-form" method="POST" onsubmit="return confirm('Delete this blog?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo (int)$blog_row['id']; ?>">
                                <button type="submit" class="btn-danger">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                        <path d="M10 11v6M14 11v6" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>