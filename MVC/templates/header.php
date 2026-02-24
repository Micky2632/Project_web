<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Event Registration System</title>
</head>

<body class="bg-gradient-to-br from-[#3b2c44] via-[#5a4768] to-[#1e1b22] text-white">

<div class="flex">

    <!-- ================= Sidebar ================= -->
    <aside class="fixed left-0 top-0 h-screen w-64
                  bg-white/10 backdrop-blur-xl
                  rounded-r-3xl shadow-2xl
                  p-6">

        <!-- Logo -->
        <h1 class="text-xl font-bold mb-10">
            LOGO
        </h1>

        <!-- Menu -->
        <nav class="space-y-3 text-sm">

            <a href="/home"
               class="block px-4 py-3 rounded-xl hover:bg-white/20">
                🔍 กิจกรรม
            </a>

            <a href="/my_event"
               class="block px-4 py-3 rounded-xl hover:bg-white/20">
                📁 กิจกรรมของฉัน
            </a>

            <a href="/myreg_event"
               class="block px-4 py-3 rounded-xl hover:bg-white/20">
                📝 การลงทะเบียนกิจกรรม
            </a>

            <a href="/profile"
               class="block px-4 py-3 rounded-xl hover:bg-white/20">
                👤 โปรไฟล์
            </a>

            <a href="/create_event"
               class="block px-4 py-3 rounded-xl hover:bg-white/20">
                ➕ สร้างกิจกรรม
            </a>

            <a href="/login"
               class="block px-4 py-3 rounded-xl hover:bg-red-400/30 text-red-200">
                🚪 Login
            </a>

            <a href="/register"
               class="block px-4 py-3 rounded-xl hover:bg-red-400/30 text-red-200">
                🚪 สมัครสมาชิก
            </a>

            <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/logout"
               class="block px-4 py-3 rounded-xl hover:bg-red-500/50 text-red-300 border border-red-400/30">
                🔒 ออกจากระบบ
            </a>
            <?php endif; ?>

        </nav>

        <!-- Footer user -->
        <div class="absolute bottom-6 left-6 right-6
                    bg-white/10 rounded-2xl p-3 text-xs text-center">
            Event System © 2026
        </div>

    </aside>

    <!-- ================= Content Wrapper ================= -->
    <div class="ml-64 w-full">