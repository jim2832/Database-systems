<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<title>教室借用狀態</title>
	<style>
		body{
			background-color: #f8f8d9;
		}

		table {
			border-collapse: collapse;
			width: 100%;
			margin: 20px 0;
		}

		table th, table td {
			border: 1px solid black;
			padding: 10px;
			text-align: center;
		}

		table th {
			background-color: #ccc;
		}

		.returned {
			color: green;
			font-weight: bold;
		}

		.not-returned {
			color: red;
			font-weight: bold;
		}

		input[type=submit] {
			background-color: green;
			width: 200px;
			display: block;
			margin: 0 left;
			color: white;
			font-weight: bold;
			padding: 10px;
			border-radius: 5px;
			border: none;
			cursor: pointer;
		}

		input[type=submit]:hover {
			background-color: #3e8e41;
		}

	</style>
</head>

<body>
	<h1>教室借用狀態</h1>
	
	<h2>已歸還</h2>
	<form>
		<table>
			<tr>
				<th>申請序號</th>
				<th>借用人學號</th>
				<th>借用人姓名</th>
				<th>借用教室編號</th>
				<th>日期</th>
				<th>節數</th>
				<th>申請設備</th>
				<th>歸還日期</th>
				<th>系辦負責人員</th>
			</tr>

			<?php
				session_start();
				$connect = new mysqli("localhost", "root", "", "資料庫");

				// 測試連線是否成功
				if(!$connect){
					die("資料庫連線失敗: " . mysqli_connect_error());
				}
				
				$apply = mysqli_query($connect, "SELECT * FROM 申請資料表");
				if(mysqli_num_rows($apply)){
					while($apply_row = mysqli_fetch_assoc($apply)){
						if($apply_row['歸還日期'] != "" && $apply_row['系辦人員'] != ""){
							#處理日期和節數
							$seq = $apply_row["申請序號"];
							$periods = ""; #存節數
							$date_period = mysqli_query($connect, "SELECT *
																	FROM 申請日期和節數表
																	WHERE 申請序號 = $seq");
							while($date_row = mysqli_fetch_assoc($date_period)){
								$date = $date_row['日期'];
								$periods .= $date_row['節數'];
							}
	
							#處理設備
							$devices = "";
							$device_query = mysqli_query($connect, "SELECT *
																	FROM 申請設備表
																	JOIN 設備資料表
																	ON 申請設備表.附加申請設備編號 = 設備資料表.設備編號
																	WHERE 申請序號 = $seq");
							while($device_row = mysqli_fetch_assoc($device_query)){
								$devices .= $device_row['設備名稱']." ";
							}
	
							#印出結果
							echo "<tr>
									<td>".$apply_row["申請序號"]."</td>
									<td>".$apply_row["借用人"]."</td>
									<td>".$apply_row["姓名"]."</td>
									<td>".$apply_row["教室編號"]."</td>
									<td>".$date."</td>
									<td>".$periods."</td>
									<td>".$devices."</td>
									<td>".$apply_row["歸還日期"]."</td>
									<td>".$apply_row["系辦人員"]."</td>
								</tr>";
						}
					}
				}
			?>

		</table>
	</form>

	<h2>未歸還</h2>
	<form action="office_management.php", method="POST">
		<table>
			<tr>
				<th>申請序號</th>
				<th>借用人學號</th>
				<th>借用人姓名</th>
				<th>借用教室編號</th>
				<th>日期</th>
				<th>節數</th>
				<th>申請設備</th>
				<th>歸還</th>
			</tr>

			<?php
				$connect = new mysqli("localhost", "root", "", "資料庫");

				// 測試連線是否成功
				if(!$connect){
					die("資料庫連線失敗: " . mysqli_connect_error());
				}
				
				$apply = mysqli_query($connect, "SELECT * FROM 申請資料表");
				if(mysqli_num_rows($apply)){
					while($apply_row = mysqli_fetch_assoc($apply)){
						if($apply_row['歸還日期'] == "" && $apply_row['系辦人員'] == ""){
							#處理日期和節數
							$seq = $apply_row["申請序號"];
							$periods = ""; #存節數
							$date_period = mysqli_query($connect, "SELECT *
																	FROM 申請日期和節數表
																	WHERE 申請序號 = $seq");
							while($date_row = mysqli_fetch_assoc($date_period)){
								$date = $date_row['日期'];
								$periods .= $date_row['節數'];
							}
	
							#處理設備
							$devices = "";
							$device_query = mysqli_query($connect, "SELECT *
																	FROM 申請設備表
																	JOIN 設備資料表
																	ON 申請設備表.附加申請設備編號 = 設備資料表.設備編號
																	WHERE 申請序號 = $seq");
							while($device_row = mysqli_fetch_assoc($device_query)){
								$devices .= $device_row['設備名稱']." ";
							}
	
							#印出結果
							echo "<tr>
									<td>".$apply_row["申請序號"]."</td>
									<td>".$apply_row["借用人"]."</td>
									<td>".$apply_row["姓名"]."</td>
									<td>".$apply_row["教室編號"]."</td>
									<td>".$date."</td>
									<td>".$periods."</td>
									<td>".$devices."</td>
									<td>
										<input type='checkbox' id='checkbox' name='return{$apply_row["申請序號"]}'>
									</td>
								</tr>";
						}
					}
				}
			?>

		</table>
	
		<input type="submit" value="執行">
	</form>
	
	<br><br>
	<form action="borrow_record.php", method="POST">
		<input type="submit" value="教室借用歷史紀錄">
	</form>

</body>
</html>
