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

#填入今天日期和系辦人員名字
$today = date("Y-m-d");
$name = $_SESSION['借用人姓名'];

$result = mysqli_query($connect, "SELECT * FROM 申請資料表 WHERE 歸還日期 IS NULL and 系辦人員 IS NULL");
if(mysqli_num_rows($result)){
    while($row = mysqli_fetch_assoc($result)){
        $seq = $row['申請序號'];
        if(isset($_POST["return$seq"])){
            mysqli_query($connect, "UPDATE 申請資料表 SET 歸還日期 = '$today' WHERE 申請序號 = $seq");
            mysqli_query($connect, "UPDATE 申請資料表 SET 系辦人員 = '$name' WHERE 申請序號 = $seq");
        }
    }
}

header("Refresh: 0; URL=office_homepage.php"); #跳轉至學生借用畫面

?>