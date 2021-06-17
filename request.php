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

if (isset($_POST['deletecomment'])) {
    if (isset($_POST['delete'])) {
        foreach ($_POST['delete'] as $deleteid) {
            if (isset($_POST['nameseries'])) {
                $name = $_POST['nameseries'];
                $namefortable = preg_replace("/[^A-Za-z0-9]/", "", $name);
                $namefortable = strtolower($namefortable);
                //echo $namefortable;
                $deleterequest = "DELETE from requestToDeleteComment WHERE idToDelete=" . $deleteid;
                //echo "deleteid " . $deleteid;
                mysqli_query($db, $deleterequest);
                $deletinseries = "UPDATE $namefortable SET comment = NULL WHERE id = '" . $deleteid . "' ";
                mysqli_query($db, $deletinseries);
                if ($db->query($deleterequest) === TRUE && $db->query($deletinseries) === TRUE) {
                    $_SESSION["success"] = "ลบความคิดเห็นเรียบร้อย!";
                } else {
                    $_SESSION["error"] = "ไม่สามารถลบได้ เนื่องจาก ". $db->error;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Request</title>
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
        <h2>คำร้องขอเพื่อให้ลบความคิดเห็น</h2>
        <p class="description">หลังจากทำการลบแล้ว โปรดทำการกดรีเฟรชเพื่อแสดงผลอีกครั้ง</p>
        <a href="<?php $_SERVER['PHP_SELF']; ?>"><button class="btn"><i class="fa fa-refresh"></i> รีเฟรช</button></a><br>
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
        <?php
        $query = "SELECT * FROM requesttodeletecomment";
        $result = mysqli_query($db, $query);
        $order = 1;
        $count = mysqli_num_rows($result);
        ?>
        <?php if ($count > 0) { ?>                
            <div class='container'>
                    <!-- Form -->
                    <form method='post' action=''>                        
                        <table class="container" id="info">
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อซีรี่ย์</th>
                                <th>ความเห็นที่ต้องการให้ลบ</th>
                                <th>เหตุผลที่ต้องการลบ</th>
                                <th>วันที่แจ้ง</th>
                                <th>ลบความเห็น</th>
                                <th>ลบความเห็น (Checkbox)</th>
                            </tr>
            <?php while ($row = mysqli_fetch_array($result)) {
                $series = $row['seriesName'];
                $comment = $row['comment'];
                $reson = $row['reson'];
                $requestDate = $row['requestDate'];
            ?>


                            <tr id='tr_<?= $id ?>'>
                                <td><?php echo $order++; ?></td>
                                <td><?= $series ?></td>
                                <td><?= $comment ?></td>
                                <td><?= $reson ?></td>
                                <td><?= $requestDate ?></td>
                                <td>
                                    <a href="deleteComment.php?id=<?php echo $row["idToDelete"] ?>" class="btn-danger" onclick="return confirm('ต้องการลบความคิดเห็นดังกล่าวหรือไม่?')">Delete</a>
                                </td>

                                <!-- Checkbox -->
                                <td><input type='checkbox' name='delete[]' value='<?= $row['idToDelete'] ?>'></td>


                            </tr>
                        <?php
                    }
                        ?>
                        </table>
                        <br>
                        <input type=button name="typesubmit" onClick="location.href='home_Admin.php'" value='ย้อนกลับ'>
                        <input type="hidden" name="nameseries" value="<?php echo $series; ?>" />
                        <input type='submit' value='ลบความคิดเห็นที่เลือก' name='deletecomment'><br><br>
                    </form>
                </div>
            <?php } else { ?>
                <br>ยังไม่มีคำร้องให้ลบความคิดเห็น
            <?php } ?>

            <?php } else {    ?>
        <div class="centerpoint">
            <?php echo "สิทธิ์ของคุณไม่สามารถดูหน้านี้ได้"; ?>
        </div>
    <?php } ?>

        </div>
</body>

</html>
<?php
if (isset($_SESSION["error"]) || (isset($_SESSION["success"]))) {
    unset($_SESSION["error"]);
    unset($_SESSION["success"]);
}
?>