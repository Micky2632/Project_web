<html>

<head>
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>
    <main>
        <h1>เข้าสู่ระบบ</h1>
        <form action="login" method="post">
            <label for="username">อีเมลผู้ใช้</label><br>
            <input type="text" name="email" id="email" /><br>
            <label for="password">รหัสผ่าน</label><br>
            <input type="password" name="password" id="password" /><br>
            <button type="submit">เข้าสู่ระบบ</button>
        </form>
    </main>
    <p>
        ยังไม่มีบัญชี <a href="/register" >ลงทะเบียน</a>
    </p>

    <?php if (!empty($error)): ?>
        <script>
            alert("<?= $error ?>");
        </script>
    <?php endif; ?>

</body>

</html>