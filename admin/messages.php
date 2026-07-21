<style>
    .btn-edit {
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

    .btn-mark-read {
        height: 34px;
        min-width: 72px;
        padding: 0 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #BBF7D0 !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        text-decoration: none !important;
        cursor: pointer;
        background: #F0FDF4 !important;
        color: #16A34A !important;
        transform: none !important;
        box-shadow: none !important;
    }

    .btn-danger {
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

    .table-actions {
        display: flex;
        gap: 6px;
        justify-content: center;
        flex-wrap: nowrap;
        align-items: center;
    }

    .table-actions form {
        display: inline-flex;
        margin: 0;
        padding: 0;
    }

    .status-badge {
        white-space: nowrap;
        display: inline-block;
        padding: 2px 10px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .mobile-btn-wrap {
        flex: 1;
        min-width: 90px;
    }

    .mobile-btn-wrap .btn-edit,
    .mobile-btn-wrap .btn-mark-read,
    .mobile-btn-wrap .btn-danger {
        width: 100%;
    }
</style>

<?php
require_once 'includes/config.php';
requireLogin();

$page_title = 'Messages';
$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';
    $id     = (int)($_POST['id'] ?? 0);

    if ($action === 'delete') {
        $stmt = $db->prepare("DELETE FROM contacts WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } elseif ($action === 'mark_read') {
        $stmt = $db->prepare("UPDATE contacts SET status='read' WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } elseif ($action === 'mark_all_read') {
        $db->query("UPDATE contacts SET status='read' WHERE status='new'");
    }

    $filter_redirect = $_POST['filter'] ?? $_GET['filter'] ?? 'all';
    header("Location: messages.php?success=1&filter=" . urlencode($filter_redirect));
    exit;
}

$view_id = (int)($_GET['view'] ?? 0);
$message = null;

if ($view_id > 0) {
    $stmt = $db->prepare("SELECT * FROM contacts WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $view_id);
    $stmt->execute();
    $message = $stmt->get_result()->fetch_assoc();

    if (!$message) {
        header("Location: messages.php");
        exit;
    }

    if ($message['status'] === 'new') {
        $stmt2 = $db->prepare("UPDATE contacts SET status='read' WHERE id=?");
        $stmt2->bind_param("i", $view_id);
        $stmt2->execute();
        $message['status'] = 'read';
    }
}

$filter = $_GET['filter'] ?? 'all';

$where = '';
if ($filter === 'new')         $where = "WHERE status='new'";
elseif ($filter === 'read')    $where = "WHERE status='read'";
elseif ($filter === 'replied') $where = "WHERE status='replied'";

$messages = $db->query("
    SELECT *
    FROM contacts
    $where
    ORDER BY created_at DESC
");

$total   = (int)$db->query("SELECT COUNT(*) c FROM contacts")->fetch_assoc()['c'];
$unread  = (int)$db->query("SELECT COUNT(*) c FROM contacts WHERE status='new'")->fetch_assoc()['c'];
$read    = (int)$db->query("SELECT COUNT(*) c FROM contacts WHERE status='read'")->fetch_assoc()['c'];
$replied = (int)$db->query("SELECT COUNT(*) c FROM contacts WHERE status='replied'")->fetch_assoc()['c'];

$stats = [
    'all'     => ['Total Messages',   $total,   'text-blue-600',  ''],
    'new'     => ['Unread Messages',  $unread,  'text-red-500',   ''],
    'read'    => ['Read Messages',    $read,    'text-green-600', ''],
    'replied' => ['Replied Messages', $replied, 'text-teal-600',  ''],
];

function messageBadgeClass($status)
{
    if ($status === 'new')  return 'bg-red-100 text-red-600';
    if ($status === 'read') return 'bg-green-100 text-green-700';
    return 'bg-teal-100 text-teal-700';
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<?php if ($message): ?>

    <div class="page-header">
        <div>
            <div class="page-title">Message Details</div>
            <p style="color:var(--app-muted);font-size:13px;margin:8px 0 0 0;">
                View full patient inquiry details
            </p>
        </div>
        <a href="messages.php" class="btn-secondary hover:!bg-[#CFEFEF] hover:!text-[#0A9397] transition-none" style="text-decoration:none;">
            Back to Messages
        </a>
    </div>

    <div class="content-pad">

        <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200">

            <div class="bg-[linear-gradient(135deg,_#0EADAE,_#05737C)] p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-white/20 text-white flex items-center justify-center text-xl font-extrabold">
                            <?php echo strtoupper(substr($message['name'], 0, 1)); ?>
                        </div>
                        <div>
                            <div class="text-white text-2xl font-extrabold">
                                <?php echo htmlspecialchars($message['name']); ?>
                            </div>
                        </div>
                    </div>
                    <span class="status-badge self-start md:self-center <?php echo messageBadgeClass($message['status']); ?>">
                        <?php echo ucfirst($message['status']); ?>
                    </span>
                </div>
            </div>

            <div class="p-6 md:p-8">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-7">
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                        <div class="text-[11px] uppercase font-bold text-slate-500 mb-1">Email ID</div>
                        <div class="font-bold text-slate-900"><?php echo htmlspecialchars($message['email'] ?: '-'); ?></div>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                        <div class="text-[11px] uppercase font-bold text-slate-500 mb-1">Phone</div>
                        <div class="font-bold text-slate-900"><?php echo htmlspecialchars($message['phone'] ?: '-'); ?></div>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                        <div class="text-[11px] uppercase font-bold text-slate-500 mb-1">Received</div>
                        <div class="font-bold text-slate-900"><?php echo date('d M Y, h:i A', strtotime($message['created_at'])); ?></div>
                    </div>
                </div>

                <div class="mb-7">
                    <div class="text-xs uppercase font-bold text-slate-500 mb-2">Subject</div>
                    <div class="bg-slate-50 border border-slate-200 border-l-4 border-l-teal-500 rounded-2xl p-5 text-slate-900 font-bold">
                        <?php echo htmlspecialchars($message['subject'] ?: 'No Subject'); ?>
                    </div>
                </div>

                <div class="mb-7">
                    <div class="text-xs uppercase font-bold text-slate-500 mb-2">Message</div>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 min-h-[100px] text-sm text-slate-800 leading-7">
                        <?php echo nl2br(htmlspecialchars($message['message'])); ?>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 justify-end">

                    <?php if ($message['status'] === 'new'): ?>
                        <form method="POST">
                            <input type="hidden" name="action" value="mark_read">
                            <input type="hidden" name="id" value="<?php echo (int)$message['id']; ?>">
                            <button type="submit" class="btn-mark-read">Mark Read</button>
                        </form>
                    <?php endif; ?>

                    <form method="POST" onsubmit="return confirm('Delete this message?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?php echo (int)$message['id']; ?>">
                        <button type="submit" class="btn-danger">Delete</button>
                    </form>

                </div>

            </div>

        </div>

    </div>

<?php else: ?>

    <div class="page-header">
        <div>
            <div class="page-title">Contact Messages</div>
            <p style="color:var(--app-muted);font-size:13px;margin:8px 0 0 0;">
                Manage patient messages, inquiries, and appointment requests
            </p>
        </div>

        <?php if ($unread > 0): ?>
            <form method="POST">
                <input type="hidden" name="action" value="mark_all_read">
                <input type="hidden" name="filter" value="<?php echo htmlspecialchars($filter); ?>">
                <button type="submit" class="btn-edit">Mark All Read</button>
            </form>
        <?php endif; ?>
    </div>

    <div class="content-pad">

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-7">
            <?php foreach ($stats as $k => $v): ?>
                <a href="?filter=<?php echo $k; ?>" class="block">
                    <div class="bg-white rounded-2xl p-6 border-2 <?php echo $filter === $k ? 'border-teal-500' : 'border-transparent'; ?> shadow-sm">
                        <div class="text-xs uppercase font-bold tracking-wide text-slate-500"><?php echo $v[0]; ?></div>
                        <div class="text-3xl font-extrabold mt-2 <?php echo $v[2]; ?>"><?php echo $v[1]; ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200">

            <div class="px-5 sm:px-6 py-5 border-b border-slate-200">
                <h2 class="text-lg sm:text-xl font-extrabold text-slate-900">Inbox Messages</h2>
            </div>

            <?php if ($messages->num_rows === 0): ?>

                <div class="py-16 text-center">
                    <div class="text-base sm:text-lg font-bold text-slate-700">No Messages Found</div>
                </div>

            <?php else: ?>

                <!-- Desktop Table -->
                <div class="hidden xl:block overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-slate-900">
                            <tr>
                                <th class="px-5 py-4 text-left text-xs font-bold tracking-wider text-white uppercase">#</th>
                                <th class="px-5 py-4 text-left text-xs font-bold tracking-wider text-white uppercase">Patient</th>
                                <th class="px-5 py-4 text-left text-xs font-bold tracking-wider text-white uppercase">Email</th>
                                <th class="px-5 py-4 text-left text-xs font-bold tracking-wider text-white uppercase">Subject</th>
                                <th class="px-5 py-4 text-left text-xs font-bold tracking-wider text-white uppercase">Received</th>
                                <th class="px-5 py-4 text-left text-xs font-bold tracking-wider text-white uppercase">Status</th>
                                <th class="px-5 py-4 text-center text-xs font-bold tracking-wider text-white uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            while ($m = $messages->fetch_assoc()): ?>
                                <tr class="<?php echo $m['status'] === 'new' ? 'bg-orange-50' : 'bg-white'; ?> border-b border-slate-100">

                                    <td class="px-5 py-5 font-bold text-slate-700"><?php echo $i++; ?></td>

                                    <td class="px-5 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-11 rounded-full bg-teal-600 text-white flex items-center justify-center font-extrabold">
                                                <?php echo strtoupper(substr($m['name'], 0, 1)); ?>
                                            </div>
                                            <div class="font-bold text-slate-900"><?php echo htmlspecialchars($m['name']); ?></div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-5 text-sm text-slate-700 break-all"><?php echo htmlspecialchars($m['email']); ?></td>

                                    <td class="px-5 py-5">
                                        <div class="font-bold text-slate-900"><?php echo htmlspecialchars($m['subject'] ?: 'No Subject'); ?></div>
                                        <div class="text-xs text-slate-500 mt-1"><?php echo htmlspecialchars(substr($m['message'], 0, 60)); ?>...</div>
                                    </td>

                                    <td class="px-5 py-5">
                                        <div class="font-bold text-sm text-slate-800"><?php echo date('d M Y', strtotime($m['created_at'])); ?></div>
                                        <div class="text-xs text-slate-500 mt-1"><?php echo date('h:i A', strtotime($m['created_at'])); ?></div>
                                    </td>

                                    <td class="px-5 py-5">
                                        <span class="status-badge <?php echo messageBadgeClass($m['status']); ?>">
                                            <?php echo ucfirst($m['status']); ?>
                                        </span>
                                    </td>

                                    <td class="px-5 py-5">
                                        <div class="table-actions">

                                            <a href="messages.php?view=<?php echo (int)$m['id']; ?>" class="btn-edit">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                                View
                                            </a>

                                            <?php if ($m['status'] === 'new'): ?>
                                                <form method="POST">
                                                    <input type="hidden" name="action" value="mark_read">
                                                    <input type="hidden" name="id" value="<?php echo (int)$m['id']; ?>">
                                                    <input type="hidden" name="filter" value="<?php echo htmlspecialchars($filter); ?>">
                                                    <button type="submit" class="btn-mark-read">
                                                        <!-- <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <polyline points="20 6 9 17 4 12" />
                                                        </svg> -->
                                                        Read
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <form method="POST" onsubmit="return confirm('Delete this message?')">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?php echo (int)$m['id']; ?>">
                                                <input type="hidden" name="filter" value="<?php echo htmlspecialchars($filter); ?>">
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
                                    </td>

                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile -->
                <div class="xl:hidden p-4 sm:p-5 space-y-4">

                    <?php
                    $messages->data_seek(0);
                    $i = 1;
                    while ($m = $messages->fetch_assoc()):
                    ?>
                        <div class="<?php echo $m['status'] === 'new' ? 'bg-orange-50' : 'bg-white'; ?> border border-slate-200 rounded-2xl p-4">

                            <div class="flex items-start gap-3">

                                <div class="w-11 h-11 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold shrink-0">
                                    <?php echo strtoupper(substr($m['name'], 0, 1)); ?>
                                </div>

                                <div class="flex-1 min-w-0">

                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                        <div>
                                            <div class="font-bold text-slate-900"><?php echo htmlspecialchars($m['name']); ?></div>
                                            <div class="text-sm text-slate-500 break-all"><?php echo htmlspecialchars($m['email']); ?></div>
                                        </div>
                                        <span class="status-badge <?php echo messageBadgeClass($m['status']); ?>">
                                            <?php echo ucfirst($m['status']); ?>
                                        </span>
                                    </div>

                                    <div class="mt-4">
                                        <div class="font-bold text-slate-900"><?php echo htmlspecialchars($m['subject'] ?: 'No Subject'); ?></div>
                                        <div class="text-sm text-slate-500 mt-1 leading-6"><?php echo htmlspecialchars(substr($m['message'], 0, 80)); ?>...</div>
                                    </div>

                                    <div class="mt-4 text-sm text-slate-500">
                                        <?php echo date('d M Y • h:i A', strtotime($m['created_at'])); ?>
                                    </div>

                                    <div class="mt-4 flex flex-nowrap gap-2">

                                        <div class="mobile-btn-wrap">
                                            <a href="messages.php?view=<?php echo (int)$m['id']; ?>" class="btn-edit">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                                    <circle cx="12" cy="12" r="3" />
                                                </svg>
                                                View
                                            </a>
                                        </div>

                                        <?php if ($m['status'] === 'new'): ?>
                                            <div class="mobile-btn-wrap">
                                                <form method="POST">
                                                    <input type="hidden" name="action" value="mark_read">
                                                    <input type="hidden" name="id" value="<?php echo (int)$m['id']; ?>">
                                                    <input type="hidden" name="filter" value="<?php echo htmlspecialchars($filter); ?>">
                                                    <button type="submit" class="btn-mark-read" style="width:100%;">
                                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <polyline points="20 6 9 17 4 12" />
                                                        </svg>
                                                        Read
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endif; ?>

                                        <div class="mobile-btn-wrap">
                                            <form method="POST" onsubmit="return confirm('Delete this message?')">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="id" value="<?php echo (int)$m['id']; ?>">
                                                <input type="hidden" name="filter" value="<?php echo htmlspecialchars($filter); ?>">
                                                <button type="submit" class="btn-danger" style="width:100%;">
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

                                </div>

                            </div>

                        </div>

                    <?php endwhile; ?>

                </div>

            <?php endif; ?>

        </div>

    </div>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>