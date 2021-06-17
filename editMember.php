<?php
require_once 'dbConfig.php';
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
    $userlevel = "คุณคือผู้เข้าชมทั่วไป";
    $cancomment = "no";
    $admin = '';
}
$strSQL = "SELECT * FROM member WHERE id = '" . $_GET["id"] . "' ";
$res = mysqli_query($db, $strSQL);
$objResult = mysqli_fetch_array($res);
if (!$objResult) {
    echo "ไม่พบสมาชิกที่มีเลข ID =" . $_GET["id"];
}
if (isset($_POST['submit'])) {
    $userlevel = $_POST['userlevel'];
    //,lastname = $lastname, userlevel = $userlevel
    $sql = "UPDATE member SET userlevel = '" . $userlevel . "' WHERE id = '" . $_GET["id"] . "' ";
    if ($db->query($sql) === TRUE) {
        $_SESSION["success"] = "แก้ไขข้อมูลเรียบร้อย!";
    } else {
        echo $db->error;
        $_SESSION["error"] = "แก้ไขไม่สำเร็จ โปรดลองอีกครั้ง!";
    }
}

?>
<html>

<head>
    <title>Edit Form</title>
    <link rel="stylesheet" href="css/styleForhome_Admin.css">
    <!--<link rel="stylesheet" href="css/style.php">-->
    <script type="text/javascript" src="script.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <h2>แก้ไขสถานะ</h2>
    <p class="description">หลังจากทำการแก้ไขแล้ว โปรดทำการกดรีเฟรชเพื่อแสดงผลอีกครั้ง</p>
            <a href="<?php $_SERVER['PHP_SELF']; ?>"><button class="btn"><i class="fa fa-refresh"></i>  รีเฟรช</button></a>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="error">
            <?php
            echo $_SESSION['error'];
            ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="success">
            <?php
            echo $_SESSION['success'];
            ?>
        </div>
    <?php endif; ?>
    <br>
    <form action="editMember.php?id=<?php echo $_GET["id"]; ?>" name="frmEdit" method="post">

        <table class="container" id="info">
            <tr>
                <th>ชื่อจริง</th>
                <th>นามสกุล</th>
                <th>แก้ไขสถานะ [กรอก a หากเป็น แอดมิน กรอก m หากเป็น สมาชิกทั่วไป]</th>
            </tr>
            <tr>
                <td><?php echo $objResult["firstname"]; ?></td>
                <td><?php echo $objResult["lastname"]; ?></td>
                <td><input type="text" name="userlevel" value="<?php echo $objResult["userlevel"]; ?>"></td>
            </tr>
        </table>
        <br><input type=button onClick="location.href='memberInfo.php'" value='ย้อนกลับ'><input type="submit" name="submit" value="แก้ไขข้อมูลสมาชิก">
    </form>
    <?php } else {
        echo "สิทธิ์ของคุณไม่สามารถดูหน้านี้ได้";
        echo '<br>';
    ?>
    <?php } ?>
</body>

</html>
<?php
if (isset($_SESSION["error"]) || (isset($_SESSION["success"]))) {
    unset($_SESSION["error"]);
    unset($_SESSION["success"]);
}
?>