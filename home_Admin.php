<?php require 'dbConfig.php';
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
        $admin = '';
    }
    $cancomment = "yes";
} else {
    $welcome = "ยินดีต้อนรับ";
    $choice = '<a href="login.php">เข้าสู่ระบบ</a>';
    $userlevel = "คุณคือผู้ใช้ทั่วไป";
    $cancomment = "no";
    $admin = '';
}
$query = "SELECT * FROM requesttodeletecomment";
$result = mysqli_query($db, $query);
$order = 1;
$count = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Page</title>
    <link rel="stylesheet" href="css/styleForhome_Admin.css">
    <link rel="stylesheet" href="css/styleForhome_Admin.php">
    <script type="text/javascript" src="script.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
</head>

<body>
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

    <?php if (isset($_SESSION["user"])) { ?>
        <div class='container'>
            <h2>เลือกรายการที่ต้องการทำ</h2>
            <input type=button onClick="location.href='home_User.php'" value='โฮมเพจ'><br><br>
            <input type=button onClick="location.href='memberInfo.php'" value='ข้อมูลสมาชิก'><br><br>
            <input type=button onClick="location.href='seriesInfo.php'" value='ข้อมูลซีรี่ย์'><br><br>
        </div>
        <a href="#" class="notification">
            <span><input type=button onClick="location.href='request.php'" value='คำร้องขอ'></span>
            <span class="badge"><?= $count ?></span>
        </a>
    <?php } else {    ?>
        <div class="centerpoint">
            <?php echo "สิทธิ์ของคุณไม่สามารถดูหน้านี้ได้"; ?>
        </div>
    <?php } ?>
    </div>
</body>

</html>