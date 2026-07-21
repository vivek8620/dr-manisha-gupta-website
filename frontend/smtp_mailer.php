<?php

require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function smtpSendMail(array $config, array $mail, &$error = null, &$transcript = null)
{
    $error = null;
    $transcript = [];

    if (empty($config['enabled'])) {
        $error = 'SMTP mail is disabled. Please enable it in mail_config.php.';
        return false;
    }

    $mail_obj = new PHPMailer(true);

    try {
        // SMTP Settings
        $mail_obj->isSMTP();
        $mail_obj->Host = (string)($config['host'] ?? '');
        $mail_obj->Hostname = 'yahoo.com';
        $mail_obj->SMTPAuth = true;
        $mail_obj->Username = (string)($config['username'] ?? '');
        $mail_obj->Password = (string)($config['password'] ?? '');
        
        $encryption = strtolower((string)($config['encryption'] ?? 'tls'));
        if ($encryption === 'ssl') {
            $mail_obj->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mail_obj->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $mail_obj->Port = (int)($config['port'] ?? 587);
        $mail_obj->Timeout = (int)($config['timeout'] ?? 20);

        // Sender Info
        $fromEmail = (string)($mail['from_email'] ?? $config['from_email'] ?? $config['username']);
        $fromName = (string)($mail['from_name'] ?? $config['from_name'] ?? '');
        $mail_obj->setFrom($fromEmail, $fromName);

        // Recipient Info
        $toEmail = (string)($mail['to_email'] ?? '');
        $toName = (string)($mail['to_name'] ?? '');
        $mail_obj->addAddress($toEmail, $toName);

        // Reply To Info (Yahoo SMTP rejects messages containing custom Reply-To headers)
        if (!empty($mail['reply_to']) && filter_var($mail['reply_to'], FILTER_VALIDATE_EMAIL)) {
            if (stripos($config['host'], 'yahoo') === false) {
                $mail_obj->addReplyTo($mail['reply_to'], $mail['reply_to_name'] ?? '');
            }
        }

        // Content
        $mail_obj->isHTML(true);
        $mail_obj->Subject = (string)($mail['subject'] ?? '');
        $mail_obj->Body = (string)($mail['html'] ?? '');
        $mail_obj->AltBody = (string)($mail['text'] ?? '');

        // Capture SMTP Debug for logging/transcript
        $debug_log = '';
        $mail_obj->SMTPDebug = 3;
        $mail_obj->Debugoutput = function ($str, $level) use (&$debug_log, &$transcript) {
            $debug_log .= $str . "\n";
            $transcript[] = ['type' => 'RESPONSE', 'message' => trim($str)];
        };

        $success = $mail_obj->send();
        
        logSmtpTranscript('PHPMailer', $toEmail, $success, null, $transcript);
        
        return $success;

    } catch (Exception $e) {
        $error = $mail_obj->ErrorInfo;
        $transcript[] = ['type' => 'ERROR', 'message' => $error];
        logSmtpTranscript('PHPMailer', $toEmail, false, $error, $transcript);
        return false;
    }
}

function smtpFormatAddress($email, $name = '')
{
    $name = trim((string)$name);
    if ($name === '') {
        return '<' . $email . '>';
    }
    return '=?UTF-8?B?' . base64_encode($name) . '?= <' . $email . '>';
}

function smtpEncodeHeader($value)
{
    $value = trim((string)$value);
    if ($value === '') {
        return '';
    }
    return '=?UTF-8?B?' . base64_encode($value) . '?=';
}

function smtpDotStuff($message)
{
    return $message;
}


// Function to log SMTP transcript to file
function logSmtpTranscript($leg, $toEmail, $success, $error, $transcript)
{
    $logsDir = __DIR__ . '/logs';
    
    // Create logs directory if it doesn't exist
    if (!is_dir($logsDir)) {
        @mkdir($logsDir, 0755, true);
    }

    $logFile = $logsDir . '/smtp_debug_' . date('Y-m-d') . '.log';
    
    $timestamp = date('Y-m-d H:i:s.u');
    $logEntry = "\n" . str_repeat('=', 80) . "\n";
    $logEntry .= "[{$timestamp}] SMTP Email Log - {$leg}\n";
    $logEntry .= str_repeat('=', 80) . "\n";
    $logEntry .= "Recipient: {$toEmail}\n";
    $logEntry .= "Status: " . ($success ? 'SUCCESS ✓' : 'FAILED ✗') . "\n";
    
    if (!$success) {
        $logEntry .= "Error: {$error}\n";
    }
    
    $logEntry .= "\n--- SMTP TRANSCRIPT ---\n";
    
    foreach ($transcript as $line) {
        if (is_array($line)) {
            $logEntry .= "[" . $line['type'] . "]";
            
            if ($line['type'] === 'COMMAND') {
                $logEntry .= " [{$line['step']}] {$line['command']}\n";
            } elseif ($line['type'] === 'RESPONSE') {
                $logEntry .= " {$line['message']}\n";
            } elseif ($line['type'] === 'FAILURE') {
                $logEntry .= " [{$line['step']}] Expected: " . implode(',', $line['expected_codes']) 
                    . " | Got: {$line['received_code']} | Message: {$line['message']}\n";
            } elseif ($line['type'] === 'DATA_START') {
                $logEntry .= " Subject: {$line['subject']}, To: {$line['to_email']}, From: {$line['from_email']}\n";
            } elseif ($line['type'] === 'SUCCESS') {
                $logEntry .= " {$line['message']}\n";
            } else {
                $logEntry .= " {$line['message']}\n";
            }
        }
    }
    
    $logEntry .= "\n";
    
    @file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}