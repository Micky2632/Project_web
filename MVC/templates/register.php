<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center
             bg-gradient-to-br from-[#3b2c44] via-[#7b5b7f] to-black text-white">

    <!-- Card -->
    <div class="w-[420px] bg-white/20 backdrop-blur-xl
                rounded-3xl shadow-2xl p-8 border border-white/30">

        <h2 class="text-2xl font-bold text-center mb-6">
            สมัครสมาชิก
        </h2>

        <!-- Error -->
        <?php if(isset($error)): ?>
            <div class="bg-red-400/80 text-black text-sm p-2 rounded-lg mb-4">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="/register" method="post" class="space-y-4">

            <!-- Email -->
            <input type="email" name="email" placeholder="Email"
                   required
                   class="w-full px-4 py-2 rounded-xl bg-white/80 text-black outline-none">

            <!-- Name -->
            <input type="text" name="full_name" placeholder="ชื่อ-นามสกุล"
                   required
                   class="w-full px-4 py-2 rounded-xl bg-white/80 text-black outline-none">

            <!-- Password -->
            <input type="password" name="password" placeholder="รหัสผ่าน"
                   required
                   class="w-full px-4 py-2 rounded-xl bg-white/80 text-black outline-none">

            <!-- Confirm -->
            <input type="password" name="confirm_password" placeholder="ยืนยันรหัสผ่าน"
                   required
                   class="w-full px-4 py-2 rounded-xl bg-white/80 text-black outline-none">

            <!-- Gender + Birth -->
            <div class="grid grid-cols-2 gap-3">

                <select name="gender" required
                        class="px-4 py-2 rounded-xl bg-white/80 text-black">
                    <option value="">เพศ</option>
                    <option value="male">ชาย</option>
                    <option value="female">หญิง</option>
                    <option value="other">อื่นๆ</option>
                </select>

                <input type="date" name="birth_date" required
                       class="px-4 py-2 rounded-xl bg-white/80 text-black">
            </div>

            <!-- Phone -->
            <input type="tel" name="phone_number" placeholder="เบอร์โทร"
                   required
                   class="w-full px-4 py-2 rounded-xl bg-white/80 text-black outline-none">

            <!-- Buttons -->
            <div class="flex gap-3 pt-2">

                <button type="submit"
                        class="flex-1 bg-green-400 hover:bg-green-500 text-black font-bold py-2 rounded-xl">
                    สมัครสมาชิก
                </button>

                <button type="reset"
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-black py-2 rounded-xl">
                    ล้างข้อมูล
                </button>

            </div>

        </form>

        <p class="text-center text-sm mt-5 opacity-80">
            มีบัญชีแล้ว?
            <a href="/login" class="underline">เข้าสู่ระบบ</a>
        </p>

    </div>

</body>
</html>