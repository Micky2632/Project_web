<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
</head>
<body>
    
<main>

    <h1><?= $data['title'] ?></h1>

    <?php
    if ($data['result'] && $data['result']->num_rows > 0) {
        while ($row = $data['result']->fetch_object()) {
    ?>

        <div>
            <p>ชื่อ: <?= $row->full_name ?></p>
            <p>เพศ: <?= $row->gender ?></p>
            <p>วันเกิด: <?= $row->birth_date ?></p>
            <p>เบอร์โทร: <?= $row->phone_number ?></p>
            <p>อีเมล: <?= $row->email ?></p>
        </div>

    <?php
        }
    } else {
        echo "<p>ยังไม่ได้เข้าสู่ระบบ หรือไม่พบข้อมูล</p>";
    }
    ?>

</main>

</body>
</html>