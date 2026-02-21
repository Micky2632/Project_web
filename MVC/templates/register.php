<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>Register</title>
</head>

<body>

<h2>สมัครสมาชิก</h2>

<form action="register" method="post">

    <p>
        <label>Email :</label><br>
        <input type="email" name="email" required>
    </p>

    <p>
        <label>ชื่อ-นามสกุล :</label><br>
        <input type="text" name="full_name" required>
    </p>

    <p>
        <label>รหัสผ่าน :</label><br>
        <input type="password" name="password" required>
    </p>

    <p>
        <label>ยืนยันรหัสผ่าน :</label><br>
        <input type="password" name="confirm_password" required>
    </p>

    <p>
        <label>เพศ :</label><br>
        <select name="gender" required>
            <option value="">-- เลือก --</option>
            <option value="male">ชาย</option>
            <option value="female">หญิง</option>
            <option value="other">อื่นๆ</option>
        </select>
    </p>

    <p>
        <label>วันเกิด :</label><br>
        <input type="date" name="birth_date" required>
    </p>

    <p>
        <label>เบอร์โทร :</label><br>
        <input type="tel" name="phone_number" required>
    </p>

    <!-- ซ่อน role ไว้ (ให้เป็น student อัตโนมัติ) -->
    <input type="hidden" name="role" value="student">

    <p>
        <button type="submit">สมัครสมาชิก</button>
        <button type="reset">ล้างข้อมูล</button>
    </p>

</form>

<p>
    มีบัญชีแล้ว? <a href="/login">เข้าสู่ระบบ</a>
</p>

</body>
</html>