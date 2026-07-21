<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/smtp_mailer.php';

$mail_config = require __DIR__ . '/mail_config.php';

// GET SETTINGS
$website_phone = getSettingValue(
    $conn,
    'site_phone',
    '+91 9417555092'
);

$website_email = getSettingValue(
    $conn,
    'site_email',
    'manisha_guptaus@yahoo.com'
);

$website_address = getSettingValue(
    $conn,
    'site_address',
    'Consultant Internal Medicine Sohana Hospital, Sector 77, Sahibzada Ajit Singh Nagar, Punjab 140308'
);


// SUCCESS FLAG
$form_success = isset($_GET['success']);
$form_error   = '';


// HANDLE FORM SUBMIT
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {

    $name    = trim(strip_tags($_POST['fullName'] ?? ''));
    $email   = trim(strip_tags($_POST['email'] ?? ''));
    $phone   = trim(strip_tags($_POST['phone'] ?? ''));
    $subject = trim(strip_tags($_POST['subject'] ?? 'Appointment Booking'));
    $message = trim(strip_tags($_POST['message'] ?? ''));

    if (empty($name) || empty($email) || empty($phone)) {

        $form_error = 'Please fill all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $form_error = 'Please enter a valid email address.';
    } else {

        $stmt = $conn->prepare("
            INSERT INTO contacts
            (name, email, phone, subject, message, status)
            VALUES (?, ?, ?, ?, ?, 'new')
        ");

        $stmt->bind_param(
            'sssss',
            $name,
            $email,
            $phone,
            $subject,
            $message
        );

        if ($stmt->execute()) {
            $adminSubject = trim(($mail_config['admin_subject_prefix'] ?? 'New contact enquiry') . ': ' . $subject);
            $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
            $safeEmail = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
            $safePhone = htmlspecialchars($phone !== '' ? $phone : 'Not provided', ENT_QUOTES, 'UTF-8');
            $safeSubject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
            $safeMessage = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));
            $submittedAt = date('d M Y, h:i A');

            $adminText = "New contact enquiry received:\n\n"
                . "Name: {$name}\n"
                . "Email: {$email}\n"
                . "Phone: " . ($phone !== '' ? $phone : 'Not provided') . "\n"
                . "Subject: {$subject}\n"
                . "Submitted: {$submittedAt}\n\n"
                . "Message:\n{$message}\n";

            $adminHtml = '<!doctype html><html><body style="margin:0;padding:0;background:#eef6f8;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">'
                . '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#eef6f8;padding:28px 12px;"><tr><td align="center">'
                . '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:640px;background:#ffffff;border-radius:18px;overflow:hidden;border:1px solid #dbeafe;box-shadow:0 14px 38px rgba(15,23,42,0.10);">'
                . '<tr><td style="background:#06364b;padding:28px 32px;color:#ffffff;">'
                . '<div style="font-size:13px;letter-spacing:1.8px;text-transform:uppercase;color:#7dd3fc;font-weight:700;">New Enquiry</div>'
                . '<h1 style="margin:8px 0 0;font-size:26px;line-height:1.25;font-weight:700;">Contact form submission</h1>'
                . '<p style="margin:10px 0 0;color:#dff7fb;font-size:15px;">Dr. Manisha Gupta website</p>'
                . '</td></tr>'
                . '<tr><td style="padding:28px 32px;">'
                . '<p style="margin:0 0 20px;font-size:16px;line-height:1.6;color:#334155;">A new patient/contact enquiry has been submitted from the website.</p>'
                . '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border:1px solid #e2e8f0;border-radius:12px;overflow:hidden;">'
                . '<tr><td style="padding:14px 16px;background:#f8fafc;width:140px;font-weight:700;color:#0f172a;border-bottom:1px solid #e2e8f0;">Name</td><td style="padding:14px 16px;border-bottom:1px solid #e2e8f0;color:#334155;">' . $safeName . '</td></tr>'
                . '<tr><td style="padding:14px 16px;background:#f8fafc;font-weight:700;color:#0f172a;border-bottom:1px solid #e2e8f0;">Email</td><td style="padding:14px 16px;border-bottom:1px solid #e2e8f0;color:#334155;"><a href="mailto:' . $safeEmail . '" style="color:#0284c7;text-decoration:none;">' . $safeEmail . '</a></td></tr>'
                . '<tr><td style="padding:14px 16px;background:#f8fafc;font-weight:700;color:#0f172a;border-bottom:1px solid #e2e8f0;">Phone</td><td style="padding:14px 16px;border-bottom:1px solid #e2e8f0;color:#334155;"><a href="tel:' . $safePhone . '" style="color:#0284c7;text-decoration:none;">' . $safePhone . '</a></td></tr>'
                . '<tr><td style="padding:14px 16px;background:#f8fafc;font-weight:700;color:#0f172a;border-bottom:1px solid #e2e8f0;">Subject</td><td style="padding:14px 16px;border-bottom:1px solid #e2e8f0;color:#334155;">' . $safeSubject . '</td></tr>'
                . '<tr><td style="padding:14px 16px;background:#f8fafc;font-weight:700;color:#0f172a;">Submitted</td><td style="padding:14px 16px;color:#334155;">' . $submittedAt . '</td></tr>'
                . '</table>'
                . '<div style="margin-top:22px;padding:18px 20px;background:#f8fafc;border-left:4px solid #0eadae;border-radius:12px;">'
                . '<div style="font-weight:700;color:#0f172a;margin-bottom:8px;">Message</div>'
                . '<div style="font-size:15px;line-height:1.7;color:#334155;">' . $safeMessage . '</div>'
                . '</div>'
                . '<p style="margin:22px 0 0;font-size:13px;color:#64748b;">You can reply directly to this email to contact the sender.</p>'
                . '</td></tr>'
                . '<tr><td style="background:#f8fafc;padding:18px 32px;color:#64748b;font-size:12px;text-align:center;border-top:1px solid #e2e8f0;">Dr. Manisha Gupta | Website Contact Notification</td></tr>'
                . '</table></td></tr></table></body></html>';

            $visitorText = "Dear {$name},\n\n"
                . "Thank you for contacting Dr. Manisha Gupta. We have received your message and our team will get back to you within 24 hours.\n\n"
                . "Your message:\n{$message}\n\n"
                . "Regards,\nDr. Manisha Gupta";

            $visitorHtml = '<!doctype html><html><body style="margin:0;padding:0;background:#eef6f8;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">'
                . '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#eef6f8;padding:28px 12px;"><tr><td align="center">'
                . '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:640px;background:#ffffff;border-radius:18px;overflow:hidden;border:1px solid #dbeafe;box-shadow:0 14px 38px rgba(15,23,42,0.10);">'
                . '<tr><td style="background:#06364b;padding:30px 32px;color:#ffffff;text-align:center;">'
                . '<div style="font-size:13px;letter-spacing:1.8px;text-transform:uppercase;color:#7dd3fc;font-weight:700;">Message Received</div>'
                . '<h1 style="margin:9px 0 0;font-size:28px;line-height:1.25;font-weight:700;">Thank you for contacting us</h1>'
                . '<p style="margin:10px 0 0;color:#dff7fb;font-size:15px;">Dr. Manisha Gupta</p>'
                . '</td></tr>'
                . '<tr><td style="padding:30px 32px;">'
                . '<p style="margin:0 0 16px;font-size:16px;line-height:1.7;color:#334155;">Dear <strong>' . $safeName . '</strong>,</p>'
                . '<p style="margin:0 0 18px;font-size:16px;line-height:1.7;color:#334155;">Thank you for reaching out. We have received your enquiry and our team will get back to you within 24 hours.</p>'
                . '<div style="padding:18px 20px;background:#f8fafc;border-left:4px solid #0eadae;border-radius:12px;margin:22px 0;">'
                . '<div style="font-size:13px;letter-spacing:1px;text-transform:uppercase;color:#0f766e;font-weight:700;margin-bottom:10px;">Your Submitted Message</div>'
                . '<div style="font-size:15px;line-height:1.7;color:#334155;">' . $safeMessage . '</div>'
                . '</div>'
                . '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;margin-top:18px;">'
                . '<tr><td style="padding:12px 0;color:#64748b;font-size:14px;border-top:1px solid #e2e8f0;">Subject</td><td style="padding:12px 0;color:#0f172a;font-size:14px;font-weight:700;text-align:right;border-top:1px solid #e2e8f0;">' . $safeSubject . '</td></tr>'
                . '<tr><td style="padding:12px 0;color:#64748b;font-size:14px;border-top:1px solid #e2e8f0;">Submitted</td><td style="padding:12px 0;color:#0f172a;font-size:14px;font-weight:700;text-align:right;border-top:1px solid #e2e8f0;">' . $submittedAt . '</td></tr>'
                . '</table>'
                . '<p style="margin:22px 0 0;font-size:15px;line-height:1.7;color:#334155;">Regards,<br><strong>Dr. Manisha Gupta</strong></p>'
                . '</td></tr>'
                . '<tr><td style="background:#f8fafc;padding:18px 32px;color:#64748b;font-size:12px;text-align:center;border-top:1px solid #e2e8f0;">This is an acknowledgement email for your website enquiry.</td></tr>'
                . '</table></td></tr></table></body></html>';

            $smtp_error = '';
            $adminMailSent = smtpSendMail($mail_config, [
                'to_email' => $mail_config['admin_email'] ?? $website_email,
                'to_name' => $mail_config['admin_name'] ?? 'Dr. Manisha Gupta',
                'from_email' => $mail_config['from_email'] ?? $mail_config['username'],
                'from_name' => $mail_config['from_name'] ?? 'Dr. Manisha Gupta',
                'reply_to' => $email,
                'reply_to_name' => $name,
                'subject' => $adminSubject,
                'text' => $adminText,
                'html' => $adminHtml,
            ], $smtp_error);

            $visitorMailSent = false;
            if ($adminMailSent) {
                $visitorMailSent = smtpSendMail($mail_config, [
                    'to_email' => $email,
                    'to_name' => $name,
                    'from_email' => $mail_config['from_email'] ?? $mail_config['username'],
                    'from_name' => $mail_config['from_name'] ?? 'Dr. Manisha Gupta',
                    'reply_to' => $mail_config['admin_email'] ?? $website_email,
                    'reply_to_name' => $mail_config['admin_name'] ?? 'Dr. Manisha Gupta',
                    'subject' => $mail_config['visitor_subject'] ?? 'We received your message - Dr. Manisha Gupta',
                    'text' => $visitorText,
                    'html' => $visitorHtml,
                ], $smtp_error);
            }

            if (!$adminMailSent || !$visitorMailSent) {
                $form_error = 'Your message was saved, but email could not be sent. SMTP error: ' . $smtp_error;
            } else {

                header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
                exit;
            }
        } else {

            $form_error = 'Something went wrong. Please try again.';
        }
    }
}

