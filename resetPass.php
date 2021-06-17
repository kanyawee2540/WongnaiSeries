<?php
require 'dbConfig.php';
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
if ($_GET['key'] && $_GET['reset']) {
    $email = $_GET['key'];
    //echo $email;
    $pass = $_GET['reset'];
    //echo $pass;
    $query = "SELECT email,password FROM member WHERE email='$email' and md5(password)='$pass'";
    $result = mysqli_query($db, $query);
}
if (isset($_POST['submit_password'])) {
    if (isset($_POST['password'])) {
        $newpassword =  $_POST['password'];
        $passwordenc = md5($newpassword);
        $reset = "UPDATE member set password='$passwordenc' where email='$email'";
        if ($db->query($reset) === TRUE) {
            $_SESSION["success"] = "ตั้งค่ารหัสผ่านใหม่เรียบร้อย คุณสามารถเข้าสู่ระบบได้ด้วยรหัสผ่านใหม่";
        } else {
            echo $db->error;
            $_SESSION["error"] = "แก้ไขไม่สำเร็จ โปรดลองอีกครั้ง!";
        }
    } else {
        $_SESSION['error'] = "โปรดกรอกรหัสผ่านใหม่ที่ต้องการ";
    }
}
?>
<html>

<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/styleForLogin.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
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
    <div class="center">
        <h3>ตั้งค่ารหัสผ่านใหม่</h3>
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

        <?php if (mysqli_num_rows($result) == 1) { ?>
            <form method="post" action="">

                <input type="hidden" name="email" value="<?php echo $email; ?>">
                <p>กรอกรหัสผ่านใหม่</p>
                <input type="password" name="password" id="myInput">

                <!-- An element to toggle between password visibility -->
                <div class="show"><input type="checkbox" onclick="myFunction()">แสดงรหัสผ่าน</div>

                <input type="submit" name="submit_password" value="เปลี่ยนรหัสผ่าน">

            </form>
    </div>
<?php } ?>
</body>

</html>
<script>
    function myFunction() {
        var x = document.getElementById("myInput");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
<?php
if (isset($_SESSION["error"]) || (isset($_SESSION["success"]))) {
    unset($_SESSION["error"]);
    unset($_SESSION["success"]);
}
?>