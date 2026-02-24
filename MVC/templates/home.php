<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="flex min-h-screen bg-gradient-to-br from-[#3b2c44] via-[#5a4768] to-[#1e1b22] text-white">

        <main class="flex-1 p-12">

            <h2 class="text-3xl font-bold text-center mb-10">
                กิจกรรมทั้งหมด
            </h2>

            <!-- Search Form -->
            <form method="get" class="mb-10">
                <div class="flex flex-col md:flex-row gap-4 justify-center items-end max-w-4xl mx-auto">
                    <div class="flex-1 w-full">
                        <label class="block text-sm mb-2">ค้นหาชื่อกิจกรรม</label>
                        <input type="text" name="keyword" 
                               value="<?= htmlspecialchars($data['keyword'] ?? '') ?>"
                               placeholder="พิมพ์ชื่อกิจกรรม..."
                               class="w-full p-3 rounded-xl bg-white/20 border border-white/30 text-white placeholder-white/50">
                    </div>
                    <div class="w-full md:w-48">
                        <label class="block text-sm mb-2">วันเริ่มต้น</label>
                        <input type="date" name="start" 
                               value="<?= $data['start_date'] ?? '' ?>"
                               class="w-full p-3 rounded-xl bg-white/20 border border-white/30 text-white">
                    </div>
                    <div class="w-full md:w-48">
                        <label class="block text-sm mb-2">วันสิ้นสุด</label>
                        <input type="date" name="end" 
                               value="<?= $data['end_date'] ?? '' ?>"
                               class="w-full p-3 rounded-xl bg-white/20 border border-white/30 text-white">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-purple-600 hover:bg-purple-700 px-6 py-3 rounded-xl font-bold">
                            ค้นหา
                        </button>
                        <a href="/home" class="bg-gray-600 hover:bg-gray-700 px-4 py-3 rounded-xl">
                            รีเซ็ต
                        </a>
                    </div>
                </div>
            </form>

            <!-- Debug: แสดง session msg -->
            <?php if (isset($_SESSION['msg'])): ?>
                <div class="mb-4 bg-red-500/50 p-3 rounded text-center">
                    <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
                </div>
            <?php endif; ?>

            <?php if ($data['result'] && $data['result']->num_rows > 0): ?>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

                    <?php while ($row = $data['result']->fetch_object()): ?>

                        <div class="bg-white/20 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden">

                            <!-- รูป -->
                            <?php if (!empty($row->image_path)): ?>
                                <img src="/<?= $row->image_path ?>" class="h-48 w-full object-cover">
                            <?php else: ?>
                                <div class="h-48 bg-gray-600 flex items-center justify-center">
                                    ไม่มีรูป
                                </div>
                            <?php endif; ?>


                            <div class="p-5 space-y-2">

                                <h3 class="font-bold text-lg">
                                    <?= $row->description ?>
                                </h3>

                                <p>📍 <?= $row->location ?></p>
                                <p>👥 <?= $row->joined ?>/<?= $row->max_people ?></p>


                                <!-- ปุ่มสมัคร -->
                                <div class="mt-4 space-y-2">

                                    <!-- ปุ่มดูรายละเอียด -->
                                    <a href="/event_detail?id=<?= $row->event_id ?>" 
                                       class="block w-full bg-blue-500 text-center py-2 rounded-xl hover:bg-blue-600">
                                        ดูรายละเอียด
                                    </a>

                                    <?php if (!isset($_SESSION['user_id'])): ?>

                                        <span class="text-yellow-300">กรุณา login</span>

                                    <?php elseif (($row->my_status ?? null) === 'pending'): ?>
                                        <span class="text-yellow-400">รอการอนุมัติ</span>

                                        <form action="/show_otp" method="get">
                                            <input type="hidden" name="event_id" value="<?= $row->event_id ?>">

                                            <button class="w-full bg-yellow-500 py-2 rounded-xl hover:bg-yellow-600">
                                                ดู OTP อีกครั้ง
                                            </button>
                                        </form>

                                    <?php elseif (($row->my_status ?? null) === 'confirmed'): ?>
                                        <span class="text-green-400">สมัครแล้ว</span>
                                    <?php elseif ($row->status !== 'open'): ?>

                                        <span class="text-red-400">ปิดรับสมัคร</span>

                                    <?php elseif ($row->joined >= $row->max_people): ?>

                                        <span class="text-orange-400">เต็มแล้ว</span>

                                    <?php else: ?>

                                        <form action="/join_event" method="post">
                                            <input type="hidden" name="event_id" value="<?= $row->event_id ?>">

                                            <button class="w-full bg-purple-600 py-2 rounded-xl hover:bg-purple-800">
                                                ลงทะเบียน
                                            </button>
                                        </form>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                    <?php endwhile; ?>

                </div>

            <?php else: ?>
                <p class="text-center">ยังไม่มีกิจกรรม</p>
            <?php endif; ?>

        </main>
    </div>


    <!-- ========================================= -->
    <!-- ⭐ OTP MODAL -->
    <!-- ========================================= -->

    <?php if (isset($_SESSION['otp'])): ?>

        <div id="otpModal"
            class="fixed inset-0 bg-black/70 flex items-center justify-center z-50">

            <div class="bg-white text-black rounded-2xl p-10 w-[380px] text-center shadow-2xl">

                <h2 class="text-xl font-bold mb-4">รหัส OTP ของคุณ</h2>

                <!-- OTP -->
                <div class="text-4xl font-bold tracking-widest text-purple-600 mb-4">
                    <?= $_SESSION['otp'] ?>
                </div>

                <!-- ⭐ เวลา -->
                <div class="text-red-500 font-semibold mb-4">
                    หมดอายุใน <span id="timer">30:00</span> นาที
                </div>

                <button onclick="copyOTP()"
                    class="bg-green-500 text-white px-4 py-2 rounded mb-3 w-full">
                    คัดลอก OTP
                </button>

                <button onclick="closeOTP()"
                    class="bg-purple-600 text-white px-6 py-2 rounded w-full">
                    ปิด
                </button>

            </div>
        </div>

        <script>
            let seconds = 1800; // ⭐ 30 นาที = 1800 วินาที
            const timerEl = document.getElementById("timer");

            function formatTime(sec) {
                let m = Math.floor(sec / 60);
                let s = sec % 60;
                return String(m).padStart(2, '0') + ":" + String(s).padStart(2, '0');
            }

            timerEl.textContent = formatTime(seconds);

            const countdown = setInterval(() => {
                seconds--;
                timerEl.textContent = formatTime(seconds);

                if (seconds <= 0) {
                    clearInterval(countdown);
                    closeOTP();
                    alert("OTP หมดอายุแล้ว กรุณาขอใหม่");
                }
            }, 1000);

            function closeOTP() {
                document.getElementById('otpModal').style.display = 'none';
            }

            function copyOTP() {
                navigator.clipboard.writeText('<?= $_SESSION['otp'] ?>');
                alert("คัดลอกแล้ว");
            }
        </script>

        <?php unset($_SESSION['otp']); ?>
    <?php endif; ?>

</body>

</html>