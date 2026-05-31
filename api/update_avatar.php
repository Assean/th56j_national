<?php
    include "db.php";
    $img=$_POST['imgString'];
    $user=$_SESSION['user'];
    $source=explode(",",$img);
    $imgData=base64_decode($source[1]);
    if(strpos($source[0],'jpeg')!==false){
        $ext=".jpg";
    }elseif(strpos($source[0],'png')!==false){
        $ext=".png";
    }elseif(strpos($source[0],'gif')!==false){
        $ext=".gif";
    }else{
        $ext=".jpg";
    }
    $sourceImg=$pdo->query("SELECT `header` FROM `users` WHERE `username`='$user'")->fetchColumn();
    if(strlen($sourceImg)>0){
        unlink("../img/".$sourceImg);
    }
    $filepath='../img/'.$user.$ext;
    $filename=$user.$ext;
    if(file_put_contents($filepath,$imgData)){
        echo 1;
        $pdo->query("UPDATE `users` SET `header`='$filename' WHERE `username`='$user'");
    }else{
        echo 0;
    }