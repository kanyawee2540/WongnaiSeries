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
        $admin ='';
    }
    $cancomment = "yes";
} else {
    $welcome = "ยินดีต้อนรับ";
    $choice = '<a href="login.php">เข้าสู่ระบบ</a>';
    $userlevel = "คุณคือผู้เข้าชมทั่วไป";
    $cancomment = "no";
    $admin ='';
}
if (isset($_POST['deleteseries'])) {
    if (isset($_POST['delete'])) {
        foreach ($_POST['delete'] as $deleteid) {
            $results = mysqli_query($db, "SELECT * FROM series WHERE id =$deleteid");
            $sql = "SELECT * FROM series WHERE id =$deleteid";
            $result = $db->query($sql);
            if (!$results) {
                printf("Error: %s\n", mysqli_error($db));
                exit();
            } else {
                $row = $result->fetch_assoc();
                $namefortable = preg_replace("/[^A-Za-z0-9]/", "", $row['name']);
            }
            $deleteInSeries = "DELETE FROM series WHERE id =$deleteid";

            /*if ($db->query($deleteInSeries) === TRUE) {

                echo "in series deleted successfully\n";
            } else {
                echo "Error deleting record: " . $db->error;
            }
            $deleteTable = "DROP TABLE $namefortable";

            if ($db->query($deleteTable) === TRUE) {

                echo "Table deleted successfully\n";
                header("location:home_Admin.php");
            } else {
                echo "Error deleting record: " . $db->error;
            }*/
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Series Info</title>
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
        <h2>ข้อมูลซีรี่ย์</h2>
        <?php
                    $query = "SELECT * FROM series";
                    $result = mysqli_query($db, $query);
                    $order = 1;
                    $count = mysqli_num_rows($result);
                    ?>
        <?php if ($count > 0) { ?>    
        <div class='container'>
            <!-- Form -->
            <form method='post' action=''>
                <!-- Record list -->
                <table class="container" id="info">
                <tr style='background: whitesmoke;'>
                        <th>ลำดับ</th>
                        <th>ชื่อเรื่อง</th>
                        <th>คำอธิบาย</th>
                        <th>ออนแอร์?</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Delete (Checkbox)</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        $name = $row['name'];
                        $description = $row['description'];
                        if($row['isonair']==1){
                            $onair = "กำลังออนแอร์";
                        }else{
                            $onair = "จบไปแล้ว";
                        }
                    ?>
                        <tr id='tr_<?= $id ?>'>
                            <td><?php echo $order++; ?></td>
                            <td><?= $name ?></td>
                            <td><?= $description ?></td>
                            <td><?= $onair ?></td>
                            <td>
                                <a href="editSeries.php?id=<?php echo $row["id"] ?>" >Edit</a>
                            </td>
                            <td>
                                <a href="deleteSeries.php?id=<?php echo $row["id"] ?>" class="btn-danger" onclick="return confirm('ต้องการลบข้อมูลซีรี่ย์เรื่อง <?php echo $name; ?> หรือไม่?')">Delete</a>
                            </td>
                            <!-- Checkbox -->
                            <td><input type='checkbox' name='delete[]' value='<?= $row['id'] ?>'></td>

                        </tr>
                    <?php

                    }
                    ?>
                </table>
                <br>
                <?php } else { ?>
                <br>ยังไม่มีการเพิ่มซีรี่ย์<br><br>
            <?php } ?>
                <input type=button name="typesubmit" onClick="location.href='home_Admin.php'" value='ย้อนกลับ'>
                <input type='submit' value='ลบซีรี่ย์ที่เลือก' name='deleteseries'>
                <input type=button name="insertnew" onClick="location.href='insert.php'" value='เพิ่มซีรี่ย์ใหม่'>
            </form>
        </div>
    <?php } else {
        echo "สิทธิ์ของคุณไม่สามารถดูหน้านี้ได้";
        echo '<br>';
    ?>
    <?php } ?>

    </div>
</body>

</html>