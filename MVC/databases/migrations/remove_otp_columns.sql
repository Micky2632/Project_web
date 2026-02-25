-- Migration: Remove OTP columns from registrations table
-- ใช้ TOTP Algorithm แทนการเก็บ OTP ใน database
-- Run this in your MySQL database

ALTER TABLE registrations 
    DROP COLUMN IF EXISTS otp_code,
    DROP COLUMN IF EXISTS otp_expire;
