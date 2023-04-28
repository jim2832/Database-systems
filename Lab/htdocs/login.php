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

// 取得使用者輸入的帳號和密碼
$username = $_POST['username'];
$password = $_POST['password'];

//查詢SQL表格
$sql = "SELECT * FROM 使用者資料表 WHERE 學號 = '$username'";
$result = mysqli_query($connect, $sql);

//判斷使用者名稱是否存在
if(mysqli_num_rows($result)){
	$row = mysqli_fetch_assoc($result);
	#判斷密碼是否正確
	if ($password == $row['密碼']){
		echo "登入成功!";
        header("Refresh: 1; URL=classroom_borrow.html"); #跳轉至借用畫面
		exit();
	}
	else{
		echo "密碼錯誤!";
		header("Refresh: 1; URL=login.html");
        exit();
	}
}
else{
	echo "使用者不存在!";
	header("Refresh: 2; URL=login.html");
    exit();
}

#關閉資料庫的連線
// mysqli_close($connect)

?>