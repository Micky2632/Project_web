<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>Register</title>
</head>

<body>

<h2>สมัครสมาชิก</h2>

<!-- แสดง error -->
<?php if(isset($error)): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form action="/register" method="post">

    <p>
        Email<br>
        <input type="email" name="email" required>
    </p>

    <p>
        ชื่อ-นามสกุล<br>
        <input type="text" name="full_name" required>
    </p>

    <p>
        รหัสผ่าน<br>
        <input type="password" name="password" required>
    </p>

    <p>
        ยืนยันรหัสผ่าน<br>
        <input type="password" name="confirm_password" required>
    </p>

    <p>
        เพศ<br>
        <select name="gender" required>
            <option value="">-- เลือก --</option>
            <option value="male">ชาย</option>
            <option value="female">หญิง</option>
            <option value="other">อื่นๆ</option>
        </select>
    </p>

    <p>
        วันเกิด<br>
        <input type="date" name="birth_date" required>
    </p>

    <p>
        เบอร์โทร<br>
        <input type="tel" name="phone_number" required>
    </p>

    <button type="submit">สมัครสมาชิก</button>
    <button type="reset">ล้างข้อมูล</button>

</form>

<p>
    มีบัญชีแล้ว? <a href="/login">เข้าสู่ระบบ</a>
</p>

</body>
</html>