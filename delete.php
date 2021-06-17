<?php
require_once 'dbConfig.php';
// sql to delete a record
$id=$_GET["id"];
$sql = "DELETE FROM member WHERE id =$id";

if ($db->query($sql) === TRUE) {

  echo "<script>
  alert('ลบสมาชิกเรียบร้อยเห็นเรียบร้อย');
  window.location.href='memberInfo.php';
  </script>";
} else {
  echo "<script>
  alert('ไม่สามารถลบได้ เนื่องจาก '.$db->error);
  window.location.href='memberInfo.php';
  </script>";
}

$db->close();
?>