<?php
// Test script to verify TOTP configuration

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/totp.php';

echo "=== TOTP Configuration Test ===\n\n";

echo "TOTP_TIME_STEP defined: " . (defined('TOTP_TIME_STEP') ? 'YES' : 'NO') . "\n";
echo "TOTP_TIME_STEP value: " . (defined('TOTP_TIME_STEP') ? TOTP_TIME_STEP : 'not defined') . "\n";
echo "Expected: 1800 (30 minutes)\n\n";

echo "TOTP_SERVER_SALT defined: " . (defined('TOTP_SERVER_SALT') ? 'YES' : 'NO') . "\n";
echo "TOTP_WINDOW defined: " . (defined('TOTP_WINDOW') ? 'YES' : 'NO') . "\n";
echo "TOTP_WINDOW value: " . (defined('TOTP_WINDOW') ? TOTP_WINDOW : 'not defined') . "\n\n";

// Test OTP generation
$event_id = 999;
$user_id = 888;
$otp = generateEventOTP($event_id, $user_id);
echo "Generated OTP: $otp\n";

$remaining = getTOTPRemainingSeconds();
echo "Remaining seconds: $remaining\n";
echo "Remaining minutes: " . round($remaining / 60, 2) . "\n\n";

// Verify the same OTP
$valid = verifyEventOTP($event_id, $user_id, $otp);
echo "OTP verification: " . ($valid ? 'VALID' : 'INVALID') . "\n";

// Check error logs
echo "\nCheck your PHP error log for DEBUG messages\n";
