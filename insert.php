<?php
// Include the database configuration file  
require 'dbConfig.php';
session_start();
// If file upload form is submitted 
$status = $statusMsg = '';
$message = "";
$select = "";
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
    $userlevel = "คุณคือผู้ใช้ทั่วไป";
    $cancomment = "no";
    $admin ='';
}
if (isset($_POST["submit"])) {
    if (!empty($_FILES["image"]["name"])) {
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $name = $_POST['name'];
        if (!empty($_POST['category'])) {
            $i = 0;
            $len = count($_POST['category']);
            foreach ($_POST['category'] as $item) {
                if ($i == $len - 1) {
                    $select .= $item;
                } else {
                    $select .= $item . " , ";
                }
                // …
                $i++;
            }
        }
        //echo $select;
        $namefortable = preg_replace("/[^A-Za-z0-9]/", "", $name);
        //echo $namefortable;
        $description = $_POST['description'];
        $year = $_POST['year'];
        $isonair = $_POST['isonair'];
        if ($isonair == "no") {
            $isonair = FALSE;
        } else {
            $isonair = TRUE;
        }
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            $image = $_FILES['image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));
            // Insert image content into database 
            $sql = "select * from series where name like '%$name%'";

            $res = mysqli_query($db, $sql);

            if (mysqli_num_rows($res) > 0) {

                $_SESSION['error'] = "โปรดทำการตรวจสอบอีกครั้งว่าได้เพิ่มซีรี่ย์เรื่องนี้ไปแล้วหรือยัง";
            } else {
                $insert = $db->query("INSERT into series (name,description,image, uploaded,category,year,isonair) VALUES ('$name','$description','$imgContent', NOW(),'$select','$year','$isonair')");
                $sql = "CREATE TABLE $namefortable (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                userid INT(11) NOT NULL,
                commentusername VARCHAR(255) NOT NULL,
                comment VARCHAR(21844),
                rating DECIMAL(13, 2),
                likecomment INT(11),
                feelingcomment VARCHAR(255),
                commentDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";
                if ($db->ping()) {
                    //printf("Our connection is ok!\n");
                } else {
                    //printf("Error: %s\n", $db->error);
                }
                if ($db->query($sql) === TRUE) {
                    //echo "Table MyGuests created successfully";
                } else {
                    //echo "Error creating table: " . $db->error;
                }
                if ($insert) {
                    //echo "success for upload ";
                    $status = 'success';
                    $statusMsg = "File uploaded successfully.";
                    $_SESSION["success"] = "เพิ่มซีรี่ย์เรียบร้อยแล้ว";
                } else {
                    //echo "error is1 " . $db->error;
                    $_SESSION['error'] = "File upload failed, please try again.";
                }
            }
        } else {
            //echo "error is2 " . $db->error;
            $_SESSION['error'] = 'ขออภัย รองรับเฉพาะไฟล์ JPG, JPEG, PNG, & GIF เท่านั้น';
        }
    } else {
        //echo "error is3 " . $db->error;
        $_SESSION['error'] = 'โปรดเลือกรูปปกซีรี่ย์ก่อนบันทึก';
    }
}
// Display status message 
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add new Series</title>
    <link rel="stylesheet" href="css/styleForInsert.css">
    <link rel="stylesheet" href="css/styleForhome_Admin.css">
    <link rel="stylesheet" href="css/styleForInsert.php">
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
    <h2>เพิ่มซีรี่ย์</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <?php if (isset($_SESSION['error'])) : ?>
            <div class="error">
                <?php
                echo $_SESSION['error'];
                ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['status'])) : ?>
            <div class="error">
                <?php
                echo $_SESSION['status'];
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
        <div class="form-group">
            <input class="form-control" type="text" name="name" style="width: 20%;padding: 12px 20px;margin: 8px 0;box-sizing: border-box; border-radius: 4px;" placeholder="ชื่อเรื่อง" required>
        </div>
        <div class="form-group">
            <input class="form-control" type="text" name="description" style="width: 20%;padding: 12px 20px;margin: 8px 0;box-sizing: border-box; border-radius: 4px;" placeholder="คำอธิบาย" required>
        </div>
        <div class="form-group">
            <input class="form-control" type="text" name="year" style="width: 20%;padding: 12px 20px;margin: 8px 0;box-sizing: border-box; border-radius: 4px;" placeholder="ปีที่ออนแอร์ (คศ.)" required>
        </div>
        <div class="form-group">
            <br>เลือกประเภทของซีรี่ย์ (สามารถเลือกได้หลายประเภท)<p style="font-size: 12px; color:crimson">*โปรดมั่นใจว่าประเภทที่เลือกถูกต้อง เพราะไม่สามารถแก้ไขได้ภายหลัง</p>
            <div class="category">
                <div class="rowcat">
                    <input type="checkbox" name="category[]" value="แอคชั่น" />
                    <label>แอคชั่น</label>
                    <input type="checkbox" name="category[]" value="ตลก" />
                    <label>ตลก</label>
                    <input type="checkbox" name="category[]" value="โรแมนติก" />
                    <label>โรแมนติก</label>
                    <input type="checkbox" name="category[]" value="ดราม่า" />
                    <label>ดราม่า</label>
                    <input type="checkbox" name="category[]" value="แฟนตาซี" />
                    <label>แฟนตาซี</label>
                    <input type="checkbox" name="category[]" value="สืบสวนสอบสวน" />
                    <label>สืบสวนสอบสวน</label>
                    <input type="checkbox" name="category[]" value="อิงประวัติศาสตร์" />
                    <label>อิงประวัติศาสตร์</label><br>
                    <input type="checkbox" name="category[]" value="ครอบครัว" />
                    <label>ครอบครัว</label>
                    <input type="checkbox" name="category[]" value="การแพทย์" />
                    <label>การแพทย์</label>
                    <input type="checkbox" name="category[]" value="โรแมนติก คอมมิดี้" />
                    <label>โรแมนติก คอมมิดี้</label>
                    <input type="checkbox" name="category[]" value="วิทยาศาสตร์" />
                    <label>วิทยาศาสตร์</label>
                    <input type="checkbox" name="category[]" value="ระทึกขวัญ" />
                    <label>ระทึกขวัญ</label>
                    <input type="checkbox" name="category[]" value="กฏหมาย" />
                    <label>กฏหมาย</label>
                </div><br>

            </div>เป็นซีรี่ย์ที่กำลังออนแอร์อยู่หรือไม่<br>
            <input type="radio" name="isonair" value="yes">
            <label>กำลังออนแอร์</label>
            <input type="radio" name="isonair" value="no">
            <label>จบไปแล้ว</label>
        </div>
        <div class="form-group">
            <p>เลือกรูปปกซีรี่ย์
            <p style="font-size: 12px; color:crimson">*โปรดมั่นใจว่ารูปที่เลือกถูกต้อง เพราะไม่สามารถแก้ไขได้ภายหลัง</p>
            <img id="thumb" src="css/seriescover.jpg" /><br>
            <input type="file" name="image" onchange="preview()">
        </div>
        <br>
        <input type=button name="typesubmit" onClick="location.href='seriesInfo.php'" value='ย้อนกลับ'>
        <input type="submit" name="submit" value="บันทึก">
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