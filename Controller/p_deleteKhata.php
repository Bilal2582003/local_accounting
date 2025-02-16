<?php
if(isset($_GET['id'])){
    include "../Model/connection.php";
    $id=$_GET['id'];
$query="DELETE FROM p_khata where id=$id ";
$res=mysqli_query($con,$query);
header("location:../Pages/Index.php");
}

?>