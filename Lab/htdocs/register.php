<?php

# 登入主機
$host = 'localhost';
# 使用者
$username = 'root';
# 密碼
$password = '';
# 資料庫名稱
$database = '使用者資料表';
# 連接資料庫
$connect = new mysqli($host, $username, $password, $database);

# 測試連線是否成功
if(!$connect){
	die("資料庫連線失敗: " . mysqli_connect_error());
}
// echo "資料庫連線成功!";

#取得使用者輸入的變數
$SID = $_POST['SID'];
$password = $_POST['password'];
$name = $_POST['name'];
$serial_number = $_POST['serial_number'];
$email = $_POST['email'];
$phone = $_POST['phone'];

# 執行SQL操作
$sql = "INSERT INTO 使用者資料表 (學號, 密碼, 姓名, 實驗室編號, Email, 連絡電話) VALUES ('$SID', '$password', '$name', '$serial_number', '$email', '$phone')";

# 驗證是否有插入成功
if(mysqli_query($connect, $sql)){
    if(mysqli_affected_rows($connect) > 0){
        echo "註冊成功!";
        header("Refresh: 2; URL=login.html");
        exit();
    }
    else{
        echo "註冊失敗!";
        header("Refresh: 2; URL=login.html");
        exit();
    }
}
else{
    echo "Error: " . $sql . "<br>" . mysqli_error($connect);
}

?>