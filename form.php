<?php
// Include the database configuration file  
require_once 'dbConfig.php';
session_start();
// If file upload form is submitted 
$status = $statusMsg = '';
$message = "";
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
if (isset($_POST["submit"])) {
        // Get file info 
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPass = $_POST['cpassword'];
        $sql = "select * from member where (username='$username' or email='$email');";

        $res = mysqli_query($db, $sql);

        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            if ($username == $row['username']) {
                $_SESSION['error'] = "Username นี้มีในระบบแล้ว โปรดกรอกใหม่อีกครั้ง";
            } else if ($email == $row['email']) {
                $_SESSION['error'] = "Email นี้มีในระบบแล้ว โปรดกรอกใหม่อีกครั้ง";
            }
        } else { // if condition ends here if it is new entry, echo will work
            $passwordenc = md5($password);
                // Insert image content into database 
                $insert = $db->query("INSERT into member (firstname,lastname,username,email,password, uploaded,userlevel) VALUES ('$firstname','$lastname','$username','$email','$passwordenc', NOW(),'m')");
                if ($insert) {
                    $_SESSION["success"] = "ลงทะเบียนเรียบร้อย! คุณสามารถเข้าสู่ระบบได้จากปุ่มด้านล่างฟอร์ม";
                } else {
                    $_SESSION['error'] = "ลงทะเบียนไม่สำเร็จ! โปรดลองใหม่อีกครั้ง";
                }
        }
}
$link = '<a href="home_Admin.php">[ADMIN ONLY]</a>';
// Display status message 
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register Form</title>
    <link rel="stylesheet" href="css/styleForRegister.css">
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
    <div class="center">
        <h2>ลงทะเบียน</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="error">
                    <?php
                    echo $_SESSION['error'];
                    echo "<br>";
                    ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['status'])) : ?>
                <div class="error">
                    <?php
                    echo $_SESSION['status'];
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
            <div class="form-group">
                <div class="textform"> ชื่อจริง : </div><input class="form-control" type="text" name="firstname" placeholder="ชื่อจริง" required>
            </div>
            <div class="form-group">
                <div class="textform"> นามสกุล : </div><input class="form-control" type="text" name="lastname" placeholder="นามสกุล" required>
            </div>
            <div class="form-group">
                <div class="textform"> ชื่อผู้ใช้งาน : </div><input class="form-control" type="text" name="username" placeholder="ชื่อผู้ใช้งาน" required>
            </div>
            <div class="form-group">
                <div class="textform"> อีเมล :</div><input class="form-control" type="text" name="email" placeholder="อีเมล" required>
            </div>
            <div class="form-group">
                <div class="textform"> รหัสผ่าน : </div><input class="form-control" type="password" name="password" placeholder="รหัสผ่าน" required>
            </div>
            <div class="form-group">
                <div class="textform">ยืนยันรหัสผ่าน : </div><input class="form-control" type="password" name="cpassword" placeholder="ยืนยันรหัสผ่าน" required>
            </div>
            <input type="submit" name="submit" value="ลงทะเบียน">
            <input type="reset" value="ล้างข้อมูล">
            <div class="link login-link text-center">ลงทะเบียนแล้ว? <a href="login.php">เข้าสู่ระบบที่นี่</a></div>
        </form>
    </div>
</body>

</html>
<?php
if (isset($_SESSION["error"]) || (isset($_SESSION["success"]) || (isset($_SESSION["status"])))) {
    unset($_SESSION["error"]);
    unset($_SESSION["success"]);
    unset($_SESSION["status"]);
}
?>