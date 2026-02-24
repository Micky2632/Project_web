<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="flex min-h-screen bg-gradient-to-br from-[#3b2c44] via-[#5a4768] to-[#1e1b22] text-white">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-6">สถิติกิจกรรม: <?= htmlspecialchars($event['description']) ?></h1>
            
            <!-- ข้อมูลทั่วไป -->
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">ข้อมูลกิจกรรม</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p><strong>วันที่เริ่ม:</strong> <?= date('d/m/Y H:i', strtotime($event['start_date'])) ?></p>
                        <p><strong>วันที่สิ้นสุด:</strong> <?= date('d/m/Y H:i', strtotime($event['end_date'])) ?></p>
                        <p><strong>สถานที่:</strong> <?= htmlspecialchars($event['location']) ?></p>
                    </div>
                    <div>
                        <p><strong>จำนวนคนสูงสุด:</strong> <?= $event['max_people'] ?> คน</p>
                        <p><strong>สถานะกิจกรรม:</strong> 
                            <span class="px-2 py-1 rounded text-sm <?= $event['status'] == 'open' ? 'bg-green-500' : 'bg-gray-500' ?>">
                                <?= $event['status'] == 'open' ? 'เปิด' : 'ปิด' ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- สถิติ -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-green-500/20 backdrop-blur-sm rounded-lg p-4 text-center">
                    <h3 class="text-2xl font-bold text-green-300"><?= $stats['confirmed_count'] ?></h3>
                    <p class="text-green-200">ยืนยันแล้ว</p>
                </div>
                <div class="bg-yellow-500/20 backdrop-blur-sm rounded-lg p-4 text-center">
                    <h3 class="text-2xl font-bold text-yellow-300"><?= $stats['pending_count'] ?></h3>
                    <p class="text-yellow-200">รอการยืนยัน</p>
                </div>
                <div class="bg-red-500/20 backdrop-blur-sm rounded-lg p-4 text-center">
                    <h3 class="text-2xl font-bold text-red-300"><?= $stats['rejected_count'] ?></h3>
                    <p class="text-red-200">ถูกปฏิเสธ</p>
                </div>
                <div class="bg-blue-500/20 backdrop-blur-sm rounded-lg p-4 text-center">
                    <h3 class="text-2xl font-bold text-blue-300"><?= $stats['total_count'] ?></h3>
                    <p class="text-blue-200">ทั้งหมด</p>
                </div>
            </div>

            <!-- รายชื่อผู้เข้าร่วม -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- ยืนยันแล้ว -->
                <div class="bg-white/10 backdrop-blur-sm rounded-lg">
                    <div class="bg-green-500 text-white p-4 rounded-t-lg">
                        <h3 class="font-semibold">ยืนยันแล้ว (<?= $stats['confirmed_count'] ?>)</h3>
                    </div>
                    <div class="p-4 max-h-96 overflow-y-auto">
                        <?php if ($confirmed_users->num_rows > 0): ?>
                            <?php while ($user = $confirmed_users->fetch_assoc()): ?>
                                <div class="border-b border-white/20 pb-3 mb-3 last:border-0">
                                    <p class="font-semibold"><?= htmlspecialchars($user['name']) ?></p>
                                    <p class="text-sm text-gray-300"><?= htmlspecialchars($user['email']) ?></p>
                                    <p class="text-xs text-green-300">ยืนยันเมื่อ: <?= date('d/m/Y H:i', strtotime($user['create_date'])) ?></p>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-gray-400 text-center">ยังไม่มีผู้ยืนยัน</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- รอการยืนยัน -->
                <div class="bg-white/10 backdrop-blur-sm rounded-lg">
                    <div class="bg-yellow-500 text-white p-4 rounded-t-lg">
                        <h3 class="font-semibold">รอการยืนยัน (<?= $stats['pending_count'] ?>)</h3>
                    </div>
                    <div class="p-4 max-h-96 overflow-y-auto">
                        <?php if ($pending_users->num_rows > 0): ?>
                            <?php while ($user = $pending_users->fetch_assoc()): ?>
                                <div class="border-b border-white/20 pb-3 mb-3 last:border-0">
                                    <p class="font-semibold"><?= htmlspecialchars($user['name']) ?></p>
                                    <p class="text-sm text-gray-300"><?= htmlspecialchars($user['email']) ?></p>
                                    <p class="text-xs text-yellow-300">OTP: <?= htmlspecialchars($user['otp_code']) ?></p>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-gray-400 text-center">ไม่มีผู้รอการยืนยัน</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- ถูกปฏิเสธ -->
                <div class="bg-white/10 backdrop-blur-sm rounded-lg">
                    <div class="bg-red-500 text-white p-4 rounded-t-lg">
                        <h3 class="font-semibold">ถูกปฏิเสธ (<?= $stats['rejected_count'] ?>)</h3>
                    </div>
                    <div class="p-4 max-h-96 overflow-y-auto">
                        <?php if ($rejected_users->num_rows > 0): ?>
                            <?php while ($user = $rejected_users->fetch_assoc()): ?>
                                <div class="border-b border-white/20 pb-3 mb-3 last:border-0">
                                    <p class="font-semibold"><?= htmlspecialchars($user['name']) ?></p>
                                    <p class="text-sm text-gray-300"><?= htmlspecialchars($user['email']) ?></p>
                                    <p class="text-xs text-red-300">ถูกปฏิเสธเมื่อ: <?= date('d/m/Y H:i', strtotime($user['create_date'])) ?></p>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p class="text-gray-400 text-center">ไม่มีผู้ถูกปฏิเสธ</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <a href="/my_event" class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded transition-colors">
                    กลับไปหน้ากิจกรรมของฉัน
                </a>
            </div>
        </div>
    </div>

</body>

</html>
