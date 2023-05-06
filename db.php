<?php 
require_once 'config.php';
$dsn ='mysql:host='.$host.';dbname='.$dbname;
try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected";
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>