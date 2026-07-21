<?php
require_once 'includes/config.php';
requireLogin();

$page_title = 'Dashboard';
$db = getDB();

$total_blogs = (int)$db->query("SELECT COUNT(*) as c FROM blogs")->fetch_assoc()['c'];
$total_messages = (int)$db->query("SELECT COUNT(*) as c FROM contacts")->fetch_assoc()['c'];
$unread_msgs = (int)$db->query("SELECT COUNT(*) as c FROM contacts WHERE status='new'")->fetch_assoc()['c'];
$pub_blogs = (int)$db->query("SELECT COUNT(*) as c FROM blogs WHERE status='published'")->fetch_assoc()['c'];
$draft_blogs = (int)$db->query("SELECT COUNT(*) as c FROM blogs WHERE status='draft'")->fetch_assoc()['c'];

$recent_blogs = $db->query("SELECT * FROM blogs ORDER BY created_at DESC LIMIT 5");
$recent_msgs = $db->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 5");

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<style>
    .action-btn-primary,
    .action-btn-primary:hover,
    .action-btn-primary:focus {
        background: linear-gradient(135deg, #0EADAE, #05737C) !important;
        color: #fff !important;
        border-color: transparent !important;
        box-shadow: none !important;
        transform: none !important;
    }

    .action-btn-secondary,
    .action-btn-secondary:hover,
    .action-btn-secondary:focus {
        background: #fff !important;
        color: var(--app-text) !important;
        border: 1px solid var(--app-border) !important;
        box-shadow: none !important;
        transform: none !important;
    }

    .action-btn-primary svg,
    .action-btn-secondary svg {
        color: inherit !important;
    }

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 32px;
    }

    @media (max-width: 900px) {
        .kpi-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 500px) {
        .kpi-grid {
            grid-template-columns: 1fr;
        }
    }

    /* DASHBOARD - REMOVE ALL HOVER EFFECTS */
    body .stat-card:hover,
    body .card:hover,
    body .recent-grid a:hover,
    body .kpi-grid a:hover {
        transform: none !important;
        box-shadow: none !important;
        border-color: var(--app-border) !important;
    }

    /* KEEP SAME BACKGROUND */
    body .recent-grid a:hover,
    body .kpi-grid a:hover {
        background: var(--app-bg) !important;
    }

    /* REMOVE TRANSITIONS */
    body .stat-card,
    body .card,
    body .recent-grid a,
    body .kpi-grid a {
        transition: none !important;
    }
</style>

<div class="page-header">
    <div>
        <div class="page-title">Dashboard</div>
        <p style="color:var(--app-muted);font-size:13px;margin:8px 0 0 0;">Your complete website management overview in one place</p>
    </div>
    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">

        <a href="blogs.php?form=add"
            class="btn-primary inline-flex items-center gap-2 action-btn-primary"
            style="text-decoration:none;">

            <svg fill="currentColor"
                viewBox="0 0 20 20"
                style="width:16px;height:16px;">

                <path fill-rule="evenodd"
                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                    clip-rule="evenodd" />

            </svg>

            New Blog
        </a>

        <a href="messages.php?filter=new"
            class="btn-secondary action-btn-secondary"
            style="text-decoration:none;">

            <svg fill="currentColor"
                viewBox="0 0 20 20"
                style="width:16px;height:16px;">

                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />

            </svg>

            Unread Messages
        </a>

    </div>

</div>

