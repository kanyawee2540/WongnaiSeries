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
    $userlevel = "คุณคือผู้เข้าชมทั่วไป";
    $cancomment = "no";
    $admin = '';
}
if (isset($_POST['deletemember'])) {

    if (isset($_POST['delete'])) {
        foreach ($_POST['delete'] as $deleteid) {
            $deleteUser = "DELETE from member WHERE id=" . $deleteid;
            mysqli_query($db, $deleteUser);
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Member Info</title>
    <link rel="stylesheet" href="css/styleForhome_Admin.css">
    <!--<link rel="stylesheet" href="css/style.php">-->
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
        <h2>ข้อมูลสมาชิก</h2>
        <div class='container'>
            <!-- Form -->
            <form method='post' action=''>
                <!-- Record list -->
                <table class="container" id="info">
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อจริง</th>
                        <th>นามสกุล</th>
                        <th>สถานะ</th>
                        <th>แก้ไข</th>
                        <th>ลบ</th>
                        <th>ลบ (Checkbox)</th>
                    </tr>
                    <?php
                    $query = "SELECT * FROM member";
                    $result = mysqli_query($db, $query);
                    $order = 1;
                    $count = mysqli_num_rows($result);

                    while ($row = mysqli_fetch_array($result)) {
                        $firstname = $row['firstname'];
                        $lastname = $row['lastname'];
                        $userlevel = $row['userlevel'];
                        if ($userlevel == 'a') {
                            $userlevel = "ผู้ดูแลระบบ";
                        } else {
                            $userlevel = "สมาชิกทั่วไป";
                        }
                    ?>
                        <tr id='tr_<?= $id ?>'>
                            <td><?php echo $order++; ?></td>
                            <td><?= $firstname ?></td>
                            <td><?= $lastname ?></td>
                            <td><?= $userlevel ?></td>
                            <td>
                                <a href="editMember.php?id=<?php echo $row["id"] ?>" class="btn-danger">Edit</a>
                            </td>
                            <td>
                                <a href="delete.php?id=<?php echo $row["id"] ?>" class="btn-danger" onclick="return confirm('ต้องการลบ <?php echo $firstname." ".$lastname; ?> ออกจากการเป็นสมาชิกหรือไม่?')">Delete</a>
                            </td>

                            <!-- Checkbox -->
                            <td><input type='checkbox' name='delete[]' value='<?= $row['id'] ?>'></td>


                        </tr>
                    <?php
                    }
                    ?>
                </table>
                <br>
                <input type=button name="typesubmit" onClick="location.href='home_Admin.php'" value='ย้อนกลับ'>
                <input type='submit' value='ลบสมาชิกที่เลือก' name='deletemember'><br><br>
            </form>
        </div>
        
        <?php } else {    ?>
        <div class="centerpoint">
            <?php echo "สิทธิ์ของคุณไม่สามารถดูหน้านี้ได้"; ?>
        </div>
    <?php } ?>

    </div>
</body>

</html>