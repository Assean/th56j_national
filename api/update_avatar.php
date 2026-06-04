<?php include "db.php";
$src=explode(",",$_POST['imgString']);
$ext=strpos($src[0],'png')!==false?'.png':(strpos($src[0],'gif')!==false?'.gif':'.jpg');
$user=$_SESSION['user'];
$old=$pdo->query("SELECT `header` FROM `users` WHERE `username`='$user'")->fetchColumn();
if($old) @unlink("../img/$old");
$filename=$user.$ext;
echo file_put_contents("../img/$filename",base64_decode($src[1]))?1:0;
if(1) $pdo->exec("UPDATE `users` SET `header`='$filename' WHERE `username`='$user'");
