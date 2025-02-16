<?php
include "../Model/connection.php";
if(isset($_POST['login'])){
    session_start();
    $email=$_POST['email'];
    $password=$_POST['password'];
    
$query="SELECT * from admin where `password`='$password' and (`email`='$email' or `name`='$email')";
$res=mysqli_query($con,$query);
    if(mysqli_num_rows($res) > 0){
        $_SESSION['email']=$email;
        $_SESSION['password']=$password;
        header("location:../Pages/Index.php");
    }
    else{
        echo "<script>alert('Login Failed!!')
        window.location.assign('../Pages/Auth.php');
        </script>";
        
    }
}

?>