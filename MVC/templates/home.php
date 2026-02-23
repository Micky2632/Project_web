<html>

<head></head>

<body>
    <!-- Header และ Footer อาจแยกออกเป็นไฟล์แยกต่างหากได้ -->
    <?php include 'header.php' ?>
    <!-- Header และ Footer อาจแยกออกเป็นไฟล์แยกต่างหากได้ -->

    <!-- ส่วนแสดงผลหลักของหน้า -->
    <main>
        <h1>Home</h1>
    </main>
    <h2><?= $data['title'] ?></h2>

    <?php if ($data['result'] && $data['result']->num_rows > 0): ?>


        <table border="1" cellpadding="8">
            <tr>
                <th>ชื่อกิจกรรม</th>
                <th>เริ่ม</th>
                <th>สิ้นสุด</th>
                <th>สถานที่</th>
                <th>จำนวนคน</th>
                <th>สถานะ</th>
                <th>จัดการ</th> <!-- ⭐ เพิ่ม -->
            </tr>

            <?php while ($row = $data['result']->fetch_object()): ?>
                <tr>
                    <td><?= $row->description ?></td>
                    <td><?= $row->start_date ?></td>
                    <td><?= $row->end_date ?></td>
                    <td><?= $row->location ?></td>
                    <td><?= $row->joined ?>/<?= $row->max_people ?></td>
                    <td><?= $row->status ?></td>

                    <!-- ⭐ ปุ่มสมัคร -->
                    <td>
                        <form action="/join_event" method="post">
                            <input type="hidden" name="event_id" value="<?= $row->event_id ?>">
                            <?php if ($row->joined >= $row->max_people): ?>
                                เต็มแล้ว
                            <?php else: ?>
                                <button type="submit">ลงทะเบียน</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

    <?php else: ?>
        <p>ยังไม่มีกิจกรรม</p>
    <?php endif; ?>

    <!-- ส่วนแสดงผลหลักของหน้า -->

    <!-- Header และ Footer อาจแยกออกเป็นไฟล์แยกต่างหากได้ -->
    <!-- Header และ Footer อาจแยกออกเป็นไฟล์แยกต่างหากได้ -->
</body>

</html>