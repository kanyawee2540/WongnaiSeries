<?php

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



?>
<html>

<head>
    <title>Forget Password</title>
    <link rel="stylesheet" href="css/styleForLogin.css">
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
    <div class="center">
        <form name="frmUser" method="post" action="send_link.php">

            <div class="centerpoint">
                <h3>ตั้งค่ารหัสผ่านใหม่</h3>
                <?php if (isset($_SESSION['error'])) : ?>
                    <div class="error">
                        <?php
                        echo $_SESSION['error'];
                        ?>
                    </div>
                <?php endif; ?>
                <div class="form">
                    <div class="title">กรอกอีเมล:</div>
                    <input type="text" class="form-control" value="<?php if (isset($_COOKIE['user_login'])) {
                                                                        echo $_COOKIE['user_login'];
                                                                    } ?>" name="email" >
                </div>
                <input type="submit" name="send" value="ส่งลิงก์ตั้งค่ารหัสผ่านใหม่">
                <div class="link login-link text-center">ยังไม่ได้เป็นสมาชิก? <a href="form.php">ลงทะเบียนที่นี่</a></div>
            </div>
        </form>
    </div>
</body>

</html>
<?php
if (isset($_SESSION["error"])) {
    unset($_SESSION["error"]);
}
?>