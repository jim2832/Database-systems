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

// 查詢表格並合併兩個結果
$query = "SELECT * FROM 申請資料表 JOIN 申請日期和節數表 ON 申請資料表.申請序號 = 申請日期和節數表.申請序號";
$result = mysqli_query($connect, $query);

# 取得使用者輸入
$query_id = $_POST['query_id'];
$query_date = $_POST['query_date'];

# 查詢
$periods = [];
$exist = false; 
if(isset($_POST['query_button'])){
    while ($row = mysqli_fetch_assoc($result)) {
        if($query_id == $row['教室編號'] && $query_date == $row['日期']){
            array_push($periods, $row['節數']);
            $exist = true;
        }
    }
    if(!$exist){
        echo "查無資料!";
        header("Refresh: 2; URL=student_homepage.php"); #跳轉至學生借用畫面
        exit();
    }

    echo "教室 $query_id 在 $query_date 已被借用的節數為: ";
    foreach ($periods as $element){
        echo "$element ";
    }
    echo "節";
}

?>