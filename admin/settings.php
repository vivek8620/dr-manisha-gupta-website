<?php
require_once 'includes/config.php';
requireLogin();

$page_title = 'System Settings';
$db = getDB();

$msg = '';
$msg_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    // SAVE SETTINGS
    if ($action === 'save_general') {

        $fields = [
            'site_phone',
            'site_email',
            'site_address'
        ];

        foreach ($fields as $field) {

            $value = trim($_POST[$field] ?? '');

            $stmt = $db->prepare("
                INSERT INTO settings (setting_key, setting_value)
                VALUES (?, ?)
                ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)
            ");

            $stmt->bind_param("ss", $field, $value);
            $stmt->execute();
        }

        $msg = 'Settings updated successfully.';
        $msg_type = 'success';
    }

    // SAVE SOCIAL LINKS
    if ($action === 'save_social') {

        $fields = [
            'social_instagram',
            'social_facebook',
            'social_youtube',
            'social_linkedin'
        ];

        foreach ($fields as $field) {

            $value = trim($_POST[$field] ?? '');

            $stmt = $db->prepare("
                INSERT INTO settings (setting_key, setting_value)
                VALUES (?, ?)
                ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)
            ");

            $stmt->bind_param("ss", $field, $value);
            $stmt->execute();
        }

        $msg = 'Settings updated successfully.';
        $msg_type = 'success';
    }

    // CHANGE PASSWORD
    if ($action === 'change_password') {

        $current_pass = $_POST['current_password'] ?? '';
        $new_pass     = $_POST['new_password'] ?? '';
        $confirm_pass = $_POST['confirm_password'] ?? '';
        $admin_id     = (int) $_SESSION['admin_id'];

        $stmt = $db->prepare("SELECT password FROM admins WHERE id = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        if (!$admin || !password_verify($current_pass, $admin['password'])) {

            $msg = 'Current password is incorrect.';
            $msg_type = 'error';
        } elseif ($new_pass !== $confirm_pass) {

            $msg = 'New passwords do not match.';
            $msg_type = 'error';
        } elseif (strlen($new_pass) < 8) {

            $msg = 'Password must be at least 8 characters.';
            $msg_type = 'error';
        } else {

            $hashed = password_hash($new_pass, PASSWORD_BCRYPT);

            $stmt = $db->prepare("UPDATE admins SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $hashed, $admin_id);
            $stmt->execute();

            $msg = 'Password updated successfully.';
            $msg_type = 'success';
        }
    }
}

$admin_info = getAdminInfo();

$site_phone = getSetting('site_phone', '+91 9417555092');

$site_email = getSetting('site_email', 'manisha_guptaus@yahoo.com');

$site_address = getSetting(
    'site_address',
    'Consultant Internal Medicine Sohana Hospital Sector 77, Sahibzada Ajit Singh Nagar, Punjab 140308, India'
);

$social_instagram = getSetting(
    'social_instagram',
    'https://www.instagram.com/consultantmedicinemanisha/'
);

$social_facebook = getSetting(
    'social_facebook',
    'https://www.facebook.com/manisha.gupta.3956'
);

$social_youtube = getSetting('social_youtube', '');

$social_linkedin = getSetting('social_linkedin', '');

