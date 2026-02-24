<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title><?= $data['title'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="min-h-screen bg-gradient-to-br from-[#3b2c44] via-[#5a4768] to-[#1e1b22] text-white p-12">

        <div class="max-w-2xl mx-auto">

            <a href="/profile" class="text-blue-400 hover:text-blue-300 mb-6 inline-block">
                ← กลับไปหน้าโปรไฟล์
            </a>

            <h2 class="text-3xl font-bold mb-8">แก้ไขกิจกรรม</h2>

            <?php if (isset($_SESSION['msg'])): ?>
                <div class="mb-6 bg-red-500/50 p-3 rounded-xl text-center">
                    <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
                </div>
            <?php endif; ?>

            <form method="post" class="bg-white/20 backdrop-blur-xl rounded-3xl p-8 space-y-6">

                <!-- ชื่อกิจกรรม -->
                <div>
                    <label class="block text-sm mb-2">ชื่อกิจกรรม</label>
                    <input type="text" name="description" 
                           value="<?= htmlspecialchars($data['event']['description']) ?>"
                           class="w-full p-3 rounded-xl bg-white/10 border border-white/30 text-white placeholder-white/50"
                           required>
                </div>

                <!-- เวลา -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm mb-2">วันที่เริ่ม</label>
                        <input type="datetime-local" name="start_date" 
                               value="<?= str_replace(' ', 'T', $data['event']['start_date']) ?>"
                               class="w-full p-3 rounded-xl bg-white/10 border border-white/30 text-white"
                               required>
                    </div>
                    <div>
                        <label class="block text-sm mb-2">วันที่จบ</label>
                        <input type="datetime-local" name="end_date" 
                               value="<?= str_replace(' ', 'T', $data['event']['end_date']) ?>"
                               class="w-full p-3 rounded-xl bg-white/10 border border-white/30 text-white"
                               required>
                    </div>
                </div>

                <!-- สถานที่ -->
                <div>
                    <label class="block text-sm mb-2">สถานที่</label>
                    <input type="text" name="location" 
                           value="<?= htmlspecialchars($data['event']['location']) ?>"
                           class="w-full p-3 rounded-xl bg-white/10 border border-white/30 text-white placeholder-white/50"
                           required>
                </div>

                <!-- จำนวนคน -->
                <div>
                    <label class="block text-sm mb-2">จำนวนคนสูงสุด</label>
                    <input type="number" name="max_people" min="1"
                           value="<?= $data['event']['max_people'] ?>"
                           class="w-full p-3 rounded-xl bg-white/10 border border-white/30 text-white"
                           required>
                </div>

                <!-- สถานะ -->
                <div>
                    <label class="block text-sm mb-2">สถานะ</label>
                    <select name="status" 
                            class="w-full p-3 rounded-xl bg-white/10 border border-white/30 text-black">
                        <option value="open" <?= $data['event']['status'] === 'open' ? 'selected' : '' ?>>เปิดรับสมัคร</option>
                        <option value="closed" <?= $data['event']['status'] === 'closed' ? 'selected' : '' ?>>ปิดรับสมัคร</option>
                    </select>
                </div>

                <!-- ปุ่ม -->
                <div class="flex gap-4 pt-4">
                    <button type="submit" 
                            class="flex-1 bg-green-500 hover:bg-green-600 py-3 rounded-xl font-bold">
                        บันทึก
                    </button>
                    <a href="/profile" 
                       class="flex-1 bg-gray-500 hover:bg-gray-600 py-3 rounded-xl font-bold text-center">
                        ยกเลิก
                    </a>
                </div>

            </form>

        </div>

    </div>
</body>
</html>
