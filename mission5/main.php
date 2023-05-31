<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_3</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header>
            <div class="title">
                <h1>Favorite Food</h1>
            </div>
        </header>
        <div class="content">
            <?php
                //データベースの準備
                require_once("Prepare.php");
                
                //コメントの管理
                require_once("Comment.php");
            ?>
            <div class='table'>
                <div class='table-title'>
                    <!--<a class='id'>番号</a>-->
                    <a class='name name-title'>名前</a>
                    <a class='comment'>好きな食べ物</a>
                    <a class='date'>日付</a>
                    <a class='pass'>パスワード</a>
                    <div class='clear'></div>
                </div>
                    
                <div class='lines'>
                <?php
                    //コメントを表示
                    
                    $sql = 'SELECT * FROM '.$DatabaseName;
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                    
                    $lastnum = 0;//追加用にコメントカウント
                    foreach ($results as $row){
                        echo "<div class='line'>";
                            //番号
                            echo "<a class='id'>".$row['id']."</a>";
                            
                            //編集時のみ編集フォーム
                            if(!empty($EditNumber) && $row['id']==$EditNumber && pass($DatabaseName,$pdo,$EditNumber)==$Password){
                                echo "<form class='editform' method='post'>";
                                    echo "<input class='editname' type='textarea' name='EditName' value=".$EditName.">";
                                    echo "<input class='editcomment' type='textarea' name='EditComment' value=".$EditComment.">";
                                    echo "<button class='button' type='submit' name='EditFinishNumber' value=".$row['id'].">完了</button>";
                                echo "</form>";
                            }else{
                                echo "<a class='name'>".$row['name']."</a>";
                                echo "<a class='comment'>".$row['comment']."</a>";
                            }
                            
                            //日付
                            echo "<a class='date'>".$row['date']."</a>";
                            
                            //削除編集ボタン
                            echo "<form class='deleteeditform' method='post'>";
                                echo "<input class='pass' type='text' name='Password' Placeholder='パスワード'>";
                                echo "<button class='button' type='submit' name='DeleteNumber' value=".$row['id'].">削除</button>";
                                echo "<button class='button' type='submit' name='EditNumber' value=".$row['id'].">編集</button>";
                            echo "</form>";
                            
                            echo "<div class='clear'></div>";
                        echo "</div>";
                        
                        $lastnum = $row['id'];//追加用にコメントカウント
                    }
                    
                    
                    //0行ならテーブル削除（idリセットのため）
                    $sql = 'SELECT * FROM '.$DatabaseName;
                    $stmt = $pdo->query($sql);
                    $results = $stmt->fetchAll();
                    if(count($results)==0){
                        $sql = 'DROP TABLE '.$DatabaseName;
                        $stmt = $pdo->query($sql);
                    }
                ?>
                </div>
                
                
                <div class='add'>
                    <form class='newform' method='post'>
                        <a class='id'><?php echo $lastnum+1 ?></a>
                        <input class='editname' type='textarea' name="NewName" Placeholder="名前">
                        <input class='editcomment' type='textarea' name='NewComment' Placeholder="好きな食べ物">
                        <input class='pass newpass' type='text' name='Password' Placeholder='パスワード'>
                        <button class='button' type='submit'>追加</button>
                        <div class='clear'></div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>