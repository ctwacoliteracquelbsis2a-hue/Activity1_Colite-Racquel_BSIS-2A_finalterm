<?php
    require_once "connect.php"; 

    function h($str){
        return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
    } 
    $mess = [];
    $errors = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $uname = $_POST['uname'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if($password === $password2){
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param('ss', $uname, $password);

     if($stmt->execute()){
        $mess[] = "Registed successfully. Please wait for admin approval of your account.";
     }else{
        $errors[] = "Something went wrong. Please try again later.";
     }
    }else{
        $errors[] = "Password should match";
    }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN UP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="body-login">
    <div class="login">
     <img src="nekoTech_logo.png" alt="kawaii">
     <br>
    <h1>Create your Account</h1>
    <br>
    <?php foreach ($errors as $e): ?>
        <p style = "color: red; font-size: 1.5rem;"><?php echo $e; ?></p>
        <?php endforeach;?>
    <br>
    <?php foreach ($mess as $m): ?>
        <p style = "color: green; font-size: 1.5rem;"><?php echo $m; ?></p>
        <?php endforeach;?>


    <form action="" method="post">
    <div class="input-box">
        <label class="top-n" for="">Username</label>
        <input type="text" name="uname" id="" placeholder="Enter Username" required autofocus>
        <label class="top-n" for="">Password</label>
        <input type="password" name="password" id="" placeholder="Enter Password" required>
         <label class="top-n" for="">Re-enter Password</label>
         <input type="password" name="password2" id="" placeholder="Re-enter Password" required>
    </div>
        <input class="btn"type="submit" value="Register">
    </form>
    <p class="extra-link">Already have an account? <a href="login.php">login</a></p>
    </div>
</div>
</body>
</html>