?>

<?php include 'components/header.php'; ?>

<div class="bg-gray-50">
    <div class="mx-auto bg-white shadow-sm overflow-hidden ">

        <!-- ── HERO SECTION ── -->
        <section class="relative min-h-[260px] sm:min-h-[300px] lg:min-h-[340px] flex items-center overflow-hidden bg-cover bg-center">

            <!-- Background -->
            <div class="absolute inset-0 bg-[#062D42]/95 z-0">
                <div class="absolute inset-0 opacity-30 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 max-w-[1440px] mx-auto px-4 sm:px-6 w-full h-full flex flex-col justify-center pt-20 pb-8">

                <h1 class="text-4xl sm:text-5xl lg:text-7xl font-semibold text-white animate-rise tracking-tight leading-tight">
                    Contact <span class="text-brand-teal">Us</span>
                </h1>

                <div class="h-1.5 w-20 bg-gradient-to-r from-[#008bb7] to-[#14b8a6] mt-3 rounded-full"></div>

                <nav class="mt-5 flex items-center gap-3 text-xs font-medium animate-rise [animation-delay:150ms]">
                    <a href="./" class="text-white/50 hover:text-white transition-colors">Home</a>
                    <span class="text-white/20">/</span>
                    <span class="text-white border-b border-brand-teal/50 pb-0.5">Contact</span>
                </nav>

            </div>

        </section>

        <!-- Brand Stripe -->
        <div class="h-2 w-full bg-gradient-to-r from-[#008bb7] to-[#14b8a6]"></div>

        <!-- ── MAIN CONTACT SECTION ── -->
        <section class="dot-bg pt-8 lg:pt-12 pb-16 lg:pb-24 px-4 relative overflow-hidden">

            <!-- Background Glow -->
            <div class="absolute top-0 left-0 w-96 h-96 bg-[#14b8a6]/10 blur-[120px] rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-[420px] h-[420px] bg-[#008bb7]/10 blur-[120px] rounded-full translate-x-1/3 translate-y-1/3"></div>

            <!-- TOP HEADING -->
            <div class="text-center mb-14 lg:mb-16 px-4 pt-0">
                <div class="text-center mb-10 px-4">
                    <h2 class="section-heading text-4xl md:text-6xl font-semibold leading-tight font-fraunces tracking-tight">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#58A9E2] to-[#064854]">
                            Connect with Us
                        </span>
                    </h2>
                    <div class="w-20 h-1.5 bg-gradient-to-r from-[#74C2F9] to-[#064854] mx-auto mt-5 rounded-full"></div>
                </div>

                <h4 class="mt-5 text-lg md:text-2xl font-medium leading-tight font-fraunces tracking-tight text-[#6E748B]">
                    Your Trusted Clinician for Illness and Long-Term Wellness
                </h4>

                <p class="text-slate-500 text-base md:text-lg leading-8 max-w-4xl mx-auto mt-2">
                    Providing expert care in
                    <span class="text-[#0B6D8E] font-semibold">Cardiology</span>,
                    <span class="text-[#0B6D8E] font-semibold">Diabetology</span>,
                    <span class="text-[#0B6D8E] font-semibold">Gastrointestinal Health</span>,
                    and
                    <span class="text-[#0B6D8E] font-semibold">Thyroid Management</span>
                    with a focus on accurate diagnosis, personalized treatment, and long-term wellness for every patient.
                </p>
            </div>

            <div class="max-w-[1440px] mx-auto sm:px-6 relative z-10">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10">

                    <!-- LEFT FORM -->
                    <div class="relative bg-white rounded-[32px] border-2 border-slate-200 shadow-[0_20px_60px_rgba(2,12,27,0.08)] p-4 sm:p-8 overflow-hidden">

                        <!-- Heading -->
                        <div class="relative z-10 mb-10">
                            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#1D647D] leading-tight whitespace-nowrap">
                                Send Us a Message
                            </h2>
                            <div class="h-1.5 w-20 rounded-full bg-gradient-to-r from-[#008bb7] to-[#14b8a6] mt-5"></div>
                        </div>

                        <!-- SUCCESS -->
                        <?php if ($form_success): ?>
                            <div id="successMsg" style="display:flex;" class="items-start gap-4 p-5 mb-6 rounded-2xl bg-emerald-50 border-2 border-emerald-200">
                                <div class="w-10 h-10 rounded-full bg-emerald-500 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-emerald-800 text-lg">Message Sent Successfully!</p>
                                    <p class="text-emerald-700 text-sm mt-1">Thank you for reaching out. Dr. Manisha's team will get back to you within 24 hours.</p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- ERROR -->
                        <?php if ($form_error): ?>
                            <div class="flex items-center gap-3 p-4 mb-6 rounded-2xl bg-red-50 border-2 border-red-200">
                                <p class="text-red-700 font-medium text-sm"><?php echo htmlspecialchars($form_error); ?></p>
                            </div>
                        <?php endif; ?>

                        <!-- FORM -->
                        <form id="contactForm" method="POST" action="" class="relative z-10 space-y-6">

                            <input type="hidden" name="contact_submit" value="1">

                            <div>
                                <label class="block text-xs font-bold tracking-[0.18em] uppercase text-[#062D42] mb-3">
                                    Name *
                                </label>

                                <input
                                    type="text"
                                    id="fullName"
                                    name="fullName"
                                    placeholder="Enter your full name"
                                    value="<?php echo htmlspecialchars($_POST['fullName'] ?? ''); ?>"
                                    class="form-input w-full h-14 px-5 rounded-2xl border-2 border-slate-300 bg-white text-[#062D42] placeholder:text-slate-400 focus:outline-none focus:border-[#0eadae] focus:ring-4 focus:ring-[#0eadae]/15 transition-all duration-300">
                            </div>

                            <div>
                                <label class="block text-xs font-bold tracking-[0.18em] uppercase text-[#062D42] mb-3">
                                    Email *
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    placeholder="Enter your email address"
                                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                    class="form-input w-full h-14 px-5 rounded-2xl border-2 border-slate-300 bg-white text-[#062D42] placeholder:text-slate-400 focus:outline-none focus:border-[#0eadae] focus:ring-4 focus:ring-[#0eadae]/15 transition-all duration-300">
                            </div>

                            <div>
                                <label class="block text-xs font-bold tracking-[0.18em] uppercase text-[#062D42] mb-3">
                                    Phone Number
                                </label>

                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    placeholder="+91 9417555092"
                                    value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                                    class="form-input w-full h-14 px-5 rounded-2xl border-2 border-slate-300 bg-white text-[#062D42] placeholder:text-slate-400 focus:outline-none focus:border-[#0eadae] focus:ring-4 focus:ring-[#0eadae]/15 transition-all duration-300">
                            </div>

                            <div>
                                <label class="block text-xs font-bold tracking-[0.18em] uppercase text-[#062D42] mb-3">
                                    Subject
                                </label>

                                <select
                                    name="subject"
                                    class="form-input w-full h-14 px-5 rounded-2xl border-2 border-slate-300 bg-white text-[#062D42] focus:outline-none focus:border-[#0eadae] focus:ring-4 focus:ring-[#0eadae]/15 transition-all duration-300">

                                    <option value="" selected disabled>Select Subject</option>

                                    <option>Consultation - Diabetes</option>
                                    <option>Consultation - Thyroid</option>
                                    <option>Consultation - Cardiology</option>
                                    <option>Consultation - Gastric</option>
                                    <option>Appointment Request</option>
                                    <option>Other</option>

                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold tracking-[0.18em] uppercase text-[#062D42] mb-3">
                                    Your Message *
                                </label>

                                <textarea
                                    rows="5"
                                    id="message"
                                    name="message"
                                    placeholder="Write your message here..."
                                    class="form-input w-full px-5 py-4 rounded-2xl border-2 border-slate-300 bg-white text-[#062D42] placeholder:text-slate-400 resize-none focus:outline-none focus:border-[#0eadae] focus:ring-4 focus:ring-[#0eadae]/15 transition-all duration-300"><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                            </div>

                            <div class="py-3">
                                <button type="submit"
                                    class="relative overflow-hidden group rounded-full px-8 py-4
                                           bg-[#042A3F] text-white font-semibold inline-flex items-center justify-center">

                                    <span class="relative z-10 flex items-center gap-3 transition-colors duration-300 group-hover:text-white">
                                        Send Message
                                    </span>

                                    <span class="absolute inset-0 bg-[#0DA4B2]
                                                 translate-x-[-100%] group-hover:translate-x-0
                                                 transition-transform duration-500 ease-out rounded-full"></span>
                                </button>
                            </div>

                        </form>
                    </div>

                    <!-- RIGHT : INFO + MAP -->
                    <div class="flex flex-col gap-4">

                        <!-- CONTACT CARDS -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10 items-stretch">

                            <!-- PHONE -->
                            <div class="contact-card rise rise-1 bg-white border-2 border-slate-200 rounded-2xl p-4 hover:border-[#008bb7] hover:shadow-[0_12px_32px_rgba(0,139,183,0.12)] transition-all duration-300 hover:-translate-y-1 cursor-default">

                                <div class="icon-circle bg-[#eff6ff] shadow-[0_4px_20px_rgba(8,139,183,0.15)] mb-3">
                                    <svg class="w-5 h-5" fill="none" stroke="#008bb7" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                </div>

                                <p class="text-[10px] font-bold tracking-[0.2em] uppercase text-slate-400 mb-1">
                                    Phone
                                </p>

                                <h3 class="text-[#062D42] font-bold text-lg mb-2">
                                    Call Us
                                </h3>

                                <a href="tel:<?php echo htmlspecialchars($website_phone); ?>"
                                    class="text-[#008bb7] font-medium text-sm hover:text-[#0eadae] transition-colors block">

                                    <?php echo htmlspecialchars($website_phone); ?>

                                </a>

                                <p class="text-slate-400 text-xs mt-2">
                                    Your Health, Our Everyday Priority
                                </p>

                            </div>

                            <!-- EMAIL -->
                            <div class="contact-card rise rise-2 bg-white border-2 border-slate-200 rounded-2xl p-4 hover:border-[#0eadae] hover:shadow-[0_12px_32px_rgba(14,173,174,0.12)] transition-all duration-300 hover:-translate-y-1 cursor-default">

                                <div class="icon-circle bg-[#ecfeff] shadow-[0_4px_20px_rgba(14,173,174,0.15)] mb-3">
                                    <svg class="w-5 h-5" fill="none" stroke="#0eadae" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </div>

                                <p class="text-[10px] font-bold tracking-[0.2em] uppercase text-slate-400 mb-1">
                                    Email
                                </p>

                                <h3 class="text-[#062D42] font-bold text-lg mb-2">
                                    Email Us
                                </h3>

                                <a href="mailto:<?php echo htmlspecialchars($website_email); ?>"
                                    class="text-[#0eadae] font-medium text-sm hover:text-[#008bb7] transition-colors break-all block">

                                    <?php echo htmlspecialchars($website_email); ?>

                                </a>

                                <p class="text-slate-400 text-xs mt-2">
                                    We'll reply within 24 hours
                                </p>

                            </div>

                            <!-- ADDRESS -->
                            <div class="contact-card rise rise-3 bg-white border-2 border-slate-200 rounded-2xl p-4 hover:border-[#14b8a6] hover:shadow-[0_12px_32px_rgba(20,184,166,0.12)] transition-all duration-300 hover:-translate-y-1 cursor-default">

                                <div class="icon-circle bg-[#f0fdf4] shadow-[0_4px_20px_rgba(20,184,166,0.12)] mb-3">
                                    <svg class="w-5 h-5" fill="none" stroke="#14b8a6" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                </div>

                                <p class="text-[10px] font-bold tracking-[0.2em] uppercase text-slate-400 mb-1">
                                    Location
                                </p>

                                <h3 class="text-[#062D42] font-bold text-lg mb-2">
                                    Visit Us
                                </h3>

                                <p class="text-slate-600 text-sm leading-relaxed">

                                    <?php echo htmlspecialchars($website_address); ?>

                                </p>

                            </div>
                            
                            <!-- Working Hours -->
                            <div class="contact-card rise rise-4 bg-white border-2 border-slate-200 rounded-2xl p-4 hover:border-[#f59e0b] hover:shadow-[0_12px_32px_rgba(245,158,11,0.12)] transition-all duration-300 hover:-translate-y-1 cursor-default">
                                <div class="icon-circle bg-[#fffbeb] shadow-[0_4px_20px_rgba(245,158,11,0.15)] mb-3">
                                    <svg class="w-5 h-5" fill="none" stroke="#d97706" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>

                                <p class="text-[10px] font-bold tracking-[0.2em] uppercase text-slate-400 mb-1">
                                    Timings
                                </p>

                                <h3 class="text-[#062D42] font-bold text-lg mb-2">
                                    Working Hours
                                </h3>

                                <p class="text-slate-600 text-sm leading-relaxed">
                                    Mon–Sat: 9:00 AM – 3:00 PM
                                </p>

                                <p class="text-slate-400 text-sm mt-2">
                                    Sunday: Closed
                                </p>
                            </div>

                        </div>

                        <!-- MAP -->
                        <div class="rounded-[32px] overflow-hidden border-2 border-slate-200 shadow-[0_20px_60px_rgba(2,12,27,0.08)] h-full min-h-[520px] bg-white p-[4px]">

                            <div class="w-full h-full rounded-[24px] overflow-hidden">

                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d99352.25090295207!2d76.698991!3d30.693959!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390fef7ead35579f%3A0x4f6b020c7d17f8fd!2sSohana%20Cancer%20Research%20Institute!5e1!3m2!1sen!2sin!4v1778676538298!5m2!1sen!2sin"
                                    class="w-full h-full"
                                    style="border:0;"
                                    allowfullscreen=""
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </section>

    </div>
</div>

<?php include 'components/footer.php'; ?>