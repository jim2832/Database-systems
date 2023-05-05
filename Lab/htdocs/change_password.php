<?php

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

#取得使用者輸入的變數
$account = $_POST['account'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

#查詢資料庫
$sql = "SELECT * FROM 使用者資料表 WHERE ID = '$account'";
$exist_result = mysqli_query($connect, $sql);

# 驗證操作是否合法
if(mysqli_num_rows($exist_result)){
	$row = mysqli_fetch_assoc($exist_result);
    #判斷密碼是否正確
	if ($current_password == $row['密碼']){
        #判斷確認密碼是否和新密碼一樣
		if($new_password == $confirm_password){
            $update = "UPDATE 使用者資料表 SET 密碼 = '$new_password' WHERE ID = '$account'";
            $update_result = mysqli_query($connect, $update);
            echo "密碼變更成功! 即將為您導回登入畫面...";
            header("Refresh: 2; URL=login.html");
            exit();
        }
        else{
            echo "確認密碼與新密碼不相符!";
            header("Refresh: 2; URL=change_password.html");
            exit();
        }
	}
	else{
		echo "密碼錯誤!";
		header("Refresh: 2; URL=login.html");
        exit();
	}
}
else{
	echo "使用者不存在! 請先註冊!";
	header("Refresh: 2; URL=login.html");
    exit();
}

?>