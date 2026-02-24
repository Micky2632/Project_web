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
            text-white p-12 flex justify-center">

    <!-- Card -->
    <div class="w-full max-w-3xl
                bg-white/20 backdrop-blur-xl
                rounded-3xl shadow-2xl p-8">

        <h2 class="text-2xl font-bold mb-6">
            สร้างกิจกรรมใหม่
        </h2>

        <form method="POST" enctype="multipart/form-data"
              class="space-y-5">

            <!-- ชื่อกิจกรรม -->
            <div>
                <label class="text-sm">ชื่อกิจกรรม *</label>
                <input name="description"
                       required
                       class="w-full mt-2 px-4 py-3 rounded-xl
                              bg-white/70 text-black outline-none">
            </div>

            <!-- รายละเอียด -->
            <div>
                <label class="text-sm">รายละเอียด *</label>
                <textarea name="detail"
                          rows="4"
                          class="w-full mt-2 px-4 py-3 rounded-xl
                                 bg-white/70 text-black outline-none"></textarea>
            </div>

            <!-- วันที่ -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="text-sm">วันที่เริ่ม *</label>
                    <input type="datetime-local"
                           name="start_date"
                           required
                           class="w-full mt-2 px-4 py-3 rounded-xl
                                  bg-white/70 text-black">
                </div>

                <div>
                    <label class="text-sm">วันที่สิ้นสุด *</label>
                    <input type="datetime-local"
                           name="end_date"
                           required
                           class="w-full mt-2 px-4 py-3 rounded-xl
                                  bg-white/70 text-black">
                </div>

            </div>

            <!-- สถานที่ + จำนวนคน -->
            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="text-sm">สถานที่ *</label>
                    <input name="location"
                           required
                           class="w-full mt-2 px-4 py-3 rounded-xl
                                  bg-white/70 text-black">
                </div>

                <div>
                    <label class="text-sm">จำนวน (คน) *</label>
                    <input type="number"
                           name="max_people"
                           required
                           class="w-full mt-2 px-4 py-3 rounded-xl
                                  bg-white/70 text-black">
                </div>

            </div>

            <!-- รูป -->
            <div>
                <label class="text-sm">รูปภาพกิจกรรม</label>
                <input type="file"
                       name="images[]"
                       multiple
                       accept="image/*"
                       class="w-full mt-2 text-sm">
            </div>

            <!-- Button -->
            <button
                class="w-full bg-purple-600 hover:bg-purple-800
                       py-3 rounded-xl font-bold text-lg">
                สร้างกิจกรรม
            </button>

        </form>
    </div>

</div>

</div>
</body>
</html>