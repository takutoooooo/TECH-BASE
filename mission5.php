<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_3</title>
    </head>
    <body>
        
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
        ?>
        
        <h1>好きな食べ物について</h1>
        <form method="post">
            
            <!-- 編集番号フォーム -->
            編集はここ<br>
            <input type="number" name="FirstEditNumber" Placeholder="編集番号">
            <input type="submit"><br>
        
        <?php
            //編集フォーム
            //編集番号が入力されたら記入欄を特殊にする（nameとvalue）
            if(isset($_POST["FirstEditNumber"])){
                $FirstEditNumber = $_POST["FirstEditNumber"];
            } 
            if(!empty($FirstEditNumber)){
                $id = $FirstEditNumber; // idがこの値のデータだけを抽出したい、とする
                $sql = 'SELECT * FROM '.$DatabaseName.' WHERE id=:id';
                $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
                $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
                $stmt->execute();                             // ←SQLを実行する。
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    $FirstEditName = $row['name'];
                    $FirstEditComment = $row['comment'];
                }
                //編集フォーム
                echo "<br>コメント番号：".$FirstEditNumber."を編集します<br>";
        ?>
                <input type="hidden" name="EditNumber" value="<?php echo $FirstEditNumber ?>">
                <input type="text" name="EditName" value="<?php echo $FirstEditName ?>"><br>
                <input type="textarea" name="EditComment" value="<?php echo $FirstEditComment ?>"><br><br>
        <?php
            }else{
                //新規入力フォーム
                echo "<br>新規入力はここ<br>";
        ?>
                <input type="text" name="NewName" Placeholder="名前"><br>
                <input type="textarea" name="NewComment" Placeholder="コメント"><br><br>
        <?php
            }
        ?>
            <!-- 削除フォーム -->
            削除はここ<br>
            <input type="number" name="DeleteNumber" Placeholder="削除番号"><br><br>
            
            <!-- パスワードフォーム -->
            パスワード（必須）<br>
            <input type="text" name="Password" Placeholder="パスワード（必須）"><br><br>
            
            <input type="submit"><br><br>
        </form>
        
        <?php
            //新規入力フォーム
            if(isset($_POST["NewName"])){
                $NewName = $_POST["NewName"];
            } 
            if(isset($_POST["FirstEditNumber"])){
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
            
            //削除フォーム
            if(isset($_POST["DeleteNumber"])){
                $DeleteNumber = $_POST["DeleteNumber"];
            }
            
            //パスワードフォーム
            if(isset($_POST["Password"])){
                $Password = $_POST["Password"];
            }
            
            
            //新しいコメント
            if(!empty($NewComment)){
                if(!empty($Password)){
                    echo "<br>「名前：".$NewName."，コメント：".$NewComment."」を受け付けました<br><br>";
                    
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
                    echo "パスワードを入力してください<br><br>";
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
            
            
            //コメントを編集
            if(!empty($EditComment)){
                if(pass($DatabaseName,$pdo,$EditNumber)==$Password){
                    echo "<br>コメント番号：".$EditNumber."を編集しました<br><br>";
                    
                    $id = $EditNumber;
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
                }else{
                    echo "<br>パスワードが異なります<br><br>";
                }    
            }
            
            //コメントを削除
            if(!empty($DeleteNumber)){
                if(pass($DatabaseName,$pdo,$DeleteNumber)==$Password){
                    echo "<br>コメント番号：".$DeleteNumber."を削除しました<br><br>";
                    
                    $id = $DeleteNumber;
                    $sql = 'delete from '.$DatabaseName.' where id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                }else{
                    echo "<br>パスワードが異なります<br><br>";
                }
            }
            
            
            //コメントを表示
            $sql = 'SELECT * FROM '.$DatabaseName;
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                echo $row['id'].'　';
                echo $row['name'].'　';
                echo $row['comment'].'　';
                echo $row['date'].'<hr>';
            }
            
            
            //テーブル削除
            //$sql = 'DROP TABLE '.$DatabaseName;
            //$stmt = $pdo->query($sql);
        ?>
    </body>
</html>