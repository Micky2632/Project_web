<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main >
    <!-- ===== ข้อมูลผู้ใช้ ===== -->
    <div>

        <h1>
            <?= $data['title'] ?>
        </h1>

        <main>

            <?php
            if ($data['result'] != []) {
                while ($row = $data['result']->fetch_object()) {
            ?>

                <div>
                    <p>ชื่อ: <?= $row->full_name?></p>
                    <p>เพศ: <?= $row->gender?></p>
                    <p>วันเกิด: <?= $row->birth_date?></p>
                    <p>เบอร์โทร: <?= $row->phone_number?></p>
                    <p>อีเมล: <?= $row->email?></p>
                </div>

            <?php
                }
            }
            ?>
        </main>
        </div>
    </div>
</body>
</html>