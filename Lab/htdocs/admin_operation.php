<?php

session_start();

# 登入主機
$host = 'localhost';
# 使用者
$username = 'root';
# 密碼
$password = '';
# 資料庫名稱
$database = '資料庫';
# 連接資料庫
$connect = new mysqli($host, $username, $password, $database);

# 測試連線是否成功
if(!$connect){
	die("資料庫連線失敗: " . mysqli_connect_error());
}

$result = mysqli_query($connect, "SELECT * FROM 使用者資料表 WHERE ID <> 'admin'");
if(mysqli_num_rows($result)){
    while($row = mysqli_fetch_assoc($result)){
        $ID = $row['ID'];
        if(isset($_POST["delete$ID"])){
            mysqli_query($connect, "DELETE FROM 使用者資料表 WHERE ID = '$ID'");
        }
    }
}

header("Refresh: 0; URL=admin.php"); #跳轉至學生借用畫面

?>