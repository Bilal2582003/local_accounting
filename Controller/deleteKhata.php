<?php
if(isset($_GET['id'])){
    include "../Model/connection.php";
    $id=$_GET['id'];
    $today_date = date("Y-m-d H:i:s");
$query="UPDATE khata set deleted_at = '$today_date', delete_reason = 'delete' where id=$id ";
$res=mysqli_query($con,$query);
header("location:../Pages/Index.php");
}

?>