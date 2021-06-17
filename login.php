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
    $userlevel = "คุณคือผู้ใช้ทั่วไป";
    $cancomment = "no";
    $admin = '';
}
if (isset($_POST['login'])) {
    include('dbConfig.php');
    $input = $_POST['username'];
    $password = $_POST['password'];
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $name = test_input($input);
    $passwordenc = md5($password);
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        //input is email
        $email = $input;
        $query = "SELECT * FROM member WHERE email = '$email' AND password = '$passwordenc'";
        $result = mysqli_query($db, $query);
    } else {
        //input is username
        $username = $input;
        $query = "SELECT * FROM member WHERE username = '$username' AND password = '$passwordenc'";
        $result = mysqli_query($db, $query);
    }

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_array($result);

        $_SESSION['userid'] = $row['id'];
        $_SESSION['name'] = $row['firstname'];
        $_SESSION['user'] = $row['firstname'] . " " . $row['lastname'];
        $_SESSION['userlevel'] = $row['userlevel'];
        if (!empty($_POST['remember'])) {
            setcookie('user_login', $_POST['username'], time() + 3600);
            setcookie('user_password', $_POST['password'], time() + 3600);
        } else {
            if (isset($_COOKIE['user_login'])) {
                setcookie('user_login', '');

                if (isset($_COOKIE['user_password'])) {
                    setcookie('user_password', '');
                }
            }
        }
        if ($_SESSION['userlevel'] == 'a') {
            header("Location: home_Admin.php");
        }

        if ($_SESSION['userlevel'] == 'm') {
            header("Location: home_User.php");
        }
    } else {
        $_SESSION['error'] = "ชื่อผู้ใช้งาน/อีเมล หรือรหัสผ่านไม่ถูกต้อง.";
    }
}



?>
<html>

<head>
    <title>User Login</title>
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
        <form name="frmUser" method="post" action="">

            <div class="centerpoint">
                <h3>เข้าสู่ระบบ</h3>
                <?php if (isset($_SESSION['error'])) : ?>
                    <div class="error">
                        <?php
                        echo $_SESSION['error'];
                        ?>
                    </div>
                <?php endif; ?>
                <div class="form">
                    <div class="title">ชื่อผู้ใช้งาน/อีเมล:</div>
                    <input type="text" class="form-control" value="<?php if (isset($_COOKIE['user_login'])) {
                                                                        echo $_COOKIE['user_login'];
                                                                    } ?>" name="username" id="username" aria-describedby="username">
                </div>
                <div class="form">
                    <div class="title">รหัสผ่าน:</div>
                    <input type="password" class="form-control" value="<?php if (isset($_COOKIE['user_password'])) {
                                                                            echo $_COOKIE['user_password'];
                                                                        } ?>" name="password" id="password">
                </div>
                <div class="remember">
                    <input type="checkbox" name="remember" <?php if (isset($_COOKIE['user_login'])) { ?> checked <?php } ?> class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                    <div class="forget"><a href="forgetPassword.php">ลืมรหัสผ่าน</a></div>
                </div>
                <input type="submit" name="login" value="เข้าสู่ระบบ">
                <input type="reset" value="ล้างข้อมูล">
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