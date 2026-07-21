<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' - Admin Panel' : 'Admin Panel'; ?></title>
    <link rel="icon" type="image/png" href="assets/images/manisha.png">
    <link rel="apple-touch-icon" href="assets/images/manisha.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        :root {
            --app-blue: #2563EB;
            --app-blue-dark: #1D4ED8;
            --app-sky: #06B6D4;
            --app-bg: #EEF3F8;
            --app-panel: #FFFFFF;
            --app-sidebar: #F8FBFF;
            --app-border: #DDE7F0;
            --app-text: #172033;
            --app-muted: #718096;
            --app-green: #22C55E;
            --app-orange: #F59E0B;
            --app-red: #EF4444;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.09), transparent 28rem),
                linear-gradient(180deg, #F7FAFE 0%, var(--app-bg) 100%);
            color: var(--app-text);
        }

        a,
        button,
        input,
        textarea,
        select {
            -webkit-tap-highlight-color: transparent;
        }

        button,
        a {
            touch-action: manipulation;
        }

        .app-topbar {
            position: fixed;
            inset: 0 0 auto 0;
            height: 56px;
            z-index: 220;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 18px;
            background: linear-gradient(90deg, #1D4ED8 0%, #2563EB 58%, #0EA5E9 100%);
            color: #fff;
            box-shadow: 0 10px 28px rgba(37, 99, 235, 0.22);
        }

        .app-topbar-left,
        .app-topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: -0.01em;
        }

        .topbar-brand img {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.42);
        }

        .topbar-search {
            width: min(360px, 36vw);
            height: 34px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: rgba(255, 255, 255, 0.78);
            font-size: 12px;
        }

        .topbar-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #fff;
            font-size: 12px;
            font-weight: 700;
        }

        .sidebar-toggle {
            display: none;
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 10px;
            color: #fff;
            background: rgba(255, 255, 255, 0.14);
            cursor: pointer;
            padding: 0;
        }

        .sidebar {
            position: fixed;
            left: 0;
            z-index: 180;
            width: 246px;
            height: calc(100vh - 56px);
            overflow-y: auto;
            background: rgba(255, 255, 255, 0.94);
            border-right: 1px solid var(--app-border);
            box-shadow: 6px 0 22px rgba(15, 23, 42, 0.05);
            transition: transform 0.24s ease;
        }

        .sidebar.mobile-open {
            transform: translateX(0);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 170;
        }

        .sidebar-overlay.show {
            display: block;
        }

        .main-content {
            margin-left: 246px;
            min-height: 100vh;
            transition: margin-left 0.24s ease;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 11px;
            min-height: 42px;
            padding: 10px 13px;
            margin: 2px 0;
            border-radius: 10px;
            color: #4B5B73;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.18s ease;
        }

        .nav-item svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            color: #7B8AA3;
        }

        .nav-item:hover {
            background: #EEF6FF;
            color: var(--app-blue);
        }

        .nav-item:hover svg {
            color: var(--app-blue);
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(37, 99, 235, 0.12), rgba(14, 165, 233, 0.07));
            color: var(--app-blue);
            box-shadow: inset 3px 0 0 var(--app-blue);
        }

        .nav-item.active svg {
            color: var(--app-blue);
        }

        .page-header {
            position: sticky;
            z-index: 90;
            min-height: 92px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 16px 28px;
            background: rgba(255, 255, 255, 0.88);
            border-bottom: 1px solid var(--app-border);
            backdrop-filter: blur(12px);
        }

        .page-title {
            color: var(--app-text);
            font-size: 22px;
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .content-pad {
            padding: 24px 28px !important;
        }

        .card,
        .stat-card,
        .bg-white.rounded-3xl,
        .bg-white.rounded-2xl {
            background: var(--app-panel) !important;
            border: 1px solid var(--app-border) !important;
            border-radius: 10px !important;
            box-shadow: 0 7px 20px rgba(15, 23, 42, 0.055) !important;
        }

        .card {
            padding: 22px;
        }

        .stat-card {
            padding: 18px 20px;
        }

        .card:hover,
        .stat-card:hover {
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.08) !important;
        }

        .btn-primary,
        .btn-secondary,
        .btn-danger,
        .btn-edit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 36px;
            padding: 9px 14px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            transition: 0.18s ease;
            white-space: nowrap;
        }

        .btn-primary {
            color: #fff;
            background: var(--app-blue);
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.22);
        }

        .btn-primary:hover {
            background: var(--app-blue-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            color: #334155;
            background: #fff;
            border: 1px solid var(--app-border);
        }

        .btn-secondary:hover {
            color: var(--app-blue);
            border-color: #B8CCF7;
            background: #F7FAFF;
        }

        .btn-edit {
            color: #1D4ED8;
            background: #EAF1FF;
        }

        .btn-edit:hover {
            background: #DBEAFE;
        }

        .btn-danger {
            color: #B91C1C;
            background: #FEE2E2;
        }

        .btn-danger:hover {
            background: #FECACA;
        }

        .input-field,
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="url"],
        select,
        textarea {
            border: 1px solid #D8E2ED !important;
            border-radius: 7px !important;
            background: #fff !important;
            color: var(--app-text) !important;
            transition: border-color 0.18s ease, box-shadow 0.18s ease;
        }

        .input-field:focus,
        input:focus,
        select:focus,
        textarea:focus {
            outline: none !important;
            border-color: var(--app-blue) !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.11) !important;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 800;
            white-space: nowrap;
        }

        .badge-success {
            background: #DCFCE7;
            color: #166534;
        }

        .badge-warning {
            background: #FEF3C7;
            color: #92400E;
        }

        .badge-error {
            background: #FEE2E2;
            color: #991B1B;
        }

        .badge-info {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .badge-replied {
            background: #CCFBF1;
            color: #0F766E;
        }

        .table-wrapper,
        .overflow-x-auto {
            border-radius: 10px;
        }

        table {
            border-collapse: collapse;
        }

        .data-table {
            width: 100%;
        }

        .data-table th,
        table.min-w-full th {
            background: #F6F9FC !important;
            color: #697A91 !important;
            border-bottom: 1px solid var(--app-border) !important;
            padding: 12px 14px !important;
            font-size: 11px !important;
            font-weight: 800 !important;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .data-table td,
        table.min-w-full td {
            border-bottom: 1px solid #EDF2F7 !important;
            padding: 13px 14px !important;
            color: #243247 !important;
            vertical-align: middle;
        }

        .data-table tbody tr:hover,
        table.min-w-full tbody tr:hover {
            background: #F8FBFF !important;
        }

        table thead.bg-slate-900 {
            background: #F6F9FC !important;
        }

        table thead.bg-slate-900 th {
            color: #697A91 !important;
        }

        .alert {
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 18px;
            font-weight: 800;
        }

        .alert-success {
            background: #ECFDF5;
            color: #166534;
            border: 1px solid #BBF7D0;
        }

        .alert-error {
            background: #FEF2F2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        .bg-slate-100 {
            background: transparent !important;
        }

        .text-slate-900 {
            color: var(--app-text) !important;
        }

        .text-slate-500 {
            color: var(--app-muted) !important;
        }

        .rounded-3xl {
            border-radius: 10px !important;
        }

        .rounded-2xl {
            border-radius: 9px !important;
        }

        .shadow-sm {
            box-shadow: 0 7px 20px rgba(15, 23, 42, 0.055) !important;
        }

        .bg-gradient-to-r.from-teal-500,
        .from-teal-500 {
            --tw-gradient-from: #2563EB var(--tw-gradient-from-position) !important;
            --tw-gradient-to: rgb(37 99 235 / 0) var(--tw-gradient-to-position) !important;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to) !important;
        }

        .to-teal-700 {
            --tw-gradient-to: #0EA5E9 var(--tw-gradient-to-position) !important;
        }

        .content-pad img {
            max-width: 100%;
        }

        .content-pad form {
            margin: 0;
        }

        .content-pad [style*="grid-template-columns:1fr 1fr"] {
            align-items: start;
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 999px;
        }

        /* BASE GRID STYLES */
        .kpi-grid {
            display: grid !important;
            grid-template-columns: repeat(4, 1fr) !important;
            gap: 20px !important;
            margin-bottom: 32px !important;
        }

        .recent-grid,
        .charts-grid {
            display: grid !important;
            gap: 24px !important;
        }

        .recent-grid {
            grid-template-columns: 1.15fr 0.85fr !important;
        }

        .blog-editor-grid {
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) 320px !important;
            gap: 24px !important;
            align-items: start !important;
        }

        @media (max-width: 1440px) {
            .app-topbar-right {
                gap: 10px;
            }

            .topbar-search {
                width: min(320px, 30vw);
            }
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 220px;
            }

            .main-content {
                margin-left: 220px;
            }

            .kpi-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 16px !important;
            }

            .recent-grid,
            .charts-grid {
                grid-template-columns: 1fr !important;
            }

            .content-pad {
                padding: 20px 20px !important;
            }

            .page-header {
                padding: 14px 20px;
                min-height: 80px;
            }

            .topbar-search {
                width: min(300px, 28vw);
            }

            .nav-item {
                padding: 8px 10px;
                font-size: 12px;
                gap: 8px;
            }

            .nav-item svg {
                width: 16px;
                height: 16px;
            }

            .page-title {
                font-size: 20px;
            }

            .btn-primary,
            .btn-secondary,
            .btn-danger,
            .btn-edit {
                padding: 8px 12px;
                font-size: 12px;
                min-height: 32px;
            }

            .stat-card {
                padding: 16px 18px;
            }

            .card {
                padding: 18px;
            }
        }

        @media (max-width: 768px) {
            .sidebar-toggle {
                display: inline-grid;
                place-items: center;
            }

            .topbar-search {
                display: none;
            }

            .topbar-pill {
                display: none;
            }

            .topbar-brand {
                font-size: 13px;
                gap: 6px;
            }

            .topbar-brand img {
                width: 28px;
                height: 28px;
            }

            .sidebar {
                width: 100%;
                max-width: 280px;
                transform: translateX(-100%);
                height: 100vh;
                z-index: 200;
                border-right: 1px solid var(--app-border);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.4);
                z-index: 190;
                top: 56px;
            }

            .sidebar-overlay.show {
                display: block;
            }

            .main-content {
                margin-left: 0;
                transition: margin-left 0.24s ease;
            }

            .page-header {
                padding: 14px 16px;
                flex-direction: column;
                align-items: stretch;
                min-height: auto;
                gap: 12px;
                top: 0;
            }

            .content-pad {
                padding: 14px 14px !important;
                margin-top: 0;
            }

            .page-title {
                font-size: 18px;
                margin: 0;
            }

            .kpi-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 12px !important;
                margin-bottom: 20px !important;
            }

            .recent-grid,
            .charts-grid {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
            }

            .blog-editor-grid {
                grid-template-columns: 1fr !important;
            }

            .table-wrapper,
            .overflow-x-auto {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .data-table,
            table.min-w-full {
                min-width: 640px;
                font-size: 12px;
            }

            .content-pad [style*="grid-template-columns:1fr 1fr"],
            .content-pad [style*="grid-template-columns:minmax"] {
                grid-template-columns: 1fr !important;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="number"],
            textarea,
            select {
                font-size: 16px !important;
            }

            .stat-card {
                padding: 14px 16px;
            }

            .card {
                padding: 16px;
            }

            .nav-item {
                padding: 8px 12px;
                font-size: 12px;
                min-height: 40px;
            }

            .btn-primary,
            .btn-secondary,
            .btn-danger,
            .btn-edit {
                padding: 8px 12px;
                font-size: 11px;
                min-height: 32px;
                width: 100%;
            }

            .btn-primary svg,
            .btn-secondary svg,
            .btn-danger svg,
            .btn-edit svg {
                width: 14px;
                height: 14px;
            }

            .badge {
                padding: 4px 8px;
                font-size: 11px;
            }

            .field {
                margin-bottom: 14px;
            }

            .field label {
                font-size: 12px;
            }

            .field input,
            .field textarea,
            .field select {
                min-height: 40px;
                font-size: 16px;
            }

            .blog-form-cols {
                grid-template-columns: 1fr !important;
            }

            [style*="grid-template-columns:"] {
                grid-auto-flow: row;
            }
        }

        @media (max-width: 640px) {
            .app-topbar {
                padding: 0 12px;
                height: 52px;
            }

            .sidebar-toggle {
                width: 32px;
                height: 32px;
            }

            .topbar-brand img {
                width: 24px;
                height: 24px;
            }

            .topbar-brand {
                font-size: 12px;
            }

            .page-title {
                font-size: 16px;
                font-weight: 700;
            }

            .page-header {
                padding: 12px 12px;
                gap: 10px;
                flex-wrap: wrap;
            }

            .content-pad {
                padding: 12px 12px !important;
            }

            .kpi-grid {
                grid-template-columns: 1fr !important;
                gap: 10px !important;
                margin-bottom: 16px !important;
            }

            .stat-card {
                padding: 12px 14px;
            }

            .stat-card strong {
                font-size: 24px;
            }

            .stat-card div:first-child {
                font-size: 10px;
            }

            .card {
                padding: 14px;
                border-radius: 8px;
            }

            .recent-grid,
            .charts-grid {
                gap: 14px !important;
            }

            .btn-primary,
            .btn-secondary,
            .btn-danger,
            .btn-edit {
                padding: 10px 14px;
                font-size: 11px;
                min-height: 36px;
                border-radius: 6px;
                width: auto;
            }

            .btn-primary {
                width: 100%;
            }

            .nav-item {
                padding: 10px 10px;
                font-size: 11px;
                min-height: 36px;
                margin: 2px 4px;
                border-radius: 8px;
            }

            .sidebar {
                max-width: 85vw;
            }

            .field {
                margin-bottom: 12px;
            }

            .field label {
                font-size: 11px;
                font-weight: 600;
            }

            .field input,
            .field textarea,
            .field select {
                min-height: 40px;
                padding: 10px 12px;
                font-size: 14px;
                border-radius: 6px;
            }

            .field input::placeholder,
            .field textarea::placeholder {
                font-size: 13px;
            }

            .badge {
                padding: 3px 6px;
                font-size: 10px;
            }

            .data-table,
            table.min-w-full {
                min-width: 100%;
                font-size: 11px;
            }

            th,
            td {
                padding: 8px 6px !important;
            }

            .app-topbar-left {
                gap: 8px;
            }

            .app-topbar-right {
                gap: 6px;
            }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 14px;
                font-weight: 600;
            }

            .page-header {
                padding: 10px 12px;
                min-height: auto;
                gap: 8px;
            }

            .content-pad {
                padding: 10px 10px !important;
            }

            .kpi-grid {
                grid-template-columns: 1fr !important;
                gap: 8px !important;
            }

            .stat-card {
                padding: 10px 12px;
            }

            .stat-card strong {
                font-size: 20px;
            }

            .stat-card span {
                font-size: 9px;
            }

            .card {
                padding: 12px;
                border-radius: 6px;
            }

            .btn-primary,
            .btn-secondary,
            .btn-danger,
            .btn-edit {
                padding: 8px 12px;
                font-size: 10px;
                min-height: 32px;
            }

            .nav-item {
                padding: 8px 8px;
                font-size: 10px;
                min-height: 32px;
            }

            .nav-item svg {
                width: 14px;
                height: 14px;
            }

            .field input,
            .field textarea,
            .field select {
                min-height: 36px;
                padding: 8px 10px;
                font-size: 14px;
            }

            .badge {
                padding: 2px 4px;
                font-size: 9px;
            }

            th,
            td {
                padding: 6px 4px !important;
            }

            .topbar-brand {
                font-size: 11px;
            }

            .topbar-brand img {
                width: 22px;
                height: 22px;
            }

            .app-topbar {
                padding: 0 8px;
            }

            .sidebar-toggle {
                width: 28px;
                height: 28px;
            }
        }

        @media (max-width: 360px) {
            .page-title {
                font-size: 13px;
            }

            .content-pad {
                padding: 8px 8px !important;
            }

            .card {
                padding: 10px;
                margin-bottom: 10px;
            }

            .btn-primary,
            .btn-secondary {
                padding: 6px 10px;
                font-size: 10px;
                min-height: 28px;
            }

            .field input,
            .field textarea {
                min-height: 32px;
                padding: 6px 8px;
                font-size: 13px;
            }

            .stat-card strong {
                font-size: 18px;
            }

            table {
                font-size: 10px;
            }

            th,
            td {
                padding: 4px 2px !important;
            }
        }

        /* Responsive Grid Helpers */
        [style*="grid-template-columns:minmax(0,1fr) 320px"] {
            grid-template-columns: 1fr !important;
        }

        [style*="grid-template-columns:1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }

        [style*="grid-template-columns:2fr 1fr"] {
            grid-template-columns: 1fr !important;
        }

        [style*="grid-template-columns:1fr 1fr 1fr"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }

        [style*="repeat(4,1fr)"] {
            grid-template-columns: repeat(2, 1fr) !important;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            [style*="grid-template-columns:minmax(0,1fr) 320px"] {
                grid-template-columns: 1fr !important;
            }

            [style*="grid-template-columns:1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }

            [style*="grid-template-columns:2fr 1fr"] {
                grid-template-columns: 1fr !important;
            }

            [style*="grid-template-columns:1fr 1fr 1fr"] {
                grid-template-columns: 1fr !important;
            }

            [style*="repeat(4,1fr)"] {
                grid-template-columns: 1fr !important;
            }

            [style*="repeat("] {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 640px) {
            [style*="gap:24px"] {
                gap: 16px !important;
            }

            [style*="gap:20px"] {
                gap: 12px !important;
            }

            [style*="gap:16px"] {
                gap: 10px !important;
            }

            [style*="padding:42px"] {
                padding: 20px !important;
            }

            [style*="padding:28px"] {
                padding: 16px !important;
            }

            [style*="margin-bottom:32px"] {
                margin-bottom: 20px !important;
            }

            [style*="min-height:620px"] {
                min-height: auto !important;
            }
        }

        @media (max-width: 480px) {
            [style*="gap:24px"] {
                gap: 12px !important;
            }

            [style*="gap:20px"] {
                gap: 10px !important;
            }

            [style*="gap:16px"] {
                gap: 8px !important;
            }

            [style*="padding:"] {
                padding: 14px !important;
            }
        }
    </style>
</head>

<body>