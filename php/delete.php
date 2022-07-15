<?php
if(isset($_GET['idtask'])){
    include 'db.php';
    $result=$conect->prepare('DELETE FROM tasks WHERE idtasks=?');
    $result->execute([$_GET['idtask']]);
    header('location:home.php');
}
?>