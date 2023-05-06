<?php 
require_once 'db.php';

function dd($data){
    echo "<pre>";
    var_dump($data);
    echo '</pre>';
}

function preVal($data){
    return trim($data);
}

function postVal($data){
    $data = filter_var($data, FILTER_SANITIZE_STRING);
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

function email($data){
    $data = preVal($data);
    return filter_var($data, FILTER_VALIDATE_EMAIL);
}

function required($data){
    $data = preVal($data);
    return (!empty($data)) ? true : false;  
}

function check($email){
    global $db;
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindvalue(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    return $result;
}

function password($password){
    // $password = preVal($password);
    $pattern = "/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,}$/";

    if(preg_match($pattern, $password) === 0){
        return false;
    }

    return true;
}

function session($res){
    $_SESSION['id'] = $res->id;
    $_SESSION['role'] = $res->role;
    $_SESSION['name'] = $res->name;
}

function login($email, $password){
    $user = check($email);
    if($user){
        if(password_verify($password, $user->password)){
            session($user);
            return true;
        }
        return false;
    }

    return false;
}

function setMessage($msg = '', $class = 'success'){

    if(!isset($_SESSION['msg']) && !empty($msg)){
        $_SESSION['msg'] = $msg;
    }elseif(isset($_SESSION['msg']) && empty($msg)){
        $res = $_SESSION['msg'];
        unset($_SESSION['msg']);
        echo "<div class='alert alert-{$class} alert-dismissible fade show' role='alert'>
                    <strong>{$res}</strong> 
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    }

    // return $res ?? '';
}

function isLoggedIn()
{
    if (isset($_SESSION['id'])) {
        return true;
    }

    return false;
}

function all($table = 'users'){
    global $db;
    $sql = "SELECT * FROM $table ORDER BY created_at DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchall(PDO::FETCH_OBJ);
}

function find($table, $column, $value){
    global $db;
    $sql = "SELECT * FROM $table WHERE $column = :".$column;
    $stmt = $db->prepare($sql);
    $stmt->bindvalue(":".$column, $value);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}
