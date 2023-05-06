<?php require_once __DIR__.'/../init.php';

    unset($_SESSION['id']);
    unset($_SESSION['role']);
    unset($_SESSION['name']);
    session_destroy();
    $page = '../index.php';
    header('Location: '.$page);
        
    
?>