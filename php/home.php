 <?php
session_start();
if(!isset($_SESSION['user'])){
header('location:../index.php');
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taksoo</title>
    <link rel="stylesheet" href="../css/styleHome.css">
</head>
<body>
    
    <header>
        <div class="container">
            <div class="logo">
                Taks<span>o</span>o
            </div>
            <div class="user">
            <img src="<?php 
            if($_SESSION['user']['profile']!=null){
                echo $_SESSION['user']['profile'];
            }else{echo '../images/undraw_male_avatar_323b.png';}
            ?>" alt="" class="profile">    
                <div class="userDiv">
                <span><?=$_SESSION['user']['nom']?></span>
                <img src="../icon/down-arrow.png" alt="" id="down">
                <div class="down">
                    <button id="Edit" >Edit profile</button>
                    <a href="logOut.php" id="Log" >Log out</a>
                </div>
                </div>
            </div>
        </div>
    </header>
    <main class="container">
        <div class="text">
            <p>Hello, <span><?=$_SESSION['user']['nom']?>!</span></p>
            <h1>Manage your <br> time & everything with <span>taksoo</span></h1>

            <form  method="get" class="search">
                <input type="search" name="search" placeholder="Search for taskes.." >
                <input type="submit" value="Search" name="searchBtn" >
            </form>
        </div>
        <img src="../images/undraw_Online_organizer_re_156n-removebg-preview.png" alt="">
    </main>

 <?php
    if(isset($_POST['save'])){
        $name=$_POST['name'];
        $email=$_POST['email1'];
        $password=$_POST['password'];
        if(!empty($name) && !empty($email) && !empty($password)){
            include 'db.php';
            $result=$conect->prepare('UPDATE clients set nom=?,email=?,password=? WHERE idC=?');
            $result->execute([$name,$email,$password,$_SESSION['user']['idC']]);
            $result=$conect->prepare("SELECT * FROM clients where idC=?");
            $result->execute([$_SESSION['user']['idC']]);
            $_SESSION['user']=$result->fetch(PDO::FETCH_ASSOC);
            header("Refresh:0");
            if(isset($_FILES['img'])){
                $dossier='photos/';
                $fichier=basename($_FILES['img']['name']);
                $name=time(). "-" . $fichier;
                $nameF=$dossier . $name;
                if(move_uploaded_file($_FILES['img']['tmp_name'],$nameF)){
                    $result=$conect->prepare('UPDATE clients SET profile=? WHERE idC=?');
                    $result->execute([$nameF,$_SESSION['user']['idC']]);
                    header("Refresh:0");
                }
            }
        }
        
    }
    ?>

    <div class="updateForm container">
        <div class="form login" >
            <form  method="post"  enctype="multipart/form-data">
                <input type="file" class="inputFile" name="img">
                <div class="profile-name">
                    <div class="avatarU">
                        <img src="" alt="" id="profile">
                        <div class="overlay"></div>
                        <img src="../icon/edit.png" alt="" class="editIcon">
                    </div>
                    <div class="input-field">
                        <input type="text"  required name="name" id="finput" value="<?=$_SESSION['user']['nom']?>">
                        <img src="../icon/user.png"class="icon">
                    </div>
                    
                </div>
                <div class="input-field">
                    <input type="text" required name="email1" id="finput" value="<?=$_SESSION['user']['email']?>">
                    <img src="../icon/mail.png"class="icon">
                </div>
                <div class="input-field">
                    <input type="password" class="password" value="<?=$_SESSION['user']['password']?>" required name="password">
                    <img src="../icon/padlock.png" alt="">
                </div>

                
                <div class="input-field button">
                    <input type="submit" value="Update" name="save">
                </div>
            </form>
        </div>
    </div>


    <section>
        <h1> Your Taskes</h1>
        <div class="notes">
            <div class="add div">
                <span>+</span>
                <p>Add new taske</p>
            </div>

<?php
if(isset($_GET['searchBtn'])){
    $search=$_GET['search'];
    if(!empty($search)){
        include 'db.php';
        $result=$conect->prepare('SELECT * FROM tasks Where title like? AND idC=? ');
        $search="%".$search."%";
        $result->execute([$search,$_SESSION['user']['idC']]);
        $data=$result->fetchAll(PDO::FETCH_ASSOC);
    }else{
        include 'db.php';
        $result=$conect->prepare('SELECT idtasks,title,date,text FROM tasks , clients WHERE tasks.idc=clients.idC AND clients.idC=?');
        $result->execute([$_SESSION['user']['idC']]);
        $data=$result->fetchAll(PDO::FETCH_ASSOC);
    }
}else{
    include 'db.php';
$result=$conect->prepare('SELECT idtasks,title,date,text FROM tasks , clients WHERE tasks.idc=clients.idC AND clients.idC=?');
$result->execute([$_SESSION['user']['idC']]);
$data=$result->fetchAll(PDO::FETCH_ASSOC);
}


if(isset($data)):
    foreach($data as $task):
    ?> 

        <div class="new div">
            <div>
            <h2 class="ti"><?=$task['title']?></h2>
            <p><?=$task['text']?></p>
            </div>
            <div>
            <hr>
            <div class="date-div">
                <p class="date"><?=$task['date']?></p>
                <a href="delete.php?idtask=<?=$task['idtasks']?>"><img src="../icon/bin.png" alt=""></a>
            </div>
        </div>
        </div>

    <?php
    endforeach;
endif;
?>





        </div> 
 <?php
if(isset($_POST['taske'])){
    $title=$_POST['title'];
    $text=$_POST['text'];
    $date=date("l F m Y");
    include 'db.php';
    $result=$conect->prepare('INSERT INTO tasks VALUES(null,?,?,?,?)');
    $result->execute([$title,$text,$date,$_SESSION['user']['idC']]);
    //hitach fach kadir search wkatji bghi tajouter kaytajouta ms makaytla3ch
    echo '<script>
    window.location.href="home.php"
    </script>';
}
?>
  
        <div class="blur">
        <form method="post" class="formAdd">
            <div class="first">
                <h3>Add a new Takse</h3>
                <p id="close">x</p>
            </div>
            <hr>
            <div>
                <p>Title</p>
                <input type="text" name="title">
                <br>
                <p>Description</p>
                <textarea id="text" name="text">
                </textarea>
                <br>
                <input type="submit" value="Add Taske" name="taske">
            </div>
        </form>   
    </div>  
    </section>



    <script src="../js/scriptHome.js"></script>
</body>
</html>