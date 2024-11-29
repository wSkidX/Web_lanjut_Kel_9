<?php
try{
    $dbh = new PDO('mysql:host=localhost;dbname=db_kelompok9','root','');
}catch(PDOException $e){
    print"Koneksi atau query bermasalah: ".$e->getMessage()."<br/>";
    die();
}
?>