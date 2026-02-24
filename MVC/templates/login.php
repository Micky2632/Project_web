<!doctype html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center
             bg-gradient-to-br from-[#3b2c44] via-[#7b5b7f] to-black">

    <!-- Card -->
    <div class="w-[360px] bg-white/20 backdrop-blur-xl
                rounded-3xl shadow-2xl p-8 text-white border border-white/30">

        <!-- Avatar -->
        <div class="w-20 h-10 bg-gray-300/80 rounded-full mx-auto mb-4"></div>

        <h2 class="text-center text-2xl font-bold mb-6">
            LOGIN
        </h2>

        <!-- Form -->
        <form action="login" method="post" class="space-y-4">

            <!-- Email -->
            <div>
                <label class="text-xs opacity-80">EMAIL ADDRESS</label>
                <input type="text"
                       name="email"
                       placeholder="user@example.com"
                       class="w-full mt-1 px-4 py-2 rounded-lg
                              bg-white/70 text-black outline-none">
            </div>

            <!-- Password -->
            <div>
                <label class="text-xs opacity-80">PASSWORD</label>
                <input type="password"
                       name="password"
                       placeholder="••••••"
                       class="w-full mt-1 px-4 py-2 rounded-lg
                              bg-white/70 text-black outline-none">
            </div>

            <!-- Button -->
            <button
                class="w-full py-2 rounded-xl
                       bg-green-400 hover:bg-green-500
                       text-black font-semibold">
                LOGIN
            </button>

        </form>

        <!-- Register -->
        <p class="text-center text-xs mt-4 opacity-80">
            ยังไม่มีบัญชี?
            <a href="/register" class="underline">สมัครสมาชิก</a>
        </p>

    </div>


    <!-- Error -->
    <?php if (!empty($error)): ?>
        <script>
            alert("<?= $error ?>");
        </script>
    <?php endif; ?>

</body>
</html>