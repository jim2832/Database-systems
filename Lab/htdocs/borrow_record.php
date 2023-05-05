<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<title>教室借用歷史紀錄</title>
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
	</style>
</head>
<body>
	<h1>所有借用紀錄</h1>
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
							</tr>";
					}
				}
			?>

		</table>
	</form>
</body>
</html>
