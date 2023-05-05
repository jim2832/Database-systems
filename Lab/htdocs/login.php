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
// echo "資料庫連線成功!";

// 取得使用者輸入的帳號和密碼
$username = $_POST['username'];
$password = $_POST['password'];

# 存session
$query = mysqli_query($connect, "SELECT * FROM 使用者資料表 WHERE ID = '$username'");
$row = mysqli_fetch_assoc($query);
$_SESSION['借用人學號'] = $username;
$_SESSION['借用人姓名'] = $row['姓名'];

//查詢表格內使用者是否存在
$sql = "SELECT * FROM 使用者資料表 WHERE ID = '$username'";
$exist_result = mysqli_query($connect, $sql);

//查詢權限
$permission = "SELECT 權限 FROM 使用者資料表 WHERE ID = '$username'";
$permission_result = mysqli_query($connect, $permission);

//判斷使用者名稱是否存在
if(mysqli_num_rows($exist_result)){
	$row = mysqli_fetch_assoc($exist_result);
	#判斷密碼是否正確
	if ($password == $row['密碼']){
		#判斷用戶為學生還是系辦
		$permission_row = mysqli_fetch_assoc($permission_result);
		if(!$permission_row['權限']){
			echo "登入成功! (登入身分為學生)";
			header("Refresh: 1; URL=student_homepage.php"); #跳轉至學生借用畫面
			exit();
		}
		else if($permission_row['權限'] == 1){
			echo "登入成功! (登入身分為系辦)";
			header("Refresh: 1; URL=office_homepage.php"); #跳轉至系辦管理畫面
			exit();
		}
		else{
			echo "登入成功! (登入身分為系統管理者)";
			header("Refresh: 1; URL=admin.php"); #跳轉至系辦管理畫面
			exit();
		}
	}
	else{
		echo "密碼錯誤!";
		header("Refresh: 1; URL=login.html");
        exit();
	}
}
else{
	echo "使用者不存在! 請先註冊!";
	header("Refresh: 2; URL=login.html");
    exit();
}

#關閉資料庫的連線
// mysqli_close($connect)

?>