<div class="content-pad">
    <!-- KPI CARDS -->
    <div class="kpi-grid">

        <!-- Total Blogs -->
        <a href="blogs.php" class="stat-card" style="text-decoration:none;color:inherit;display:block;">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;">
                <div>
                    <div style="font-size:11px;font-weight:700;color:var(--app-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:8px;">Total Blogs</div>
                    <div style="font-size:36px;font-weight:800;color:var(--app-text);line-height:1;margin-bottom:8px;"><?php echo $total_blogs; ?></div>
                    <div style="font-size:12px;color:#10B981;font-weight:600;"><?php echo $pub_blogs; ?> published, <?php echo $draft_blogs; ?> draft</div>
                </div>
                <div style="width:50px;height:50px;border-radius:8px;background:rgba(16,185,129,0.10);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg fill="#10B981" viewBox="0 0 20 20" style="width:26px;height:26px;">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </a>

        <!-- Messages -->
        <a href="messages.php" class="stat-card" style="text-decoration:none;color:inherit;display:block;">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;">
                <div>
                    <div style="font-size:11px;font-weight:700;color:var(--app-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:8px;">Messages</div>
                    <div style="font-size:36px;font-weight:800;color:var(--app-text);line-height:1;margin-bottom:8px;"><?php echo $total_messages; ?></div>
                    <div style="font-size:12px;color:#EF4444;font-weight:600;"><?php echo $unread_msgs; ?> unread</div>
                </div>
                <div style="width:50px;height:50px;border-radius:8px;background:rgba(239,68,68,0.10);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg fill="#EF4444" viewBox="0 0 20 20" style="width:26px;height:26px;">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                </div>
            </div>
        </a>

        <!-- Published -->
        <a href="blogs.php?status=published" class="stat-card" style="text-decoration:none;color:inherit;display:block;">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;">
                <div>
                    <div style="font-size:11px;font-weight:700;color:var(--app-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:8px;">Published</div>
                    <div style="font-size:36px;font-weight:800;color:var(--app-text);line-height:1;margin-bottom:8px;"><?php echo $pub_blogs; ?></div>
                    <div style="font-size:12px;color:#10B981;font-weight:600;">Live articles</div>
                </div>
                <div style="width:50px;height:50px;border-radius:8px;background:rgba(34,197,94,0.10);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg fill="#22C55E" viewBox="0 0 20 20" style="width:26px;height:26px;">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </a>

        <!-- Drafts -->
        <a href="blogs.php?status=draft" class="stat-card" style="text-decoration:none;color:inherit;display:block;">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;">
                <div>
                    <div style="font-size:11px;font-weight:700;color:var(--app-muted);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:8px;">Drafts</div>
                    <div style="font-size:36px;font-weight:800;color:var(--app-text);line-height:1;margin-bottom:8px;"><?php echo $draft_blogs; ?></div>
                    <div style="font-size:12px;color:#F59E0B;font-weight:600;">Pending review</div>
                </div>
                <div style="width:50px;height:50px;border-radius:8px;background:rgba(245,158,11,0.10);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg fill="#F59E0B" viewBox="0 0 20 20" style="width:26px;height:26px;">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </a>

    </div>

    <!-- RECENT CONTENT -->
    <div style="display:grid;grid-template-columns:1.15fr 0.85fr;gap:24px;" class="recent-grid">

        <!-- Recent Blogs -->
        <div class="card w-full">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 pb-4 border-b border-[var(--app-border)]">
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-[var(--app-text)]">
                        Recent Blogs
                    </h2>
                    <p class="text-xs text-[var(--app-muted)] mt-1">
                        Latest content updates
                    </p>
                </div>

                <a href="blogs.php"
                    class="btn-secondary text-xs px-3 py-2 no-underline w-full sm:w-auto text-center">
                    View All
                </a>
            </div>

            <?php if ($recent_blogs->num_rows === 0): ?>
                <div class="py-10 text-center text-[var(--app-muted)]">
                    <svg fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        class="w-10 h-10 mx-auto mb-3 opacity-50">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>

                    <div class="font-semibold text-[var(--app-text)] mb-3">
                        No blogs yet
                    </div>

                    <a href="blogs.php?form=add"
                        class="btn-primary inline-block no-underline">
                        Create First Blog
                    </a>
                </div>

            <?php else: ?>

                <div class="grid gap-3">
                    <?php while ($blog = $recent_blogs->fetch_assoc()): ?>
                        <a href="blogs.php?form=edit&id=<?php echo (int)$blog['id']; ?>"
                            class="flex flex-col sm:flex-row sm:items-center gap-4 p-4 rounded-lg border border-[var(--app-border)] bg-[var(--app-bg)] no-underline text-inherit w-full overflow-hidden">

                            <!-- Image -->
                            <div class="w-full sm:w-[72px] h-[180px] sm:h-[52px] rounded-md overflow-hidden bg-[var(--app-border)] flex items-center justify-center shrink-0">

                                <?php if (!empty($blog['featured_image'])): ?>
                                    
                                    <img
                                        src="<?php echo htmlspecialchars($blog['featured_image']); ?>"
                                        alt="<?php echo htmlspecialchars($blog['title']); ?>"
                                        class="w-full h-full object-cover">
                                <?php else: ?>
                                    <span class="text-[11px] text-slate-400">
                                        No Image
                                    </span>
                                <?php endif; ?>

                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-semibold text-[var(--app-text)] truncate mb-1">
                                    <?php echo htmlspecialchars($blog['title']); ?>
                                </div>

                                <div class="text-xs text-[var(--app-muted)] break-words leading-5">
                                    <?php echo htmlspecialchars($blog['category']); ?>
                                    <span class="mx-1">•</span>
                                    <?php echo date('d M Y', strtotime($blog['created_at'])); ?>
                                </div>
                            </div>

                            <!-- Badge -->
                            <div class="w-full sm:w-auto">
                                <span class="badge badge-<?php echo $blog['status'] === 'published' ? 'success' : 'warning'; ?> whitespace-nowrap">
                                    <?php echo ucfirst($blog['status']); ?>
                                </span>
                            </div>
                        </a>
                    <?php endwhile; ?>
                </div>

            <?php endif; ?>
        </div>

        <!-- Recent Messages -->
        <div class="card">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:22px;padding-bottom:16px;border-bottom:1px solid var(--app-border);">
                <div>
                    <div style="font-size:16px;font-weight:700;color:var(--app-text);">Recent Messages</div>
                    <div style="font-size:12px;color:var(--app-muted);margin-top:4px;">Patient enquiries</div>
                </div>
                <a href="messages.php" class="btn-secondary" style="font-size:12px;padding:8px 12px;text-decoration:none;">View All</a>
            </div>

            <?php if ($recent_msgs->num_rows === 0): ?>
                <p style="text-align:center;color:var(--app-muted);font-size:13px;padding:40px 0;">No messages yet.</p>
            <?php else: ?>
                <div style="display:grid;gap:12px;">
                    <?php while ($msg = $recent_msgs->fetch_assoc()): ?>
                        <a href="messages.php?view=<?php echo (int)$msg['id']; ?>" style="display:flex;align-items:center;gap:12px;padding:14px;border-radius:8px;background:var(--app-bg);border:1px solid var(--app-border);text-decoration:none;color:inherit;transition:all 0.2s ease;">
                            <div style="width:40px;height:40px;border-radius:6px;background:linear-gradient(135deg,#2563EB,#06B6D4);display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700;flex-shrink:0;">
                                <?php echo strtoupper(substr($msg['name'], 0, 1)); ?>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:13px;font-weight:600;color:var(--app-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:3px;"><?php echo htmlspecialchars($msg['name']); ?></div>
                                <div style="font-size:11px;color:var(--app-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?php echo htmlspecialchars($msg['subject'] ?: $msg['email']); ?></div>
                            </div>
                            <span class="badge badge-<?php echo $msg['status'] === 'new' ? 'error' : ($msg['status'] === 'replied' ? 'replied' : 'info'); ?>" style="white-space:nowrap;"><?php echo ucfirst($msg['status']); ?></span>
                        </a>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>