<?php
    //データベースの準備
    $dsn = 'mysql:dbname=データベース名;host=localhost';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    $DatabaseName = "tbtest";
    $sql = "CREATE TABLE IF NOT EXISTS ".$DatabaseName
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date TEXT,"
    . "password TEXT"
    .");";
    $stmt = $pdo->query($sql);
    
    
    
    //POSTから受け取って変数に格納
    
    //新規入力フォーム
    if(isset($_POST["NewName"])){
        $NewName = $_POST["NewName"];
    } 
    if(isset($_POST["NewComment"])){
        $NewComment = $_POST["NewComment"];
    } 
    
    //編集フォーム
    if(isset($_POST["EditNumber"])){
        $EditNumber = $_POST["EditNumber"];
    } 
    if(isset($_POST["EditName"])){
        $EditName = $_POST["EditName"];
    } 
    if(isset($_POST["EditComment"])){
        $EditComment = $_POST["EditComment"];
    }
    if(isset($_POST["EditFinishNumber"])){
        $EditFinishNumber = $_POST["EditFinishNumber"];
    } 
    
    //削除フォーム
    if(isset($_POST["DeleteNumber"])){
        $DeleteNumber = $_POST["DeleteNumber"];
    }
    
    //パスワードフォーム
    if(isset($_POST["Password"])){
        $Password = $_POST["Password"];
    }
?>