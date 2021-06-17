<?php
require_once 'dbConfig.php';
// sql to delete a record
$id=$_GET["id"];
echo $id;
$results = mysqli_query($db, "SELECT * FROM requesttodeletecomment WHERE idToDelete =$id");
$sql = "SELECT * FROM requesttodeletecomment WHERE idToDelete =$id";
$result = $db->query($sql);
if (!$results) {
  printf("Error: %s\n", mysqli_error($db));
  exit();
}else{
  $row = $result->fetch_assoc();
  $namefortable = preg_replace("/[^A-Za-z0-9]/", "", $row['seriesName']);
}
$deleteInrequest = "DELETE FROM requesttodeletecomment WHERE idToDelete =$id";
$deleteInSeries = "UPDATE $namefortable SET comment = NULL WHERE id = '" . $id . "' ";

if ($db->query($deleteInSeries) === TRUE && $db->query($deleteInrequest)=== TRUE) {

    echo "<script>
  alert('ลบความคิดเห็นเรียบร้อย');
  window.location.href='request.php';
  </script>";
} else {
  echo "<script>
  alert('ไม่สามารถลบได้ เนื่องจาก '.$db->error);
  window.location.href='request.php';
  </script>";
  //echo "Error deleting record: " . $db->error;
}

$db->close();

?>