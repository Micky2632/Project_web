<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include 'header.php'; ?>

<div class="min-h-screen
            bg-gradient-to-br from-[#3b2c44] via-[#7b5b7f] to-black
            text-white p-12">

    <h2 class="text-2xl font-bold mb-8">
        <?= $data['title'] ?>
    </h2>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

        <?php if($data['result'] && $data['result']->num_rows > 0): ?>
            <?php while($row = $data['result']->fetch_object()): ?>

            <div class="bg-white/20 backdrop-blur-xl
                        rounded-3xl shadow-xl overflow-hidden
                        hover:scale-105 transition duration-300">

                <!-- รูป -->
                <?php if($row->image_path): ?>
                    <img src="/<?= $row->image_path ?>"
                         class="w-full h-40 object-cover">
                <?php else: ?>
                    <div class="w-full h-40 bg-gray-300 flex items-center justify-center text-gray-600">
                        ไม่มีรูปภาพ
                    </div>
                <?php endif; ?>

                <!-- เนื้อหา -->
                <div class="p-4 space-y-2">

                    <h3 class="font-bold text-lg">
                        <?= $row->description ?>
                    </h3>

                    <p class="text-sm opacity-80">
                        📍 <?= $row->location ?>
                    </p>

                    <p class="text-sm opacity-80">
                        👥 <?= $row->joined ?>/<?= $row->max_people ?>
                    </p>

                    <!-- status badge -->
                    <?php
                        $color = match($row->status){
                            'open' => 'bg-green-400 text-black',
                            'closed' => 'bg-red-400 text-black',
                            default => 'bg-gray-400 text-black'
                        };
                    ?>

                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold <?= $color ?>">
                        <?= $row->status ?>
                    </span>

                </div>

            </div>

        <?php endwhile; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-12">
                <p class="text-xl opacity-70">คุณยังไม่ได้ลงทะเบียนเข้าร่วมกิจกรรมใดๆ</p>
                <a href="/" class="inline-block mt-4 bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-colors">
                    ดูกิจกรรมทั้งหมด
                </a>
            </div>
        <?php endif; ?>

    </div>

</div>

</div>
</body>
</html>
