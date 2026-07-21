<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        background: #f1f5f9;
        font-family: Inter, sans-serif;
    }

    /* SIDEBAR */
    #sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 280px;
        height: 100vh;
        overflow-y: auto;
        z-index: 180;
        background: linear-gradient(135deg, #0EADAE, #05737C);
        transition: transform .3s ease;
    }

    /* MOBILE TOPBAR */
    #topbar {
        display: flex;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 56px;
        z-index: 200;
        padding: 0 14px;
        background: linear-gradient(135deg, #0EADAE, #05737C);
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.18);
        width: 100%;
        flex-direction: row;
    }

    @media (min-width: 769px) {
        #topbar {
            display: none !important;
        }
    }

    #sidebar-overlay {
        display: none !important;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 175;
        top: 56px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.24s ease;
    }

    #sidebar-overlay.show {
        display: block !important;
        opacity: 1;
        pointer-events: auto;
    }

    /* NAV ITEM ICONS WHITE */
    .nav-item svg {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        transition: all .28s ease;
        color: #ffffff !important;
        fill: currentColor;
    }

    /* HOVER */
    .nav-item:hover svg {
        color: #ffffff !important;
        transform: scale(1.08);
    }

    /* ACTIVE */
    .nav-item.active svg {
        color: #05737C !important;
    }

    /* LOGOUT */
    .logout-btn svg {
        color: #ffffff !important;
    }

    .logout-btn:hover svg {
        color: #dc2626 !important;
    }

    /* BRAND */
    .sidebar-brand {
        padding: 22px 18px;
        border-bottom: 1px solid rgba(255, 255, 255, .08);
    }


    /* BRAND */
    .sidebar-brand {
        padding: 22px 18px;
        border-bottom: 1px solid rgba(255, 255, 255, .08);
        display: block;
        transition: .25s ease;
    }

    /* HIDE BRAND WHEN HAMBURGER OPEN */
    #sidebar.mobile-open .sidebar-brand {
        display: none;
    }



    .brand-flex {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .brand-avatar {
        width: 46px;
        height: 46px;
        border-radius: 999px;
        overflow: hidden;
        border: 2px solid rgba(255, 255, 255, .2);
        flex-shrink: 0;
    }

    .brand-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .brand-title {
        color: #fff;
        font-size: 15px;
        font-weight: 800;
        line-height: 1.3;
    }

    .brand-subtitle {
        color: rgba(255, 255, 255, 0.86);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-top: 3px;
    }

    /* USER CARD */
    .user-card {
        margin: 14px 12px 10px;
        padding: 14px;
        border-radius: 16px;
        background: rgba(255, 255, 255, .10);
        border: 1px solid rgba(255, 255, 255, .12);
        backdrop-filter: blur(10px);
    }

    .user-label {
        color: rgba(255, 255, 255, 0.86);
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .1em;
    }

    .user-name {
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        margin-top: 4px;
    }

    .user-role {
        display: inline-flex;
        margin-top: 8px;
        padding: 4px 10px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .15);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    /* NAV */
    .sidebar-nav {
        padding: 12px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 14px;
        border-radius: 16px;
        text-decoration: none;
        color: rgba(255, 255, 255, .92);
        font-size: 14px;
        font-weight: 600;
        transition: all .28s ease;
        position: relative;
    }

    .nav-item svg {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
        transition: all .28s ease;
    }

    /* HOVER EFFECT */
    .nav-item:hover {
        background: rgba(255, 255, 255, .14);
        color: #fff;
        transform: translateX(4px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, .12);
    }

    .nav-item:hover svg {
        transform: scale(1.08);
    }

    /* ACTIVE */
    .nav-item.active {
        background: #fff;
        color: #05737C;
        box-shadow: 0 12px 24px rgba(0, 0, 0, .16);
        font-weight: 700;
    }

    .nav-item.active svg {
        color: #05737C;
    }

    /* BADGES */
    .nav-badge {
        margin-left: auto;
        min-width: 24px;
        height: 24px;
        padding: 0 8px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 800;
    }

    .badge-white {
        background: #fff;
        color: #05737C;
    }

    .badge-red {
        background: #fff;
        color: #dc2626;
    }

    /* DIVIDER */
    .sidebar-divider {
        margin: 10px 16px;
        border-top: 1px solid rgba(255, 255, 255, .12);
    }

    /* LOGOUT */
    .logout-btn {
        background: rgba(255, 255, 255, .10);
        color: #fff;
    }

    .logout-btn:hover {
        background: #fff;
        color: #dc2626;
    }

    .logout-btn:hover svg {
        color: #dc2626;
    }

    /* MAIN CONTENT */
    #main-content {
        margin-left: 280px;
        min-height: 100vh;
        transition: margin-left 0.24s ease;
        overflow-x: hidden;
        width: calc(100% - 280px);
    }

    @media (max-width: 1024px) {
        #main-content {
            margin-left: 220px;
            width: calc(100% - 220px);
        }
    }

    @media (max-width: 768px) {
        #main-content {
            margin-left: 0;
            width: 100%;
        }
    }

    /* TABLE STYLES */
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        max-width: 100%;
    }

    table th {
        padding: 12px 10px;
        text-align: left;
        border-bottom: 2px solid var(--app-border, #DDE7F0);
        background: var(--app-bg, #EEF3F8);
        font-weight: 600;
        white-space: nowrap;
    }

    table td {
        padding: 12px 10px;
        border-bottom: 1px solid var(--app-border, #DDE7F0);
        word-break: break-word;
        overflow-wrap: break-word;
    }

    table tr:hover {
        background: var(--app-bg, #EEF3F8);
    }

    .table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin: 0;
        padding: 0;
        width: 100%;
        max-width: 100%;
        border-radius: 8px;
    }

    .table-wrapper table {
        width: 100%;
        min-width: 100%;
        max-width: 100%;
    }

    /* Ensure no horizontal overflow on body */
    body {
        overflow-x: hidden;
        width: 100%;
    }

    .card,
    .content-pad {
        overflow-x: hidden;
        max-width: 100%;
    }

    /* MOBILE */
    @media (max-width: 1024px) {
        #sidebar {
            width: 220px;
        }
    }

    @media (max-width: 768px) {

        /* Tables */
        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            max-width: 100%;
            width: 100%;
        }

        .table-wrapper table {
            min-width: min(600px, 100%);
            width: 100%;
        }

        /* Main Content & Sidebar */
        #main-content {
            margin-left: 0;
            margin-top: 56px;
            width: 100%;
        }

        #sidebar {
            width: 100%;
            max-width: 280px;
            transform: translateX(-100%);
            height: calc(100vh - 56px);
            top: 56px;
            transition: transform 0.24s ease;
        }

        #sidebar.mobile-open {
            transform: translateX(0);
        }

        #sidebar-overlay {
            display: none !important;
            top: 56px;
        }

        #sidebar-overlay.show {
            display: block !important;
            opacity: 1;
        }

        .nav-item {
            padding: 10px 12px;
            font-size: 12px;
            min-height: 38px;
        }

        .nav-item svg {
            width: 16px;
            height: 16px;
        }

        .sidebar-brand {
            padding: 16px 14px;
        }

        .brand-avatar {
            width: 40px;
            height: 40px;
        }

        .brand-title {
            font-size: 13px;
        }

        .brand-subtitle {
            font-size: 11px;
        }

        #page-header {
            margin-top: 0;
            padding: 20px 16px;
        }

        .content-pad {
            padding: 16px 12px !important;
        }

        /* Tables responsive */
        table {
            font-size: 12px;
        }

        th,
        td {
            padding: 10px 8px !important;
        }
    }

    @media (max-width: 640px) {
        #topbar {
            height: 56px;
            padding: 0 10px;
        }

        #sidebar {
            max-width: 85vw;
        }

        #main-content {
            margin-top: 52px;
        }

        .sidebar-brand {
            padding: 14px 10px;
        }

        .brand-avatar {
            width: 36px;
            height: 40px;
        }

        .brand-title {
            font-size: 12px;
        }

        .brand-subtitle {
            font-size: 10px;
        }

        .nav-item {
            padding: 8px 10px;
            font-size: 11px;
            min-height: 36px;
        }

        .nav-item svg {
            width: 14px;
            height: 14px;
        }

        /* Tables */
        table {
            font-size: 11px;
            min-width: 100%;
        }

        th,
        td {
            padding: 8px 6px !important;
        }

        .table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    }

    @media (max-width: 480px) {
        #topbar {
            height: 56px;
        }

        #main-content {
            margin-top: 48px;
        }

        .sidebar-brand {
            padding: 12px 8px;
        }

        .brand-avatar {
            width: 32px;
            height: 32px;
        }

        .brand-title {
            font-size: 11px;
        }

        .brand-subtitle {
            font-size: 9px;
        }

        .nav-item {
            padding: 7px 8px;
            font-size: 10px;
            min-height: 32px;
            margin: 1px 2px;
        }

        .nav-item svg {
            width: 12px;
            height: 12px;
        }

        table {
            font-size: 10px;
        }

        th,
        td {
            padding: 6px 4px !important;
        }
    }

    @media (max-width: 360px) {
        #topbar {
            height: 56px;
        }

        #main-content {
            margin-top: 44px;
        }

        .sidebar-brand {
            padding: 10px 6px;
        }

        .brand-avatar {
            width: 28px;
            height: 28px;
        }

        .brand-title {
            font-size: 10px;
        }

        .brand-subtitle {
            display: none;
        }

        .nav-item {
            padding: 6px 6px;
            font-size: 9px;
            min-height: 28px;
        }

        table {
            font-size: 9px;
        }

        th,
        td {
            padding: 4px 2px !important;
        }
    }
