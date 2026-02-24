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

            </div>

        </div>

    </div>
</body>
</html>
