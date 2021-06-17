<?php
require_once 'dbConfig.php';
$link_address = 'login.php';
session_start();
if (isset($_SESSION["user"])) {
    $userid = $_SESSION["userid"];
    $user = $_SESSION["name"];
    $welcome = "ยินดีต้อนรับ " . $_SESSION["user"];
    $choice = '<a href="logout.php">ออกจากระบบ</a>';
    if ($_SESSION['userlevel'] == 'a') {
        $userlevel = "คุณคือแอดมิน";
        $admin = '<a href="home_Admin.php">จัดการข้อมูล</a>';
    } else if ($_SESSION['userlevel'] == 'm') {
        $userlevel = "คุณคือสมาชิก";
        $admin ='';
    }
    $cancomment = "yes";
} else {
    $welcome = "ยินดีต้อนรับ";
    $choice = '<a href="login.php">เข้าสู่ระบบ</a>';
    $userlevel = "คุณคือผู้ใช้ทั่วไป";
    $cancomment = "no";
    $admin ='';
}
if (isset($_POST['submit'])) {
    $search = $_POST['search'];
    $sql = "select * from series where name like '%$search%'";
    $result = mysqli_query($db, $sql);
    $count = mysqli_num_rows($result);
    if ($count == 0) {
        $_SESSION['error'] = "ไม่มีรายการที่คุณต้องการ";
    }
} else {
    $count = "ยังไม่ได้ทำการค้นหา";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['end'])) {
        $sqlsort = "SELECT * FROM series where isonair =0";
        $result = mysqli_query($db, $sqlsort);
        $count = mysqli_num_rows($result);
        if ($count == 0) {
            $_SESSION['error'] = "ไม่มีรายการที่คุณต้องการ";
        }
    }
    if (isset($_POST['onair'])) {
        $sqlsort = "SELECT * FROM series where isonair =1";
        $result = mysqli_query($db, $sqlsort);
        $count = mysqli_num_rows($result);
        if ($count == 0) {
            $_SESSION['error'] = "ไม่มีรายการที่คุณต้องการ";
        }
    }
    if (isset($_POST['cat'])) {
        $cat = $_POST['cat'];
        $sqlsort = "select * from series where category like '%$cat%'";
        $result = mysqli_query($db, $sqlsort);
    $count = mysqli_num_rows($result);
    if ($count == 0) {
        $_SESSION['error'] = "ไม่มีรายการที่คุณต้องการ";
    }
    }
} else {
    $count = "ยังไม่ได้ทำการค้นหา";
}
?>

<html>

<head>
    <title>Home User</title>
    <link rel="stylesheet" href="css/home_User.css">
    <link rel="stylesheet" href="css/styleForHome_User.php">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
</head>

<body></body>
<div class="header">
    <a href="home_User.php">
        <img class="logo" alt="logo" src="css/logo.png">
    </a>
    <div class="user">
        <?= $welcome ?><br>
        <?= $userlevel ?><br>
        <?= $choice ?>
        <?= $admin ?>
    </div>
</div>        
<div class="content">
<h2>ค้นหาซีรี่ย์เกาหลีที่คุณต้องการดูรีวิว</h2>

<form action="" method="post">
    <input type="text" name="search" placeholder="ค้นหาซีรี่ย์จากชื่อเรื่อง">      
    <input type="submit" name="submit" value="🔍"><br><br>
    <input type="submit" name="end" value="ซีรี่ย์จบแล้ว" /> <input type="submit" name="onair" value="ซีรี่ย์ที่ยังออนแอร์" /><br><br>
    ค้นหาตามประเภทของซีรี่ย์<br> 
    <input class="btn" type="submit" name="cat" value="แอคชั่น"/>
    <input class="btn" type="submit" name="cat" value="ตลก" />
    <input class="btn" type="submit" name="cat" value="โรแมนติก" />
    <input class="btn" type="submit" name="cat" value="ดราม่า" />
    <input class="btn" type="submit" name="cat" value="แฟนตาซี" />
    <input class="btn" type="submit" name="cat" value="สืบสวนสอบสวน" />
    <input class="btn" type="submit" name="cat" value="อิงประวัติศาสตร์" />
    <input class="btn" type="submit" name="cat" value="ครอบครัว" />
    <input class="btn" type="submit" name="cat" value="การแพทย์" />
    <input class="btn" type="submit" name="cat" value="โรแมนติก คอมมิดี้" />
    <input class="btn" type="submit" name="cat" value="วิทยาศาสตร์" />
    <input class="btn" type="submit" name="cat" value="ระทึกขวัญ" />
    <input class="btn" type="submit" name="cat" value="กฏหมาย" /><br><br>
</form>
<?php if (isset($_SESSION['error'])) : ?>
    <div class="error">
        <?php
        echo $_SESSION['error'];
        ?>
    </div>
<?php endif; ?>
<?php if ($count > 0) { ?>

    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="container">
            <a href="index.php?id=<?php echo $row["id"] ?>"><?php echo '<img class="image" src="data:image/jpeg;base64,' . base64_encode($row['image']) . '"/width="200" height="297">'; ?></a>
            <div class="overlay"><?= $row['name'] ?></div>
        </div>
    <?php } ?>
<?php } else { ?>
<?php } ?>
</div>

</body>

</html>
<?php
if (isset($_SESSION["error"])) {
    unset($_SESSION["error"]);
}
?>