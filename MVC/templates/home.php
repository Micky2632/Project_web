<html>

<head></head>

<body>
    <!-- Header และ Footer อาจแยกออกเป็นไฟล์แยกต่างหากได้ -->
    <?php include 'header.php'?>
    <!-- Header และ Footer อาจแยกออกเป็นไฟล์แยกต่างหากได้ -->

    <!-- ส่วนแสดงผลหลักของหน้า -->
    <main>
        <h1>Home</h1>
    </main>
<h2><?= $data['title'] ?></h2>

<?php if($data['result'] && $data['result']->num_rows > 0): ?>

<table border="1" cellpadding="8">
    <tr>
        <th>ชื่อกิจกรรม</th>
        <th>เริ่ม</th>
        <th>สิ้นสุด</th>
        <th>สถานที่</th>
        <th>จำนวนคน</th>
        <th>สถานะ</th>
    </tr>

    <?php while($row = $data['result']->fetch_object()): ?>
    <tr>
        <td><?= $row->description ?></td>
        <td><?= $row->start_date ?></td>
        <td><?= $row->end_date ?></td>
        <td><?= $row->location ?></td>
        <td><?= $row->max_people ?></td>
        <td><?= $row->status ?></td>
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