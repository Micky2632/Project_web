<html>
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="min-h-screen bg-gradient-to-br from-[#3b2c44] via-[#5a4768] to-[#1e1b22] text-white p-12">

        <div class="max-w-4xl mx-auto">

            <!-- กลับไปหน้า home -->
            <a href="/home" class="text-blue-400 hover:text-blue-300 mb-6 inline-block">
                ← กลับไปหน้ากิจกรรมทั้งหมด
            </a>

            <h2 class="text-3xl font-bold mb-6">
                <?= $data['event']['description'] ?>
            </h2>

            <!-- รายละเอียดกิจกรรม -->
            <div class="bg-white/20 backdrop-blur-xl rounded-3xl p-8 space-y-6">

                <!-- คนสร้าง -->
                <div class="flex items-center gap-4 border-b border-white/20 pb-4">
                    <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center text-xl">
                        👤
                    </div>
                    <div>
                        <p class="text-sm text-gray-300">ผู้จัดกิจกรรม</p>
                        <p class="font-semibold"><?= $data['event']['creator_name'] ?></p>
                        <p class="text-sm text-gray-400"><?= $data['event']['creator_email'] ?></p>
                    </div>
                </div>

                <!-- เวลา -->
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-xl">
                        📅
                    </div>
                    <div>
                        <p class="text-sm text-gray-300">เวลาเริ่ม</p>
                        <p class="font-semibold"><?= $data['event']['start_date'] ?></p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center text-xl">
                        🕐
                    </div>
                    <div>
                        <p class="text-sm text-gray-300">เวลาจบ</p>
                        <p class="font-semibold"><?= $data['event']['end_date'] ?></p>
                    </div>
                </div>

                <!-- สถานที่ -->
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-xl">
                        📍
                    </div>
                    <div>
                        <p class="text-sm text-gray-300">สถานที่</p>
                        <p class="font-semibold"><?= $data['event']['location'] ?></p>
                    </div>
                </div>

                <!-- จำนวนคน -->
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center text-xl">
                        👥
                    </div>
                    <div>
                        <p class="text-sm text-gray-300">จำนวนผู้เข้าร่วม</p>
                        <p class="font-semibold">
                            <?= $data['event']['joined'] ?> / <?= $data['event']['max_people'] ?> คน
                        </p>
                    </div>
                </div>

                <!-- สถานะ -->
                <div class="flex items-center gap-4 border-t border-white/20 pt-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-xl 
                        <?= $data['event']['status'] === 'open' ? 'bg-green-500' : 'bg-red-500' ?>">
                        <?= $data['event']['status'] === 'open' ? '✅' : '❌' ?>
                    </div>
                    <div>
                        <p class="text-sm text-gray-300">สถานะ</p>
                        <p class="font-semibold">
                            <?= $data['event']['status'] === 'open' ? 'เปิดรับสมัคร' : 'ปิดรับสมัคร' ?>
                        </p>
                    </div>
                </div>

                <!-- สถิติการเข้าร่วม -->
                <div class="border-t border-white/20 pt-4">
                    <p class="text-sm text-gray-300 mb-3">สถิติการเข้าร่วม</p>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-green-500/20 rounded-xl p-3 text-center">
                            <p class="text-2xl font-bold text-green-300"><?= $data['stats']['confirmed_count'] ?></p>
                            <p class="text-xs text-green-200">ยืนยันแล้ว</p>
                        </div>
                        <div class="bg-yellow-500/20 rounded-xl p-3 text-center">
                            <p class="text-2xl font-bold text-yellow-300"><?= $data['stats']['pending_count'] ?></p>
                            <p class="text-xs text-yellow-200">รอการยืนยัน</p>
                        </div>
                        <div class="bg-red-500/20 rounded-xl p-3 text-center">
                            <p class="text-2xl font-bold text-red-300"><?= $data['stats']['rejected_count'] ?></p>
                            <p class="text-xs text-red-200">ถูกปฏิเสธ</p>
                        </div>
                    </div>
                </div>

                <!-- สถิติช่วงอายุ -->
                <div class="border-t border-white/20 pt-4">
                    <p class="text-sm text-gray-300 mb-3">สถิติช่วงอายุ (ผู้ยืนยันแล้ว)</p>
                    <div class="grid grid-cols-5 gap-2">
                        <div class="bg-purple-500/20 rounded-lg p-2 text-center">
                            <p class="text-xl font-bold text-purple-300"><?= $data['ageStats']['under_18'] ?></p>
                            <p class="text-xs text-purple-200">< 18</p>
                        </div>
                        <div class="bg-blue-500/20 rounded-lg p-2 text-center">
                            <p class="text-xl font-bold text-blue-300"><?= $data['ageStats']['18_25'] ?></p>
                            <p class="text-xs text-blue-200">18-25</p>
                        </div>
                        <div class="bg-indigo-500/20 rounded-lg p-2 text-center">
                            <p class="text-xl font-bold text-indigo-300"><?= $data['ageStats']['26_35'] ?></p>
                            <p class="text-xs text-indigo-200">26-35</p>
                        </div>
                        <div class="bg-pink-500/20 rounded-lg p-2 text-center">
                            <p class="text-xl font-bold text-pink-300"><?= $data['ageStats']['36_50'] ?></p>
                            <p class="text-xs text-pink-200">36-50</p>
                        </div>
                        <div class="bg-orange-500/20 rounded-lg p-2 text-center">
                            <p class="text-xl font-bold text-orange-300"><?= $data['ageStats']['over_50'] ?></p>
                            <p class="text-xs text-orange-200">50+</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</body>
</html>