include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="min-h-screen bg-slate-100">

    <!-- PAGE HEADER -->
    <div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

        <div>
            <div class="page-title">
                System Settings
            </div>

            <p style="color:var(--app-muted);font-size:13px;margin:8px 0 0 0;">
                Manage social links and admin security
            </p>
        </div>

    </div>

    <div class="content-pad px-4 sm:px-6 lg:px-8">

        <?php if ($msg): ?>
            <div class="mb-7">

                <div class="<?php echo $msg_type === 'success'
                                ? 'bg-green-50 border-green-200'
                                : 'bg-red-50 border-red-200'; ?> border rounded-2xl p-4 sm:p-5 shadow-sm">

                    <div class="flex items-center gap-3">

                        <div class="<?php echo $msg_type === 'success'
                                        ? 'bg-green-600'
                                        : 'bg-red-600'; ?> w-10 h-10 rounded-xl flex items-center justify-center text-white">

                            <?php if ($msg_type === 'success'): ?>

                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>

                            <?php else: ?>

                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01" />
                                </svg>

                            <?php endif; ?>

                        </div>

                        <div class="font-extrabold text-slate-900">
                            <?php echo htmlspecialchars($msg); ?>
                        </div>

                    </div>

                </div>

            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 lg:gap-7">

            <!-- LEFT -->
            <div class="xl:col-span-2 space-y-7">

                <!-- CONTACT -->
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200">

                    <div class="px-5 sm:px-8 py-5 sm:py-6 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-xl font-extrabold text-slate-900">
                            Contact Details
                        </h2>
                    </div>

                    <form method="POST" class="p-5 sm:p-8">

                        <input type="hidden" name="action" value="save_general">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">
                                    Phone Number
                                </label>

                                <input
                                    type="tel"
                                    name="site_phone"
                                    value="<?php echo htmlspecialchars($site_phone); ?>"
                                    class="w-full h-12 px-4 rounded-2xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 outline-none transition-all">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    name="site_email"
                                    value="<?php echo htmlspecialchars($site_email); ?>"
                                    class="w-full h-12 px-4 rounded-2xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 outline-none transition-all">
                            </div>

                        </div>

                        <div class="mt-6">

                            <label class="block text-sm font-bold text-slate-700 mb-2">
                                Address
                            </label>

                            <textarea
                                name="site_address"
                                rows="2"
                                class="w-full px-4 py-3 rounded-2xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 outline-none transition-all resize-none"><?php echo htmlspecialchars($site_address); ?></textarea>

                        </div>

                        <div class="pt-8">

                            <button
                                type="submit"
                                class="group w-full sm:w-auto px-6 py-3 rounded-[14px] border-0 cursor-pointer text-white text-[15px] font-extrabold bg-[linear-gradient(135deg,_#0EADAE,_#05737C)] shadow-[0_16px_30px_rgba(14,173,174,0.22)] hover:opacity-95 hover:scale-[1.02] transition-all duration-300">

                                Save Contact

                            </button>

                        </div>

                    </form>

                </div>

                <!-- SOCIAL -->
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200">

                    <div class="px-5 sm:px-8 py-5 sm:py-6 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-xl font-extrabold text-slate-900">
                            Social Media Links
                        </h2>
                    </div>

                    <form method="POST" class="p-5 sm:p-8">

                        <input type="hidden" name="action" value="save_social">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">
                                    Instagram URL
                                </label>

                                <input
                                    type="url"
                                    name="social_instagram"
                                    value="<?php echo htmlspecialchars($social_instagram); ?>"
                                    class="w-full h-12 px-4 rounded-2xl border border-slate-200 bg-slate-50">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">
                                    Facebook URL
                                </label>

                                <input
                                    type="url"
                                    name="social_facebook"
                                    value="<?php echo htmlspecialchars($social_facebook); ?>"
                                    class="w-full h-12 px-4 rounded-2xl border border-slate-200 bg-slate-50">
                            </div>

                        </div>

                        <div class="pt-8">

                            <button
                                type="submit"
                                class="group w-full sm:w-auto px-6 py-3 rounded-xl text-white font-extrabold bg-[linear-gradient(135deg,_#0EADAE,_#05737C)]">

                                Save Social Links

                            </button>

                        </div>

                    </form>

                </div>

                <!-- PASSWORD -->
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-slate-200">

                    <div class="px-5 sm:px-8 py-5 sm:py-6 border-b border-slate-200 bg-slate-50">
                        <h2 class="text-xl font-extrabold text-slate-900">
                            Change Password
                        </h2>
                    </div>

                    <form method="POST" class="p-5 sm:p-8">

                        <input type="hidden" name="action" value="change_password">

                        <div class="space-y-6">

    <!-- Current Password -->
    <input
        type="password"
        name="current_password"
        required
        placeholder="Enter current password"
        class="w-full h-12 px-4 rounded-2xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 outline-none transition-all">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">

        <!-- New Password -->
        <input
            type="password"
            name="new_password"
            required
            placeholder="Create new password"
            class="w-full h-12 px-4 rounded-2xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 outline-none transition-all">

        <!-- Confirm Password -->
        <input
            type="password"
            name="confirm_password"
            required
            placeholder="Confirm new password"
            class="w-full h-12 px-4 rounded-2xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 outline-none transition-all">

    </div>

</div>

                        <div class="pt-8">

                            <button
                                type="submit"
                                class="group w-full sm:w-auto px-6 py-3 rounded-xl text-white font-extrabold bg-[linear-gradient(135deg,_#0EADAE,_#05737C)]">

                                Update Password

                            </button>

                        </div>

                    </form>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="space-y-7">

                <!-- PROFILE CARD -->
                <div class="relative overflow-hidden rounded-[32px] bg-white border border-slate-200 shadow-sm">

                    <div class="relative h-40 overflow-hidden">

                        <div class="absolute inset-0 bg-[linear-gradient(135deg,_#0EADAE,_#05737C)]"></div>

                    </div>

                    <div class="relative px-7 pb-7">

                        <div class="-mt-16 flex justify-center">

                            <div class="relative">

                                <div class="p-1.5 rounded-[28px] bg-white shadow-xl">

                                    <img
                                        src="assets/images/manisha.png"
                                        alt="Admin"
                                        class="w-32 h-32 rounded-[24px] object-cover">

                                </div>

                            </div>

                        </div>

                        <div class="text-center mt-6">

                            <h3 class="text-2xl font-black tracking-tight text-slate-800">
                                <?php echo htmlspecialchars($admin_info['full_name'] ?? 'Administrator'); ?>
                            </h3>

                            <p class="text-sm text-slate-500 mt-2 font-medium leading-6">
                                Dr. Manisha Gupta Senior Consultant
                            </p>

                            <div class="mt-5 inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-slate-900 to-slate-700 text-white text-sm font-semibold shadow-lg">

                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>

                                <?php echo htmlspecialchars($admin_info['role'] ?? 'Super Admin'); ?>

                            </div>

                        </div>

                        <div class="grid grid-cols-3 gap-3 mt-8">

                            <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4 text-center">

                                <h4 class="text-lg font-black text-slate-800">
                                    24/7
                                </h4>

                                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mt-1">
                                    Active
                                </p>

                            </div>

                            <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4 text-center">

                                <h4 class="text-lg font-black text-slate-800">
                                    100%
                                </h4>

                                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mt-1">
                                    Secure
                                </p>

                            </div>

                            <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4 text-center">

                                <h4 class="text-lg font-black text-slate-800">
                                    Full
                                </h4>

                                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mt-1">
                                    Access
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>