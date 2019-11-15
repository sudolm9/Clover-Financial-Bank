<?php

$dbn = "mysql:host=localhost;dbname=YKdatabase";
$databaseusername = "yongbum";
$databasepassword = "kim";
$status = '';



try {
    $conn = new PDO($dbn, $databaseusername, $databasepassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$connect = null;
?>
