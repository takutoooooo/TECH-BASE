<?php
    //新しいコメント
    if(!empty($NewComment)){
        if(!empty($Password)){
            $sql = $pdo -> prepare("INSERT INTO ".$DatabaseName." (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql -> bindParam(':date', $date, PDO::PARAM_STR);
            $sql -> bindParam(':password', $password, PDO::PARAM_STR);
            
            $name = $NewName;
            $comment = $NewComment;
            $date = date("Y/m/d H:i:s");
            $password = $Password;
            
            $sql -> execute();
        }else{
            echo "<h3>パスワードを入力してください</h3>";
        }
    }
    
    
    //パスワード抽出の関数
    function pass($DatabaseName1,$pdo1,$Num){
        $id = $Num; // idがこの値のデータだけを抽出したい
        $sql = 'SELECT * FROM '.$DatabaseName1.' WHERE id=:id';
        $stmt = $pdo1->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
        $stmt->execute();                             // ←SQLを実行する。
        
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            $CorrectPass = $row['password'];
        }
        return $CorrectPass; //パスワードを抽出して返す
    }
    
    
    //コメント編集フォームに既存のコメントを表示するためのコード
    if(!empty($EditNumber)){
        if(pass($DatabaseName,$pdo,$EditNumber)==$Password){
            $id = $EditNumber; // idがこの値のデータだけを抽出したい
            $sql = 'SELECT * FROM '.$DatabaseName.' WHERE id=:id';
            $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
            $stmt->execute();                             // ←SQLを実行する。
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                $EditComment = $row['comment'];
                $EditName = $row['name'];
            }
        }else{
            echo "<h3>パスワードが異なります</h3>";
        }
    }
    
    //コメントを編集
    if(!empty($EditComment) && !empty($EditFinishNumber)){
        $id = $EditFinishNumber;
        $name = $EditName;
        $comment = $EditComment;
        $date = date("Y/m/d H:i:s");
        
        $sql = 'UPDATE '.$DatabaseName.' SET name=:name,comment=:comment,date=:date WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    
    //コメントを削除
    if(!empty($DeleteNumber)){
        if(pass($DatabaseName,$pdo,$DeleteNumber)==$Password){
            $id = $DeleteNumber;
            $sql = 'delete from '.$DatabaseName.' where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }else{
            echo "<h3>パスワードが異なります</h3>";
        }
    }
?>