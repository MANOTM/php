<?php
try{
    $conect=new PDO("mysql:host=localhost;dbname=todolist","root","123456");
}catch(PDOException $r){
    die("errore====> ".$r->getMessage());
}
?>
