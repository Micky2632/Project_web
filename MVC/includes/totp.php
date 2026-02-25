<?php
/**
 * TOTP (Time-based One-Time Password) Algorithm
 * ไม่ต้องเก็บ OTP ใน database - คำนวณจากเวลา + secret key
 */

/**
 * Generate TOTP secret from event_id + user_id + server salt
 * ใช้สร้าง secret ที่ unique ต่อการลงทะเบียนแต่ละครั้ง
 */
function generateTOTPSecret(int $event_id, int $user_id): string
{
    // ใช้ server salt ที่เปลี่ยนไม่ได้ง่าย (ควรเก็บใน config หรือ environment)
    $server_salt = defined('TOTP_SERVER_SALT') ? TOTP_SERVER_SALT : 'default_salt_change_in_production';
    
    // สร้าง unique string จาก event_id + user_id + salt
    $unique_string = "event:{$event_id}:user:{$user_id}:{$server_salt}";
    
    // Hash ด้วย SHA256 แล้ว base64 encode
    return base64_encode(hash('sha256', $unique_string, true));
}

/**
 * Generate TOTP code 6 หลัก
 * คำนวณจาก secret + current time window (30 วินาที)
 */
function generateTOTP(string $secret, int $time_step = 30, int $digits = 6): string
{
    // คำนวณ time counter (จำนวน time windows ตั้งแต่ Unix epoch)
    $time_counter = floor(time() / $time_step);
    error_log("DEBUG generateTOTP: time_step=$time_step, time_counter=$time_counter");
    
    // แปลง time counter เป็น binary string 8 bytes (64-bit big-endian)
    $time_bytes = pack('N*', 0, $time_counter);
    
    // คำนวณ HMAC-SHA1
    $hmac = hash_hmac('sha1', $time_bytes, base64_decode($secret), true);
    
    // Dynamic truncation (RFC 4226/6238)
    $offset = ord($hmac[19]) & 0x0F;
    $binary = (ord($hmac[$offset]) & 0x7F) << 24 |
              (ord($hmac[$offset + 1]) & 0xFF) << 16 |
              (ord($hmac[$offset + 2]) & 0xFF) << 8 |
              (ord($hmac[$offset + 3]) & 0xFF);
    
    // เอาเฉพาะตัวเลขตามจำนวนหลักที่ต้องการ
    $otp = $binary % (10 ** $digits);
    
    // Pad ด้วย 0 ข้างหน้าให้ครบตามจำนวนหลัก
    return str_pad((string)$otp, $digits, '0', STR_PAD_LEFT);
}

/**
 * Verify TOTP code
 * ตรวจสอบ code ปัจจุบัน และยอมให้มี drift 1-2 time windows (ย้อน/ข้างหน้าได้)
 */
function verifyTOTP(string $secret, string $code, int $time_step = 30, int $window = 1): bool
{
    $time_counter = floor(time() / $time_step);
    
    // ตรวจสอบ code ใน window ปัจจุบัน และย้อนหลัง/ข้างหน้าได้ตาม $window
    for ($i = -$window; $i <= $window; $i++) {
        // Temporarily change time for calculation
        $test_time = ($time_counter + $i) * $time_step;
        $test_counter = floor($test_time / $time_step);
        
        $time_bytes = pack('N*', 0, $test_counter);
        $hmac = hash_hmac('sha1', $time_bytes, base64_decode($secret), true);
        
        $offset = ord($hmac[19]) & 0x0F;
        $binary = (ord($hmac[$offset]) & 0x7F) << 24 |
                  (ord($hmac[$offset + 1]) & 0xFF) << 16 |
                  (ord($hmac[$offset + 2]) & 0xFF) << 8 |
                  (ord($hmac[$offset + 3]) & 0xFF);
        
        $test_otp = str_pad(
            (string)($binary % (10 ** strlen($code))),
            strlen($code),
            '0',
            STR_PAD_LEFT
        );
        
        if (hash_equals($test_otp, $code)) {
            return true;
        }
    }
    
    return false;
}

/**
 * Get remaining seconds for current TOTP window
 * ใช้แสดง countdown ให้ user รู้ว่า OTP จะหมดอายุเมื่อไหร่
 */
function getTOTPRemainingSeconds(): int
{
    $time_step = defined('TOTP_TIME_STEP') ? TOTP_TIME_STEP : 1800;
    $remaining = $time_step - (time() % $time_step);
    error_log("DEBUG getTOTPRemainingSeconds: time_step=$time_step, remaining=$remaining");
    return $remaining;
}

/**
 * Generate OTP for event registration (helper function)
 * ใช้ใน joinEvent แทนการสร้าง random OTP
 */
function generateEventOTP(int $event_id, int $user_id): string
{
    $secret = generateTOTPSecret($event_id, $user_id);
    $time_step = defined('TOTP_TIME_STEP') ? TOTP_TIME_STEP : 1800;
    error_log("DEBUG generateEventOTP: TOTP_TIME_STEP = $time_step");
    return generateTOTP($secret, $time_step);
}

/**
 * Verify OTP for event registration (helper function)
 * ใช้ใน verifyOTP แทนการ query database
 */
function verifyEventOTP(int $event_id, int $user_id, string $code): bool
{
    $secret = generateTOTPSecret($event_id, $user_id);
    $time_step = defined('TOTP_TIME_STEP') ? TOTP_TIME_STEP : 1800;
    $window = defined('TOTP_WINDOW') ? TOTP_WINDOW : 1;
    return verifyTOTP($secret, $code, $time_step, $window);
}

/**
 * Get secret for display (for debugging or QR code generation)
 * ใช้ถ้าต้องการให้ user สแกน QR code ด้วย authenticator app
 */
function getTOTPSecretForDisplay(int $event_id, int $user_id): string
{
    return generateTOTPSecret($event_id, $user_id);
}
