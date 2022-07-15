<?php
session_start();
if(isset($_SESSION['user'])){
    header('location:php/home.php');
}
$error='';
$errorMdp='';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="logo">
        Taks<span>o</span>o
        </div>
    </header>
    <main>
    <div class="container">
        <?php
        if(isset($_COOKIE['account'])):
            ?>
                <div class="successfully">
                    <p>Your Account has been created</p>
                </div>
            <?php
        endif
        ?>
        
        <div class="forms">
            <div class="form login">
                <span class="title">Login</span>
            
                <?php
                    if(isset($_POST['login'])){
                        $email=$_POST['email1'];
                        $password=$_POST['password1'];
                        if(!empty($email) && !empty($password)){
                        include 'php/db.php';
                        $result=$conect->prepare('SELECT * FROM clients WHERE email=? AND password=?');
                        $result->execute([$email,$password]);
                        if($result->rowCount()>=1){
                            $_SESSION['user']=$result->fetch(PDO::FETCH_ASSOC);
                            header('location:php/home.php');
                        }else{
                            $error='Incorrect Email or Password <span id="tryAgain">try again</span>';
                        }
                        }else{
                            $error='All fields are mandatory';
                        }
                    }
                ?>

                <form  method="post">
                    <div class="input-field">
                        <input type="text" placeholder="Enter your email" required name="email1" id="finput" value="<?=@$email?>">
                        <img src="icon/mail.png"class="icon">
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" placeholder="Enter your password" required name="password1">
                        <img src="icon/padlock.png" alt="">
                        <img src="icon/eye.png" class="showHidePw">
                    </div>

                    
                    <div class="input-field button">
                        <input type="submit" value="Login" name="login">
                    </div>
                </form>

                <div class="login-signup">
                    <span class="text">Not a member?
                        <a href="#" class="text signup-link">Signup Now</a>
                    </span>
                </div>
                <p class="errore"><?=$error?></p>
            </div>

            <!-- Registration Form -->
            <div class="form signup">
                <span class="title">Registration</span>

                <?php
                    if(isset($_POST['signup'])){
                        $name=$_POST['name'];
                        $email1=$_POST['email2'];
                        $password1=$_POST['password2'];
                        $password2=$_POST['password3'];
                        if(!empty($name) && !empty($email1) && !empty($password1) && !empty($password2)){
                            if($password2==$password1){
                                include 'php/db.php';
                                $result=$conect->prepare('INSERT INTO clients values(null,?,?,?,null)');
                                $result->execute([$name,$email1,$password1]);
                                if($result){
                                    setcookie('account',true,time()+60);
                                    header("Refresh:0");
                                }
                        }else{
                            $error='All fields are mandatory';
                        }
                    }
                }
                ?>

                <form  method="post">
                    <div class="input-field">
                        <input type="text" placeholder="Enter your name" required name="name" value="<?=@$name?>">
                        <img src="icon/user.png" alt="">
                    </div>
                    <div class="input-field">
                        <input type="text" placeholder="Enter your email" required name="email2" value="<?=@$email1?>">
                        <img src="icon/mail.png" alt="">
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" placeholder="Create a password" required name="password2" value="<?=@$password1?>">
                        <img src="icon/padlock.png" alt="">
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" placeholder="Confirm a password" required name="password3" value="<?=@$password1?>">
                        <img src="icon/padlock.png" alt="">
                        <img src="icon/eye.png" class="showHidePw">
                    </div>
                    <p style="color:red"><?=$errorMdp?></p>

                   

                    <div class="input-field button">
                        <input type="submit" value="Signup" name="signup">
                    </div>
                </form>

                <div class="login-signup">
                    <span class="text">Already a member?
                        <a href="#" class="text login-link">Login Now</a>
                    </span>
                </div>
                <p class="errore"><?=$error?></p>
            </div>
        </div>
    </div>
    </main>
    <script src="js/script.js"></script>
</body>
</html>

