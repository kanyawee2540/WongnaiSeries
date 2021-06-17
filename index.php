<?php
require('dbConfig.php');
session_start();
// sql to delete a record
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

$id = $_GET["id"];
$sql = "select * from series WHERE id =$id";

$res = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($res);
$name = $row['name'];
$description = $row['description'];
$namefortable = preg_replace("/[^A-Za-z0-9]/", "", $name);
$namefortable = strtolower($namefortable);
//echo "name for table = " . $namefortable;

$query = "SELECT * FROM $namefortable";
$result = mysqli_query($db, $query);
$order = 1;
$count = mysqli_num_rows($result);

$checkrating = "SELECT * FROM $namefortable WHERE rating IS NOT NULL";
$resultrating = mysqli_query($db, $checkrating);
$order = 1;
$showcount = mysqli_num_rows($resultrating);

/*$checkcomment = "SELECT * FROM $namefortable WHERE comment IS NOT NULL";
$resultcomment = mysqli_query($db, $checkcomment);
$order = 1;
$showcount = mysqli_num_rows($resultcomment);
echo "count comment is " . $showcount;*/


if (isset($_POST['submit'])) {
    if (isset($_POST['rating'])) {
        if (isset($_POST['comment'])) {
            //echo "active comment and rating";
            $comment = $_POST['comment'];
            $rating = $_POST['rating'];
            $insert = $db->query("INSERT into $namefortable (userid,commentusername,comment,rating, commentDate) VALUES ('$userid','$user','$comment','$rating', NOW())");
            if ($insert) {
                echo "<script>
                alert('ขอบคุณสำหรับการแสดงความคิดเห็นและให้เรตติ้งค่ะ');
                </script>";
            } else {
                //echo "Error " . $db->error;
            }
        } else {
            //echo "active only rating";
            $rating = $_POST['rating'];
            $insert = $db->query("INSERT into $namefortable (userid,commentusername,rating, commentDate,comment) VALUES ('$userid','$user','$rating', NOW(),NULL)");
            if ($insert) {
                echo "<script>
                alert('ขอบคุณสำหรับการให้เรตติ้งค่ะ');
                </script>";
            } else {
                //echo "Error " . $db->error;
            }
        }
    } else {
        //echo "active only comment";
        $comment = $_POST['comment'];
        $insert = $db->query("INSERT into $namefortable (userid,commentusername,comment, commentDate) VALUES ('$userid','$user','$comment', NOW())");
        if ($insert) {
            echo "<script>
            alert('ขอบคุณสำหรับการแสดงความคิดเห็นค่ะ');
            </script>";
        } else {
            echo "Error " . $db->error;
        }
    }
}
if (isset($_POST['likethis'])) {
    $like = $_POST['likethis'];
    $checklike = "SELECT * FROM $namefortable WHERE id=$like";
    $rescheck = mysqli_query($db, $checklike);
    $rowcheck = mysqli_fetch_assoc($rescheck);
    if ($rowcheck['likecomment'] != NULL) {
        $sql = "UPDATE $namefortable SET likecomment=likecomment+1 WHERE id=$like";
    } else {
        $sql = "UPDATE $namefortable SET likecomment=1 WHERE id=$like";
    }

    if ($db->query($sql) === TRUE) {
        echo "<script>
        alert('คุณได้กดถูกใจเนื้อหานี้เรียบร้อยค่ะ');
        </script>";
    } else {
        //echo "Error updating record: " . $db->error;
    }
}

if (isset($_POST['request'])) {
    $comment = $_POST['comment'];
    if (isset($_POST['idUS'])) {
        $id = $_POST['idUS'];
        $topic = "SELECT comment FROM $namefortable WHERE id = $id";
        $restopic = mysqli_query($db, $topic);
        $rowtopic = mysqli_fetch_assoc($restopic);
        $commentwanttodelete = $rowtopic['comment'];
        $insert = $db->query("INSERT into requestToDeleteComment (idToDelete,comment,reson, requestDate,seriesName) VALUES ('$id','$commentwanttodelete','$comment', NOW(),'$name')");
        if ($insert) {
            echo "<script>
            alert('ขอบคุณที่ร้องเรียนเข้ามานะคะ ทางแอดมินจะดำเนินการตรวจสอบอย่างเร็วที่สุด');
            </script>";
        } else {
            echo "Error " . $db->error;
        }
    }
}
$countfive = 0;
$countfourdotfive = 0;
$countfour = 0;
$countthreedotfive = 0;
$countthree = 0;
$counttwodotfive = 0;
$counttwo = 0;
$countonedotfive = 0;
$countone = 0;
$countzerodotfive = 0;
$perfive = 0;
$perfourdotfive = 0;
$perfour = 0;
$perthreedotfive = 0;
$perthree = 0;
$pertwodotfive = 0;
$pertwo = 0;
$peronedotfive = 0;
$perone = 0;
$perzerodotfive = 0;
$sum = 0;

