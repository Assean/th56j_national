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

    
    $filename=$user."_".date("ymdhis").$ext; 
    $sourceImg=$pdo->query("SELECT `header` FROM `users` WHERE `username`='$user'")->fetchColumn();
    if(strlen($sourceImg)>0){
        unlink("../img/".$sourceImg);
    }
    
    // 修正：文件保存路徑
    $filepath='../img/'.$user.$ext;
    // 修正：數據庫只存文件名，不包含路徑
    $filename=$user.$ext;
    
    if(file_put_contents($filepath,$imgData)){
        echo 1;
        // 修正：UPDATE不應該賦值給$user，且使用正確的文件名
        $pdo->query("UPDATE `users` SET `header`='$filename' WHERE `username`='$user'");
        // 補充
        // header('type')
        // echo json_encode(['result'=>'上傳成功'])
    }else{
        echo 0;
    }