<?php
    require_once "connect.php"; 

    function h($str){
        return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
    }
    $errors = [];

    if($_SERVER['REQUEST_METHOD'] === "POST"){
    $uname = $_POST['uname'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param('s',$uname);
    $stmt->execute();


    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    $stmt->close();

    if($user && $password === $user['password']){
        if($user['status'] !== "approved"){
            $errors[] = "Your account has not been approved by the admin.";            
        }else{
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header('location: dashboard.php');

            exit;
        }
    }else{
        $errors[] = "Invalid username or passsword.";
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="body-login">
    <div class="login">
        <img src="nekoTech_logo.png" alt="kawaii">
        <br>
    <h1>Login to your Account</h1>
    <br>
    <?php foreach ($errors as $e): ?>
        <p style = "color: red; font-size: 1.5rem;"><?php echo $e; ?></p>
        <?php endforeach;?>

    <form action="" method="post">
    <div class="input-box">
        <label class="top-n" for="">Username</label>
        <input type="text" name="uname" id="" placeholder="Enter Username" required autofocus>    
        <label class="top-n" for="">Password</label>
        <input type="password" name="password" id="" placeholder="Enter Password" required>
    </div>
        <input class="btn" type="submit" value="Login">
    </form>
    <p class="extra-link" >Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>
</div>    
</body>
</html>