<html>
<head>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
<?php include 'header.php'; ?>

<div class="min-h-screen
            bg-gradient-to-br from-[#3b2c44] via-[#7b5b7f] to-black
            text-white p-12">

<h2 class="text-3xl font-bold mb-10">
    จัดการกิจกรรมของฉัน
</h2>


<?php if(isset($_SESSION['msg'])): ?>
<div class="mb-6 bg-white/20 p-3 rounded-xl">
    <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
</div>
<?php endif; ?>


<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

<?php if($data['result'] && $data['result']->num_rows > 0): ?>
    <?php while($row = $data['result']->fetch_object()): ?>

<div class="bg-white/20 backdrop-blur-xl rounded-3xl p-6">

    <h3 class="text-xl font-bold mb-2">
        <?= $row->description ?>
    </h3>

    <p>📍 <?= $row->location ?></p>
    <p>👥 <?= $row->joined ?>/<?= $row->max_people ?></p>

    <hr class="my-4 opacity-30">

    <!-- ===================== -->
    <!-- ⭐ OTP VERIFY FORM -->
    <!-- ===================== -->

    <form method="post" action="/verify_otp" class="flex gap-2 mb-4">

        <input type="hidden" name="event_id" value="<?= $row->event_id ?>">

        <input name="otp"
               maxlength="6"
               placeholder="กรอก OTP"
               class="flex-1 rounded-lg px-3 text-black">

        <button class="bg-green-500 px-4 rounded-lg">
            ยืนยัน
        </button>

    </form>

    <!-- ===================== -->
    <!-- ⭐ REJECT FORM -->
    <!-- ===================== -->

    <form method="post" action="/reject_otp" class="flex gap-2 mb-4">

        <input type="hidden" name="event_id" value="<?= $row->event_id ?>">

        <input name="otp"
               maxlength="6"
               placeholder="OTP ที่จะปฏิเสธ"
               class="flex-1 rounded-lg px-3 text-black">

        <button class="bg-red-500 px-4 rounded-lg">
            ปฏิเสธ
        </button>

    </form>

    <!-- ===================== -->
    <!-- ⭐ รายชื่อ pending -->
    <!-- ===================== -->

    <?php $pending = getPendingUsers($row->event_id); ?>

    <?php if($pending && $pending->num_rows > 0): ?>

    <div class="space-y-2 text-sm mb-4">

        <?php while($p = $pending->fetch_object()): ?>

        <div class="bg-black/30 px-3 py-2 rounded-lg flex justify-between">

            <span><?= $p->name ?></span>
            <span class="text-yellow-300">รอการยืนยัน</span>

        </div>

        <?php endwhile; ?>

    </div>

    <?php else: ?>

    <p class="opacity-60 text-sm mb-4">ไม่มีคนรอยืนยัน</p>

    <?php endif; ?>

    <!-- ===================== -->
    <!-- รายชื่อที่ถูกปฏิเสธ -->
    <!-- ===================== -->

    <?php $rejected = getRejectedUsers($row->event_id); ?>

    <?php if($rejected && $rejected->num_rows > 0): ?>

    <div class="mt-4">
        <h4 class="text-sm font-bold mb-2 text-red-300">ถูกปฏิเสธ</h4>
        <div class="space-y-2 text-sm">

            <?php while($r = $rejected->fetch_object()): ?>

            <div class="bg-red-900/30 px-3 py-2 rounded-lg flex justify-between">

                <span><?= $r->name ?></span>
                <span class="text-red-300">ถูกปฏิเสธ</span>

            </div>

            <?php endwhile; ?>

        </div>
    </div>

    <?php endif; ?>

</div>

<?php endwhile; ?>
<?php else: ?>
    <div class="col-span-full text-center py-12">
        <p class="text-xl opacity-70">คุณยังไม่ได้สร้างกิจกรรมใดๆ</p>
        <a href="/create_event" class="inline-block mt-4 bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-colors">
            สร้างกิจกรรมใหม่
        </a>
    </div>
<?php endif; ?>

</div>
</div>
</body>
</html>