</style>

<?php
$current = basename($_SERVER['PHP_SELF'], '.php');
$admin = getAdminInfo();

$admin_name = $admin
    ? ($admin['full_name'] ?: 'Administrator')
    : 'Administrator';

$admin_role = $admin
    ? ($admin['role'] ?: 'admin')
    : 'admin';

$db = getDB();

$r_blogs = $db->query("SELECT COUNT(*) as c FROM blogs");
$blog_count = $r_blogs
    ? (int)$r_blogs->fetch_assoc()['c']
    : 0;

$r_msgs = $db->query("SELECT COUNT(*) as c FROM contacts WHERE status='new'");
$unread_count = $r_msgs
    ? (int)$r_msgs->fetch_assoc()['c']
    : 0;
?>

<!-- MOBILE TOPBAR -->
<div id="topbar">

    <a href="dashboard.php" style="display:flex;align-items:center;gap:10px;text-decoration:none;">

        <div style="width:36px;height:36px;border-radius:999px;overflow:hidden;border:2px solid rgba(255,255,255,.2);">
            <img src="assets/images/manisha.png"
                alt="Admin"
                style="width:100%;height:100%;object-fit:cover;">
        </div>

        <div style="color:#fff;font-size:14px;font-weight:700;">
            Dr. Manisha Admin
        </div>

    </a>

    <button onclick="toggleSidebar()"
        style="width:42px;height:42px;border:none;border-radius:14px;background:rgba(255,255,255,.12);color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;">

        <svg fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
            style="width:20px;height:20px;">

            <path stroke-linecap="round"
                stroke-linejoin="round"
                d="M4 6h16M4 12h16M4 18h16" />

        </svg>

    </button>

