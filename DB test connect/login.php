  <div class="container">
   
<?php
$username=$_POST['username'];
$password=md5($_POST['password']);
$login=$_POST['login'];
if(isset($login)){
  $mysqli = new mysqli("localhost", "mydb2022o", "mydb2022o", "mydb2022");
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  }
  $res = $mysqli->query("SELECT * FROM login where username='$username' and password='$password'");
  $row = $res->fetch_assoc();
  $name = $row['name_login'];
  $user = $row['username'];
  $pass = $row['password'];
  if($user==$username && $pass=$password){
    session_start();
    $_SESSION['mysesi']=$name;
    echo "<script>window.location.assign('login.php')</script>";
  } else{
?>
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">�</span><span class="sr-only">Close</span></button>
  <strong>Warning!</strong> This username or password not same with database.
</div>
<?php
  }
}
?>
   
    <div class="panel panel-default">
      <div class="panel-body">
     
    <h2>Login Session</h2>
    <form role="form" method="post">
      <div class="form-group">
 <label for="username">Username</label>
 <input type="text" class="form-control" id="username" name="username">
      </div>
      <div class="form-group">
 <label for="password">Password</label>
 <input type="password" class="form-control" id="password" name="password">
      </div>
      <button type="submit" name="login" class="btn btn-primary">Login</button>
    </form>
       
      </div>
     </div>
     
  </div>