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
$strSQL = "SELECT * FROM series WHERE id = '" . $_GET["id"] . "' ";
$res = mysqli_query($db, $strSQL);
$objResult = mysqli_fetch_array($res);
if (!$objResult) {
    echo "ไม่พบซีรี่ย์ที่มีเลข ID =" . $_GET["id"];
}
if (isset($_POST['submit'])) {
    //forcolumn
    $id = $_GET["id"];
    $name = $_POST['name'];
    $tmp = $objResult["name"];
    $description = $_POST['description'];
    $isonair = $_POST['isonair'];
    //fortable
    $nameOld = preg_replace("/[^A-Za-z0-9]/", "", $tmp);
    $nameNew = preg_replace("/[^A-Za-z0-9]/", "", $name);
    //,lastname = $lastname, userlevel = $userlevel
    $sql = "UPDATE series SET name = '" . $name . "' , description = '" . $description . "' , isonair = '" . $isonair . "'
    WHERE id = '" . $_GET["id"] . "' ";
    if ($db->query($sql) === TRUE) {
        $_SESSION["success"] = "แก้ไขข้อมูลเรียบร้อย!";
    } else {
        echo $db->error;
        $_SESSION["error"] = "แก้ไขไม่สำเร็จ โปรดลองอีกครั้ง!";
    }
    $sql = "ALTER TABLE $nameOld RENAME TO $nameNew";
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
    <title>Edit Series</title>
    <link rel="stylesheet" href="css/styleForhome_Admin.css">
    <link rel="stylesheet" href="css/styleForhome_Admin.php">
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
            <h2>แก้ไขข้อมูลซีรี่ย์</h2>
        <p class="description">หลังจากทำการแก้ไขแล้ว โปรดทำการกดรีเฟรชเพื่อแสดงผลอีกครั้ง</p>
            <a href="<?php $_SERVER['PHP_SELF']; ?>"><button class="btn"><i class="fa fa-refresh"></i>  รีเฟรช</button></a>
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="error">
                <?php
                echo $_SESSION['error'];
                echo "<br>";
                ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="success">
                <?php
                echo $_SESSION['success'];
                echo "<br>";
                ?>
            </div>
        <?php endif; ?>
        <br>
        <form action="editSeries.php?id=<?php echo $_GET["id"]; ?>" name="frmEdit" method="post">

            <table class="container" id="info">
                <tr>
                    <th>ชื่อเรื่อง</th>
                    <th>คำอธิบาย</th>
                    <th>ออนแอร์?<br> [กรอก 1 หากเป็นซีรี่ย์ที่ยังออนแอร์อยู่ <br>กรอก 0 หากเป็น ซีรี่ย์ที่จบไปแล้ว]</th>
                </tr>
                <tr>
                    <td><input type="text" name="name" value="<?php echo $objResult["name"]; ?>"></td>
                    <td><textarea name="description" class="des" ><?php echo $objResult["description"]; ?></textarea></td>
                    <td><input type="text" name="isonair" value="<?php echo $objResult["isonair"]; ?>"></td>
                </tr>
            </table>
            <br><input type=button onClick="location.href='seriesInfo.php'" value='ย้อนกลับ'><input type="submit" name="submit" value="แก้ไขข้อมูลซีรี่ย์">
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