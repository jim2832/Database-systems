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

// 查詢表格並合併兩個結果
$query = "SELECT * FROM 申請資料表 JOIN 申請日期和節數表 ON 申請資料表.申請序號 = 申請日期和節數表.申請序號";
$query_result = mysqli_query($connect, $query);


// 取得使用者的輸入
$room_no = $_POST['room_no']; #教室編號
$borrower = $_SESSION['借用人學號']; # 借用人
$name = $_SESSION['借用人姓名']; # 姓名
$date = $_POST['date']; #日期 -> 2023-05-03


# 設定session
$_SESSION['教室編號'] = $room_no;
$_SESSION['借用日期'] = $date;


# 申請序號
$seq = 1;
$num = "SELECT * FROM 申請資料表";
$result = mysqli_query($connect, $num);
if(mysqli_num_rows($result)){
	while($row = mysqli_fetch_assoc($result)){
		$seq++;
	}
}


# 判斷填入的教室編號是否存在
$invalid = true;
$class_result = mysqli_query($connect, "SELECT * FROM 教室資料表");
if(mysqli_num_rows($class_result)){
	while($row = mysqli_fetch_assoc($class_result)){
		if($room_no == $row['教室編號']){
			$invalid = false;
			break;
		}
	}
}
if($invalid){
	echo "請填寫有效的教室編號!!";
	header("Refresh: 2; URL=student_homepage.php"); #跳轉至學生借用畫面
	exit();
}


// 檢查是否有填至少1節
$period_count = 0;
for($i=1; $i<=8; $i++){
	if(isset($_POST["period{$i}"])){
		$period_count++;
	}
}
if(!$period_count){
	echo "請至少填1節課!!";
	header("Refresh: 2; URL=student_homepage.php"); #跳轉至學生借用畫面
	exit();
}


# 計算借用設備數量
$devices = [];
$device_count = 0;
for($i=1; $i<=5; $i++){
	if(isset($_POST["device{$i}"])){
		$device_count++;
		array_push($devices, $i);
	}
}


#####################判斷借用的節數是否有衝突#####################

$collision = false;
$borrowed_periods = []; //已借用的節數
$apply_periods = []; //欲借用的節數
while ($row = mysqli_fetch_assoc($query_result)) {
	if($room_no == $row['教室編號'] && $date == $row['日期']){
		array_push($borrowed_periods, $row['節數']);
	}
}
for($i=1; $i<=8; $i++){
	if(isset($_POST["period{$i}"])){
		array_push($apply_periods, $i);
	}
}

$collisions = [];
for($i=0; $i<sizeof($borrowed_periods); $i++){
	for($j=0; $j<sizeof($apply_periods); $j++){
		if ($borrowed_periods[$i] == $apply_periods[$j]){
			$collision = true;
			array_push($collisions, $borrowed_periods[$i]);
		}
	}
}

if($collision){
	echo "借用失敗!!<br>您借用了 ";
	for($i=0; $i<sizeof($apply_periods); $i++){
		echo $apply_periods[$i];
		echo " ";
	}
	echo "節 <br>其中第 ";
	for($i=0; $i<sizeof($collisions); $i++){
		echo $collisions[$i];
		echo " ";
	}
	echo "節已被借走";
	header("Refresh: 2; URL=student_homepage.php"); #跳轉至學生借用畫面
	exit();
}


#######################################申請表#######################################

# 申請資料表
mysqli_query($connect, "INSERT INTO 申請資料表 (申請序號, 教室編號, 借用人, 姓名)
						VALUE ('$seq', '$room_no', '$borrower', '$name')");

# 申請日期和節數表
for($i=1; $i<=8; $i++){
	if(isset($_POST["period{$i}"])){
		mysqli_query($connect, "INSERT INTO 申請日期和節數表 (申請序號, 日期, 節數)
								VALUE ('$seq', '$date', '$i')");
	}
}

# 申請設備表
for($i=1; $i<=5; $i++){
	if(isset($_POST["device{$i}"])){
		mysqli_query($connect, "INSERT INTO 申請設備表 (申請序號, 附加申請設備編號)
								VALUE ('$seq', '$i')");
	}
}

#######################################設備和節數之session#######################################

# 將欲借用的節數轉換成字串存在session
$str = "";
foreach ($apply_periods as $period){
	$str .= strval($period);
}
$_SESSION['借用節數'] = $str;


# 將欲借用的設備轉換成字串存在session
$s = "";
$device_query = "SELECT 設備名稱 FROM 申請設備表 JOIN 設備資料表 ON 申請設備表.附加申請設備編號 = 設備資料表.設備編號 WHERE 申請序號 = $seq";
$device_result = mysqli_query($connect, $device_query);
while ($row = mysqli_fetch_assoc($device_result)){
	$s .= $row['設備名稱'];
	$s .= "  ";
}
if($s != ""){
	$_SESSION['設備'] = $s;
}
else{
	$_SESSION['設備'] = "無";
}


header("Refresh: 0; URL=borrow_success.html"); #跳轉至借用成功畫面
exit();

?>