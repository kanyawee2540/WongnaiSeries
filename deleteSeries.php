<?php
require_once 'dbConfig.php';
// sql to delete a record
$id=$_GET["id"];
$results = mysqli_query($db, "SELECT * FROM series WHERE id =$id");
$sql = "SELECT * FROM series WHERE id =$id";
$result = $db->query($sql);
if (!$results) {
  printf("Error: %s\n", mysqli_error($db));
  exit();
}else{
  $row = $result->fetch_assoc();
  $namefortable = preg_replace("/[^A-Za-z0-9]/", "", $row['name']);
}
$deleteInSeries = "DELETE FROM series WHERE id =$id";

$deleteTable = "DROP TABLE $namefortable";

if ($db->query($deleteInSeries) === TRUE && $db->query($deleteTable) === TRUE) {

  echo "<script>
  alert('ลบซีรี่ย์เรียบร้อย');
  window.location.href='seriesInfo.php';
  </script>";
} else {
  echo "<script>
  alert('ไม่สามารถลบได้ เนื่องจาก '.$db->error);
  window.location.href='seriesInfo.php';
  </script>";
}
$db->close();

?>