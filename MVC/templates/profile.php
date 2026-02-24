<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    
<?php include 'header.php'; ?>

<div class="min-h-screen
            bg-gradient-to-br from-[#3b2c44] via-[#7b5b7f] to-black
            text-white p-12">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- ================= LEFT : PROFILE CARD ================= -->
        <?php 
        $userRow = null;
        if ($data['user'] && $data['user']->num_rows > 0) {
            $userRow = $data['user']->fetch_object();
        }
        
        if ($userRow):
        ?>

        <div class="space-y-6">

            <!-- Profile Card -->
            <div class="bg-white/20 backdrop-blur-xl rounded-3xl shadow-2xl p-8 text-center">

                <!-- Avatar -->
                <div class="w-24 h-24 bg-gray-300 rounded-full mx-auto mb-4"></div>

                <h2 class="text-xl font-bold"><?= $userRow->full_name ?></h2>
                <p class="text-sm opacity-70"><?= $userRow->email ?></p>

                <hr class="my-5 border-white/30">

                <div class="text-sm space-y-2 text-left">
                    <p>🎂 Birthday : <?= $userRow->birth_date ?></p>
                    <p>⚧ Gender : <?= $userRow->gender ?></p>
                    <p>📱 Phone : <?= $userRow->phone_number ?></p>
                </div>

                <button
                    class="mt-6 w-full bg-white/30 hover:bg-white/40 py-2 rounded-xl">
                    EDIT PROFILE
                </button>
            </div>

            <!-- Stats -->
            <?php 
            $createdCount = $data['myEvents'] ? $data['myEvents']->num_rows : 0;
            $regCount = $data['myRegEvents'] ? $data['myRegEvents']->num_rows : 0;
            ?>
            <div class="flex gap-4">

                <div class="flex-1 bg-yellow-400 text-black rounded-2xl p-4 text-center font-bold">
                    <?= $createdCount ?>
                    <p class="text-xs">EVENTS CREATED</p>
                </div>

                <div class="flex-1 bg-cyan-400 text-black rounded-2xl p-4 text-center font-bold">
                    <?= $regCount ?>
                    <p class="text-xs">REGISTRATIONS</p>
                </div>

            </div>

        </div>

        <!-- ================= RIGHT : MY EVENTS ================= -->
        <div class="lg:col-span-2 space-y-6">

            <!-- กิจกรรมที่ฉันสร้าง -->
            <div>
                <h2 class="text-xl font-bold mb-4">กิจกรรมที่ฉันสร้าง</h2>
                
                <?php if ($data['myEvents'] && $data['myEvents']->num_rows > 0): ?>
                    <div class="space-y-3">
                        <?php while ($event = $data['myEvents']->fetch_object()): ?>
                            <div class="bg-white/20 backdrop-blur-xl rounded-3xl p-5 flex items-center gap-6 shadow-xl">
                                
                                <img src="<?= !empty($event->image_path) ? '/' . $event->image_path : '/assets/default.jpg' ?>"
                                     class="w-40 h-24 object-cover rounded-xl">

                                <div class="flex-1">
                                    <h3 class="font-bold"><?= $event->description ?></h3>
                                    <p class="text-sm opacity-70">📍 <?= $event->location ?></p>
                                    <p class="text-sm opacity-70">👥 <?= $event->joined ?>/<?= $event->max_people ?></p>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <a href="/event_detail?id=<?= $event->event_id ?>" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-full text-sm text-center">
                                        ดูรายละเอียด
                                    </a>
                                    <a href="/edit_event?id=<?= $event->event_id ?>" 
                                       class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-1 rounded-full text-sm text-center">
                                        แก้ไข
                                    </a>
                                    <a href="/delete_event?id=<?= $event->event_id ?>" 
                                       onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบกิจกรรมนี้?')"
                                       class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded-full text-sm text-center">
                                        ลบ
                                    </a>
                                    <span class="<?= $event->status === 'open' ? 'bg-green-400' : 'bg-red-400' ?> text-black px-4 py-1 rounded-full text-sm text-center">
                                        <?= $event->status ?>
                                    </span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p class="opacity-60">ยังไม่มีกิจกรรมที่สร้าง</p>
                <?php endif; ?>
            </div>

            <!-- กิจกรรมที่ฉันเข้าร่วม -->
            <div>
                <h2 class="text-xl font-bold mb-4">กิจกรรมที่ฉันเข้าร่วม</h2>
                
                <?php if ($data['myRegEvents'] && $data['myRegEvents']->num_rows > 0): ?>
                    <div class="space-y-3">
                        <?php while ($event = $data['myRegEvents']->fetch_object()): ?>
                            <div class="bg-white/20 backdrop-blur-xl rounded-3xl p-5 flex items-center gap-6 shadow-xl">
                                
                                <img src="<?= !empty($event->image_path) ? '/' . $event->image_path : '/assets/default.jpg' ?>"
                                     class="w-40 h-24 object-cover rounded-xl">

                                <div class="flex-1">
                                    <h3 class="font-bold"><?= $event->description ?></h3>
                                    <p class="text-sm opacity-70">📍 <?= $event->location ?></p>
                                    <p class="text-sm opacity-70">👥 <?= $event->joined ?>/<?= $event->max_people ?></p>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <a href="/event_detail?id=<?= $event->event_id ?>" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-full text-sm text-center">
                                        ดูรายละเอียด
                                    </a>
                                    <?php 
                                    $statusClass = match($event->reg_status) {
                                        'confirmed' => 'bg-green-400',
                                        'pending' => 'bg-yellow-400',
                                        'rejected' => 'bg-red-400',
                                        default => 'bg-gray-400'
                                    };
                                    $statusText = match($event->reg_status) {
                                        'confirmed' => 'สมัครแล้ว',
                                        'pending' => 'รออนุมัติ',
                                        'rejected' => 'ถูกปฏิเสธ',
                                        default => 'ไม่ทราบสถานะ'
                                    };
                                    ?>
                                    <span class="<?= $statusClass ?> text-black px-4 py-1 rounded-full text-sm text-center">
                                        <?= $statusText ?>
                                    </span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p class="opacity-60">ยังไม่มีกิจกรรมที่เข้าร่วม</p>
                <?php endif; ?>
            </div>

            <!-- Logout -->
            <div class="mt-8 text-right">
                <a href="/logout"
                   class="bg-red-500 hover:bg-red-600 px-6 py-2 rounded-xl font-bold">
                    LOGOUT
                </a>
            </div>

        </div>

        <?php else: ?>
            <p>ยังไม่ได้เข้าสู่ระบบ หรือไม่พบข้อมูล</p>
        <?php endif; ?>

    </div>

</div>

</div>
</body>
</html>