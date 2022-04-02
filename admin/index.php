<?php
include_once '../connectDB.php';
$db = new Config;

if(isset($_POST['login_admin'])){
    $email=$_POST['email_admin'];
    $password=$_POST['password_admin'];

    $rows = $db->select("SELECT * FROM admin WHERE email = '$email' AND password = '$password'")->fetch_assoc();
    
   
    if(!empty($rows)){
     
        $_SESSION['user']['id'] = $rows['id'];
         header("Location:/assignment/admin/admin.php");
     

    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">

    <link href="css/ad-style.css" rel="stylesheet">
</head>
<body>


<div id="id01" >

    <form class="modal-content animate" action="" method="post">


        <div class="container">
            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="email_admin" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password_admin" required>

            <button type="submit" name="login_admin">Login</button>

        </div>
    </form>
</div>

<script src="script/jquery.js"></script>
<script src="script/script.js"></script>
</body>
</html>