</div>

<!-- OVERLAY -->
<div id="sidebar-overlay"
    onclick="toggleSidebar()"></div>

<!-- SIDEBAR -->
<aside id="sidebar">

    <!-- BRAND -->
    <a href="dashboard.php" class="block">
        <div class="sidebar-brand">

            <div class="brand-flex">

                <div class="brand-avatar">
                    <img src="assets/images/manisha.png" alt="Dr. Manisha">
                </div>

                <div>
                    <div class="brand-title">
                        Dr. Manisha Gupta
                    </div>

                    <div class="brand-subtitle">
                        Senior Consultant
                    </div>
                </div>

            </div>

        </div>
    </a>

    <!-- USER -->
    <div class="user-card">

        <div class="user-label">
            Logged in as
        </div>

        <div class="user-name">
            <?php echo htmlspecialchars($admin_name); ?>
        </div>

        <span class="user-role">
            <?php echo htmlspecialchars($admin_role); ?>
        </span>

    </div>

    <!-- NAVIGATION -->
    <nav class="sidebar-nav">

        <!-- DASHBOARD -->
        <a href="dashboard.php"
            class="nav-item <?php echo $current === 'dashboard' ? 'active' : ''; ?>">

            <svg fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>

            <span>Dashboard</span>

        </a>

        <!-- BLOGS -->
        <a href="blogs.php"
            class="nav-item <?php echo $current === 'blogs' ? 'active' : ''; ?>">

            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                    clip-rule="evenodd" />
            </svg>

            <span>Blogs</span>

        </a>

        <!-- MESSAGES -->
        <a href="messages.php"
            class="nav-item <?php echo $current === 'messages' ? 'active' : ''; ?>">

            <svg fill="currentColor" viewBox="0 0 20 20">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
            </svg>

            <span>Messages</span>

            <?php if ($unread_count > 0): ?>
                <span class="nav-badge badge-red">
                    <?php echo $unread_count; ?>
                </span>
            <?php endif; ?>

        </a>

        <!-- SETTINGS -->
        <a href="settings.php"
            class="nav-item <?php echo $current === 'settings' ? 'active' : ''; ?>">

            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                    clip-rule="evenodd" />
            </svg>

            <span>Settings</span>

        </a>

    </nav>

    <!-- DIVIDER -->
    <div class="sidebar-divider"></div>

    <!-- LOGOUT -->
    <div style="padding:10px 12px 24px;">

        <a href="logout.php"
            class="nav-item logout-btn">

            <svg fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                    clip-rule="evenodd" />
            </svg>

            <span>Logout</span>

        </a>

    </div>

</aside>

<!-- MAIN CONTENT -->
<main id="main-content">

    <script>
        function toggleSidebar() {

            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('show');
        }
    </script>