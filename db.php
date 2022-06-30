<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
}
$username = "";
$email = "";
$errors = array();
$host = 'localhost';
$user = 'roote';
$pass = '1234';
$dbname = 'dbtodo';

$conn = mysqli_connect($host, $user, $pass, $dbname);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
if (isset($_POST['register'])){
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
  if(empty($username)){
    array_push($errors, "Username is required");
  }
  if(empty($email)){
    array_push($errors,  "Email is required");
  }
  if(empty($password_1)){
    array_push($errors, "Password is required");
  }
  if($password_1 != $password_2){
    array_push($errors, "The two passwords do not match");
  }
  if(count($errors)==0){
    $password = md5($password_1);
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    mysqli_query($conn, $sql);
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in";
    header('location: index.php');
  }
  if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(empty($username)){
      array_push($errors, "Username is required");
    }
    if(empty($password)){
      array_push($errors, "Password is required");
    }
    if(count($errors)==0){
      $password = md5($password);
      $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
      $results = mysqli_query($conn, $query);
      if(mysqli_num_rows($results) == 1){
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
      }else{
        array_push($errors, "Wrong username/password combination");
      }
    }
  }

}
  if  (isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['username']);
    header("location: index.php");
  }
?>