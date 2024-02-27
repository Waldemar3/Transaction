<?php
    require_once 'db-connection.php';
    require_once '../src/Transactions.php';
    
    $transactions = new Transactions($pdo);
    //$transactions->factory();

    try{
        $id = $_GET['id'];
        if(empty($id)) throw new Exception('Передайте id пользователя в адресной строке');
        echo $transactions->read($id);
    }catch(\Exception $e){
        echo $e->getMessage();
    }
?>