<?php
require_once 'includes/config.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$MAX_ATTEMPTS = 3;


$locked_email_check = trim($_POST['email'] ?? $_GET['email'] ?? '');
$is_locked_on_load  = false;
if (!empty($locked_email_check)) {
    $db   = getDB();
    $stmt = $db->prepare("SELECT failed_attempts, locked_at, status FROM admins WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $locked_email_check);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if ($row && $row['locked_at'] !== null) {
        $is_locked_on_load = true;
        $error = 'Your account has been locked due to too many failed login attempts. Please contact the administrator to reset your password.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        $db   = getDB();
        $stmt = $db->prepare("SELECT * FROM admins WHERE email = ? LIMIT 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res   = $stmt->get_result();
        $admin = $res->num_rows === 1 ? $res->fetch_assoc() : null;

        // ---- Account locked check ----
        if ($admin && $admin['locked_at'] !== null) {
            $error = 'Your account has been locked due to too many failed login attempts. Please contact the administrator to reset your password.';

            // ---- Inactive account ----
        } elseif ($admin && $admin['status'] !== 'active') {
            $error = 'This account is inactive. Please contact the administrator.';

            // ---- Correct password ----
        } elseif ($admin && password_verify($password, $admin['password'])) {
            // Reset failed attempts on successful login
            $db->query("UPDATE admins SET failed_attempts = 0, locked_at = NULL, last_login = NOW() WHERE id = {$admin['id']}");

            $_SESSION['admin_id']   = $admin['id'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['admin_role'] = $admin['role'];

            header('Location: dashboard.php');
            exit();

            // ---- Wrong password ----
        } else {
            if ($admin) {
                // Increment failed attempts
                $new_attempts = (int)$admin['failed_attempts'] + 1;

                if ($new_attempts >= $MAX_ATTEMPTS) {
                    // Lock the account permanently (until DB reset)
                    $db->query("UPDATE admins SET failed_attempts = $new_attempts, locked_at = NOW() WHERE id = {$admin['id']}");
                    $error = 'Your account has been locked due to too many failed login attempts. Please contact the administrator to reset your password.';
                } else {
                    $remaining = $MAX_ATTEMPTS - $new_attempts;
                    $db->query("UPDATE admins SET failed_attempts = $new_attempts WHERE id = {$admin['id']}");
                    $error = 'Invalid email or password. ' . $remaining . ' attempt' . ($remaining > 1 ? 's' : '') . ' remaining before account lockout.';
                }
            } else {
                // Email not found — generic message (security: don't reveal)
                $error = 'Invalid email or password. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Dr. Manisha Gupta</title>
    <link rel="icon" type="image/png" href="assets/images/manisha.png">
    <link rel="apple-touch-icon" href="assets/images/manisha.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 24px;
            color: #042A3F;
            background:
                linear-gradient(120deg, rgba(4, 42, 63, 0.88), rgba(4, 42, 63, 0.62)),
                url('assets/images/login-bg.jpg') center/cover no-repeat,
                linear-gradient(135deg, #042A3F 0%, #0EADAE 100%);
        }

        .login-shell {
            width: min(1040px, 100%);
            min-height: 620px;
            display: grid;
            grid-template-columns: 1.08fr 0.92fr;
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 26px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.94);
            box-shadow: 0 30px 90px rgba(2, 12, 27, 0.36);
            backdrop-filter: blur(12px);
        }

        .brand-panel {
            position: relative;
            padding: 42px;
            color: #fff;
            background:
                linear-gradient(180deg, rgba(4, 42, 63, 0.18), rgba(4, 42, 63, 0.88)),
                url('assets/images/login-bg.jpg') center/cover no-repeat,
                linear-gradient(135deg, #062D42, #0EADAE);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 620px;
        }

        .brand-panel::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(14, 173, 174, 0.34), transparent 32%);
            pointer-events: none;
        }

        .brand-content {
            position: relative;
            z-index: 1;
        }

        .brand-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.22);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .brand-title {
            max-width: 540px;
            margin: 18px 0 0;
            font-size: clamp(34px, 3.8vw, 48px);
            line-height: 1.1;
            letter-spacing: -0.03em;
            font-weight: 900;
            color: #FEFEFE;
        }

        /* Highlight text */
        .brand-title .font {
            background-color: #FEFEFE;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }

        /* Supporting text */
        .brand-copy {
            margin-top: 14px;
            max-width: 480px;
            font-size: 15px;
            line-height: 1.6;
            color: #FEFEFE;
        }

        .brand-stats {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .brand-stat {
            padding: 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.16);
        }

        .brand-stat strong {
            display: block;
            font-size: 18px;
        }

        .brand-stat span {
            display: block;
            margin-top: 3px;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.72);
        }

        .form-panel {
            padding: 42px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(255, 255, 255, 0.96);
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 30px;
        }

        .profile img {
            width: 62px;
            height: 62px;
            border-radius: 18px;
            object-fit: cover;
            box-shadow: 0 12px 26px rgba(14, 173, 174, 0.18);
        }

        .profile h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 900;
            line-height: 1.15;
            letter-spacing: -0.02em;
        }

        .profile p {
            margin: 5px 0 0;
            color: #64748B;
            font-size: 13px;
            font-weight: 600;
        }

        .error-box {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            padding: 13px 14px;
            margin-bottom: 18px;
            border-radius: 14px;
            color: #991B1B;
            background: #FEF2F2;
            border: 1px solid #FECACA;
            font-size: 13px;
            font-weight: 700;
        }

        .error-box.locked {
            color: #92400E;
            background: #FFFBEB;
            border: 1px solid #FDE68A;
        }

        .field {
            margin-bottom: 17px;
        }

        .field label {
            display: block;
            margin-bottom: 7px;
            color: #042A3F;
            font-size: 13px;
            font-weight: 800;
        }

        .input-wrap {
            position: relative;
        }

        .field input {
            width: 100%;
            height: 50px;
            padding: 0 44px 0 14px;
            border: 1.5px solid #DDE7EE;
            border-radius: 14px;
            outline: none;
            background: #F8FAFC;
            color: #042A3F;
            font-size: 14px;
            transition: 0.2s ease;
        }

        .field input:focus {
            border-color: #0EADAE;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(14, 173, 174, 0.12);
        }

        .field-icon {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748B;
            border: none;
            background: transparent;
            padding: 0;
            cursor: pointer;
            display: grid;
            place-items: center;
        }

        .btn-login {
            width: 100%;
            height: 52px;
            margin-top: 8px;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            color: #fff;
            font-size: 15px;
            font-weight: 800;
            background: linear-gradient(135deg, #0EADAE, #05737C);
            box-shadow: 0 16px 30px rgba(14, 173, 174, 0.22);
            transition: 0.2s ease;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 34px rgba(14, 173, 174, 0.3);
        }

        .login-foot {
            margin-top: 22px;
            color: #64748B;
            font-size: 12px;
            text-align: center;
            line-height: 1.6;
        }

        @media (max-width: 860px) {
            body {
                padding: 14px;
            }

            .login-shell {
                grid-template-columns: 1fr;
                min-height: 0;
            }

            .brand-panel {
                min-height: 320px;
                padding: 28px;
            }

            .brand-stats {
                display: none;
            }

            .form-panel {
                padding: 28px;
            }
        }

        @media (max-width: 640px) {
            body {
                padding: 12px;
            }

            .login-shell {
                grid-template-columns: 1fr;
                border-radius: 16px;
                box-shadow: 0 20px 60px rgba(2, 12, 27, 0.25);
            }

            .brand-panel {
                min-height: 280px;
                padding: 24px;
            }

            .brand-title {
                font-size: 28px;
                margin-top: 20px;
            }

            .brand-copy {
                font-size: 13px;
                margin-top: 14px;
            }

            .form-panel {
                padding: 24px;
            }

            .profile {
                align-items: flex-start;
                margin-bottom: 24px;
            }

            .profile img {
                width: 50px;
                height: 50px;
                border-radius: 12px;
            }

            .profile h1 {
                font-size: 20px;
            }

            .profile p {
                font-size: 12px;
            }

            .field {
                margin-bottom: 14px;
            }

            .field label {
                font-size: 12px;
                margin-bottom: 6px;
            }

            .field input {
                height: 44px;
                font-size: 16px;
                padding: 0 12px;
            }

            .btn-login {
                height: 48px;
                font-size: 14px;
                margin-top: 6px;
            }

            .error-box {
                font-size: 12px;
                padding: 11px 12px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 8px;
            }

            .login-shell {
                border-radius: 12px;
                box-shadow: 0 15px 40px rgba(2, 12, 27, 0.2);
            }

            .brand-panel {
                min-height: 240px;
                padding: 20px;
            }

            .brand-chip {
                font-size: 10px;
                padding: 6px 10px;
            }

            .brand-title {
                font-size: 24px;
                margin-top: 16px;
                max-width: 100%;
            }

            .brand-copy {
                font-size: 12px;
                margin-top: 12px;
                max-width: 100%;
            }

            .form-panel {
                padding: 20px;
            }

            .profile {
                gap: 10px;
                margin-bottom: 20px;
            }

            .profile img {
                width: 44px;
                height: 44px;
                border-radius: 10px;
            }

            .profile h1 {
                font-size: 18px;
            }

            .profile p {
                font-size: 11px;
            }

            .field {
                margin-bottom: 12px;
            }

            .field label {
                font-size: 11px;
            }

            .field input {
                height: 40px;
                font-size: 15px;
                padding: 0 10px;
                border-radius: 10px;
            }

            .btn-login {
                height: 44px;
                font-size: 13px;
                margin-top: 4px;
                border-radius: 10px;
            }

            .error-box {
                font-size: 11px;
                padding: 10px 10px;
                border-radius: 10px;
            }

            .login-foot {
                font-size: 11px;
                margin-top: 16px;
            }
        }

        @media (max-width: 360px) {
            body {
                padding: 6px;
            }

            .login-shell {
                border-radius: 10px;
            }

            .brand-panel {
                min-height: 200px;
                padding: 16px;
            }

            .brand-title {
                font-size: 20px;
            }

            .brand-copy {
                font-size: 11px;
            }

            .form-panel {
                padding: 16px;
            }

            .profile img {
                width: 40px;
                height: 40px;
            }

            .profile h1 {
                font-size: 16px;
            }

            .field input {
                height: 38px;
                font-size: 14px;
            }

            .btn-login {
                height: 40px;
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <main class="login-shell">
        <section class="brand-panel">
            <div class="brand-content">

                <h2 class="brand-title">Your Trusted Clinician for Illness and
                    <span class="font ">Long-Term Wellness</span>
                </h2>
                <p class="brand-copy">
                    Secure access to messages, blogs, website settings, and clinic content for Dr. Manisha Gupta.
                </p>
            </div>
            <div class="brand-stats">
                <div class="brand-stat"><strong>Secure</strong><span>Admin access</span></div>
                <div class="brand-stat"><strong>Fast</strong><span>Clinic workflow</span></div>
                <div class="brand-stat"><strong>Live</strong><span>Website control</span></div>
            </div>
        </section>

        <section class="form-panel">
            <div class="profile">
                <img src="assets/images/manisha.png" alt="Dr. Manisha Gupta">
                <div>
                    <h1>Admin Login</h1>
                    <p>Dr. Manisha Gupta Senior Consultant </p>
                </div>
            </div>

            <?php if ($error): ?>
                <?php $is_locked_msg = (strpos($error, 'locked') !== false); ?>
                <div class="error-box<?php echo $is_locked_msg ? ' locked' : ''; ?>">
                    <?php if ($is_locked_msg): ?>
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width:18px;height:18px;flex-shrink:0;">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    <?php else: ?>
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width:18px;height:18px;flex-shrink:0;">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    <?php endif; ?>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="field">
                    <label for="email">Email Address</label>
                    <div class="input-wrap">
                        <input type="email" id="email" name="email" placeholder="admin@drmanisha.com"
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                        <span class="field-icon">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h16v16H4z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M22 6l-10 7L2 6" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <button type="button" class="field-icon" onclick="togglePass()" title="Show or hide password" aria-label="Show or hide password">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:18px;height:18px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-login">Sign In</button>
            </form>
        </section>
    </main>

    <script>
        function togglePass() {
            const p = document.getElementById('password');
            p.type = p.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>

</html>