<?php
/**
 * Configuration file for TOTP
 * กำหนดค่าคงที่สำหรับ TOTP Algorithm
 */

// Server salt สำหรับ generate TOTP secret (ควรเปลี่ยนเป็น random string ยาวๆ ใน production)
define('TOTP_SERVER_SALT', 'YourRandomSaltStringHereChangeThisInProduction123456789');

// Time step สำหรับ TOTP (30 นาที = 1800 วินาที)
define('TOTP_TIME_STEP', 1800);

// Number of digits สำหรับ TOTP (default 6 หลัก)
define('TOTP_DIGITS', 6);

// Verification window (ยอมให้ drift +/- N time steps)
define('TOTP_WINDOW', 1);
