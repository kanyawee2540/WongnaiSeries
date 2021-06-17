<?php
require 'dbConfig.php';
$msg = "";
use PHPMailer\PHPMailer\PHPMailer;
if(isset($_POST['send']) && $_POST['email'])
{
    $email = $_POST['email'];
    $query = "SELECT email,password FROM member WHERE email='$email'";
    $result = mysqli_query($db, $query);
  if(mysqli_num_rows($result) == 1)
  {
    while($row = mysqli_fetch_array($result))
    {
      $pass=md5($row['password']);
    }
    $to = $email;

$subject = 'Reset New Password For WongnaiSeries';
$admin = "WongnaiSeries@gmail.com";
$headers = "From: WongnaiSeries " . strip_tags($admin) . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$message = '<html><body>';
$message = "<a href='http://localhost/356/code/resetPass.php?key=".$email."&reset=".$pass."'>กดที่นี่เพื่อตั้งค่ารหัสผ่านใหม่</a>";
$message .= "</body></html>";
    $flgSend = mail($to, $subject, $message, $headers);
	if($flgSend)
	{
    echo "<script>
    alert('กรุณาตรวจสอบกล่องอีเมล เราส่งลิงก์สำหรับเปลี่ยนรหัสผ่านใหม่ไปยัง $email แล้ว หากไม่พบในกล่องอีเมลขาเข้า กรุณาตรวจสอบในกล่อง junk/spam mail');
    window.location.href='forgetPassword.php';
    </script>";
	}
	else
	{
		echo "ไม่สามารถส่งอีเมลได้ เนื่องจาก ".$mail->ErrorInfo;
	}
  }	
}
?>