?>

<html>

<head>
    <title><?= $name ?></title>

    <link rel="stylesheet" href="css/styleForIndex.css">
    <link rel="stylesheet" href="css/styleForIndex.php">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
    <div class="main">
        <div class="container">
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" width="300" height="448" />
            <div class="container_text">
                <div class="title"><?= $name ?></div><br>
                คำอธิบาย : <?= $row['description'] ?><br><br>
                ประเภท: <?= $row['category'] ?><br><br>
                ปีที่ออนแอร์: <?= $row['year'] ?><br><br>
                เรตติ้งจากเว็บไซต์ wongseries :
                <?php if ($row['rating'] == 0) { ?>
                    ยังไม่มีการให้เรตติ้ง
                <?php } else { ?>
                    <?= $row['rating'] ?>
                <?php } ?>
                <br><br>
            </div>
        </div>

        <br>
        <p class="description">หลังจากทำการรีวิวถูกใจหรือแสดงความรู้สึกบันทึกแสดงความคิดเห็นแล้ว โปรดทำการกดปุ่มรีเฟรชเพื่อแสดงผลอีกครั้ง</p>
        <?php if ($result->num_rows > 0) { ?>
            <div class="comment">
                <div class="head"><?= $showcount ?> เรตติ้ง <a href="<?php $_SERVER['PHP_SELF']; ?>"><input name="refresh" type="button" value="รีเฟรช" /></a></div>
                <!-- show rating of this series-->
                <?php while ($row = $resultrating->fetch_assoc()) { ?>
                    <!-- นับจำนวน count ของเรตติ้งแต่ละอัน-->
                    <?php if ($row["rating"] == 5) { ?>
                        <?php $countfive++ ?>
                    <?php } else if ($row["rating"] == 4.5) { ?>
                        <?php $countfourdotfive++ ?>
                    <?php } else if ($row["rating"] == 4) { ?>
                        <?php $countfour++ ?>
                    <?php } else if ($row["rating"] == 3.5) { ?>
                        <?php $countthreedotfive++ ?>
                    <?php } else if ($row["rating"] == 3) { ?>
                        <?php $countthree++ ?>
                    <?php } else if ($row["rating"] == 2.5) { ?>
                        <?php $counttwodotfive++ ?>
                    <?php } else if ($row["rating"] == 2) { ?>
                        <?php $counttwo++ ?>
                    <?php } else if ($row["rating"] == 1.5) { ?>
                        <?php $countonedotfive++ ?>
                    <?php } else if ($row["rating"] == 1) { ?>
                        <?php $countone++ ?>
                    <?php } else if ($row["rating"] == 0.5) { ?>
                        <?php $countzerodotfive++ ?>
                    <?php } ?>
                <?php } ?>
                <?php
                $perfive = number_format((float)($countfive / $showcount) * 100, 2, '.', '');
                $perfourdotfive = number_format((float)($countfourdotfive / $showcount) * 100, 2, '.', '');
                $perfour = number_format((float)($countfour / $showcount) * 100, 2, '.', '');
                $perthreedotfive = number_format((float)($countthreedotfive / $showcount) * 100, 2, '.', '');
                $perthree = number_format((float)($countthree / $showcount) * 100, 2, '.', '');
                $pertwodotfive = number_format((float)($counttwodotfive / $showcount) * 100, 2, '.', '');
                $pertwo = number_format((float)($counttwo / $showcount) * 100, 2, '.', '');
                $peronedotfive = number_format((float)($countonedotfive / $showcount) * 100, 2, '.', '');
                $perone = number_format((float)($countone / $showcount) * 100, 2, '.', '');
                $perzerodotfive = number_format((float)($countzerodotfive / $showcount) * 100, 2, '.', '');
                $sum = (($countfive * 5) + ($countfourdotfive * 4.5) + ($countfour * 4) + ($countthreedotfive * 3.5) + ($countthree * 3) + ($counttwodotfive * 2.5) + ($counttwo * 2) + ($countonedotfive * 1.5) + ($countone * 1) + ($countzerodotfive * 0.5)) / $showcount;
                $sum = number_format((float)($sum), 2, '.', '');
                ?>
                <!-- แสดงข้อมูลเป็นกราฟ-->
                <div class="row">
                    คิดเป็นดาวเฉลี่ย <?php echo $sum ?> ดาว จากคนที่ให้เรตติ้งจำนวน <?php echo $showcount ?> คน โดยมีรายละเอียดดังนี้<br><br>
                    <?php $insert = $db->query("UPDATE series SET rating='$sum' WHERE id = $id "); ?>
                    <!--<?php if ($insert) { ?>
                    <?php echo "success " ?>
                <?php } else { ?>
                    <?php echo "Error " . $db->error; ?>
                <?php } ?>-->
                    <div class="side">
                        <div>5 ดาว</div>
                    </div>
                    <div class="middle">
                        <div class="bar-container">
                            <div class="bar-5" style="width:<?php echo $perfive; ?>%"></div>
                        </div>
                    </div>
                    <div class="side right">
                        <div><?php echo $countfive . " คน คิดเป็น " . $perfive . "%" ?></div>
                    </div>
                    <div class="side">
                        <div>4.5 ดาว</div>
                    </div>
                    <div class="middle">
                        <div class="bar-container">
                            <div class="bar-4-5" style="width:<?php echo $perfourdotfive; ?>%"></div>
                        </div>
                    </div>
                    <div class="side right">
                        <div><?php echo $countfourdotfive . " คน คิดเป็น " . $perfourdotfive . "%" ?></div>
                    </div>
                    <div class="side">
                        <div>4 ดาว</div>
                    </div>
                    <div class="middle">
                        <div class="bar-container">
                            <div class="bar-4" style="width:<?php echo $perfour; ?>%"></div>
                        </div>
                    </div>
                    <div class="side right">
                        <div><?php echo $countfour . " คน คิดเป็น " . $perfour . "%" ?></div>
                    </div>
                    <div class="side">
                        <div>3.5 ดาว</div>
                    </div>
                    <div class="middle">
                        <div class="bar-container">
                            <div class="bar-3-5" style="width:<?php echo $perthreedotfive; ?>%"></div>
                        </div>
                    </div>
                    <div class="side right">
                        <div><?php echo $countthreedotfive . " คน คิดเป็น " . $perthreedotfive . "%" ?></div>
                    </div>
                    <div class="side">
                        <div>3 ดาว</div>
                    </div>
                    <div class="middle">
                        <div class="bar-container">
                            <div class="bar-3" style="width:<?php echo $perthree; ?>%"></div>
                        </div>
                    </div>
                    <div class="side right">
                        <div><?php echo $countthree . " คน คิดเป็น " . $perthree . "%" ?></div>
                    </div>
                    <div class="side">
                        <div>2.5 ดาว</div>
                    </div>
                    <div class="middle">
                        <div class="bar-container">
                            <div class="bar-2-5" style="width:<?php echo $pertwodotfive; ?>%"></div>
                        </div>
                    </div>
                    <div class="side right">
                        <div><?php echo $counttwodotfive . " คน คิดเป็น " . $pertwodotfive . "%" ?></div>
                    </div>
                    <div class="side">
                        <div>2 ดาว</div>
                    </div>
                    <div class="middle">
                        <div class="bar-container">
                            <div class="bar-2" style="width:<?php echo $pertwo; ?>%"></div>
                        </div>
                    </div>
                    <div class="side right">
                        <div><?php echo $counttwo . " คน คิดเป็น " . $pertwo . "%" ?></div>
                    </div>
                    <div class="side">
                        <div>1.5 ดาว</div>
                    </div>
                    <div class="middle">
                        <div class="bar-container">
                            <div class="bar-1-5" style="width:<?php echo $peronedotfive; ?>%"></div>
                        </div>
                    </div>
                    <div class="side right">
                        <div><?php echo $countonedotfive . " คน คิดเป็น " . $peronedotfive . "%" ?></div>
                    </div>
                    <div class="side">
                        <div>1 ดาว</div>
                    </div>
                    <div class="middle">
                        <div class="bar-container">
                            <div class="bar-1" style="width:<?php echo $perone; ?>%"></div>
                        </div>
                    </div>
                    <div class="side right">
                        <div><?php echo $countone . " คน คิดเป็น " . $perone . "%" ?></div>
                    </div>
                    <div class="side">
                        <div>0.5 ดาว</div>
                    </div>
                    <div class="middle">
                        <div class="bar-container">
                            <div class="bar-0-5" style="width:<?php echo $perzerodotfive; ?>%"></div>
                        </div>
                    </div>
                    <div class="side right">
                        <div><?php echo $countzerodotfive . " คน คิดเป็น " . $perzerodotfive . "%" ?></div>
                    </div>

                </div>
            </div>
            <?php while ($row = $result->fetch_assoc()) { ?>

                <?php if ($row["comment"] != "") { ?>
                    <div class="subcomment">
                        ความคิดเห็นที่ <?= $order++ ?><br>
                        <?php echo $row["comment"] ?><br>
                        <div class="action">
                            <form method="post">
                                <?php $isliked = $row["id"]; ?>
                                <button value=<?php echo $isliked; ?> name="likethis" class="lock" title="ถูกใจ">
                                    <i class="	fa fa-thumbs-o-up"></i>
                                    <i class="	fa fa-thumbs-up"></i>
                                </button>
                                <!-- show like comment count-->
                                <?php if ($row["likecomment"] > 0) { ?>
                                    <?php echo $row["likecomment"] ?>
                                <?php } else { ?>
                                    <?php echo 0 ?>
                                <?php } ?>
                            </form>
                        </div>
                        <div class="info">
                            <span style="vertical-align:middle"><?= $row["commentusername"] ?></span>
                            <span style="vertical-align:middle">สมาชิกหมายเลข <?php echo $row["userid"] ?></span>

                        </div>
                        <br><br>
                        <button class='hideMessageForm' title="ร้องเรียน">
                            <i class="material-icons">warning</i>
                        </button>
                        <div id='foo' class='showMessageForm'>
                            <form action='' method='post'>
                                <b>ร้องเรียนความเห็น</b><br><br>
                                <textarea name="comment" placeholder="เขียนอธิบายเหตุผลที่ต้องการร้องเรียนให้แอดมินได้ทราบได้เลยค่ะ"></textarea><br><br>
                                <input type="hidden" name="idUS" value="<?php echo $row["id"]; ?>" />
                                <input type="submit" name="request" value="ร้องเรียน">
                            </form>
                        </div>
                    </div>

                <?php } ?>
            <?php } ?>
        <?php } else { ?>
            <div class="subcomment"> 0 comment <a href="<?php $_SERVER['PHP_SELF']; ?>"><input name="refresh" type="button" value="รีเฟชร" /></a></div>
        <?php } ?>
        <?php if ($cancomment == "yes") { ?>
            <!--เฉพาะคนที่เป็นสมาชิกถึงจะสามารถรีวิวได้-->
            <div class="review">
                <div class="wirte">เขียนรีวิว</div><br>
                <!--<?= $user ?><br>

        <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($profile); ?>" width="150" height="150" />-->
                ให้คะแนนซีรี่ย์เรื่องนี้<br>
                <form action="" method="post">
                    <div class=rating>
                        <fieldset class="rating">
                            <input type="radio" id="star5" name="rating" value="5" /><label class="full" for="star5" title="ดีมากๆ - 5 stars"></label>
                            <input type="radio" id="star4half" name="rating" value="4.5" /><label class="half" for="star4half" title="ดีมาก - 4.5 stars"></label>
                            <input type="radio" id="star4" name="rating" value="4" /><label class="full" for="star4" title="ค่อนข้างดีมาก - 4 stars"></label>
                            <input type="radio" id="star3half" name="rating" value="3.5" /><label class="half" for="star3half" title="ดี - 3.5 stars"></label>
                            <input type="radio" id="star3" name="rating" value="3" /><label class="full" for="star3" title="ค่อนข้างดี - 3 stars"></label>
                            <input type="radio" id="star2half" name="rating" value="2.5" /><label class="half" for="star2half" title="พอใช้ - 2.5 stars"></label>
                            <input type="radio" id="star2" name="rating" value="2" /><label class="full" for="star2" title="ค่อนข้างพอใช้ - 2 stars"></label>
                            <input type="radio" id="star1half" name="rating" value="1.5" /><label class="half" for="star1half" title="ค่อนข้างไม่ดี - 1.5 stars"></label>
                            <input type="radio" id="star1" name="rating" value="1" /><label class="full" for="star1" title="ไม่ดี - 1 star"></label>
                            <input type="radio" id="starhalf" name="rating" value="0.5" /><label class="half" for="starhalf" title="ไม่ดีมากๆ - 0.5 stars"></label>
                        </fieldset>
                    </div><br><br>
                    <textarea name="comment" placeholder="เล่ารายละเอียดตรงนี้ เขียนรีวิวให้เหมือนเล่าให้เพื่อนฟังเลยนะคะ"></textarea><br><br>
                    <input class="button1" type="submit" name="submit" value="บันทึกรีวิว"><input type="submit" name="cancel" value="ยกเลิก">
                    <br>หลังจากบันทึกแสดงความคิดเห็นแล้ว โปรดทำการกดปุ่มรีเฟรชความคิดเห็น
                </form>
            </div>

    </div>

<?php } else { ?>
    can't not comment
<?php } ?>
</div>
</body>

</html>
<script>
    /*jquery*/
    $(document).ready(function() {

        $(".showMessageForm").hide();
        $(".hideMessageForm").show();

        $('.hideMessageForm').click(function() {
            $(this).next(".showMessageForm").slideToggle();
        });

    });
</script>