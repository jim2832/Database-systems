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
	<h1>使用者資料</h1>
	<form action="admin_operation.php" method="POST">
		<table>
			<tr>
				<th>ID</th>
				<th>密碼</th>
				<th>姓名</th>
				<th>實驗室(辦公室)編號</th>
				<th>Email</th>
				<th>聯絡電話</th>
                <th>權限</th>
                <th>刪除使用者</th>
			</tr>

			<?php
				$connect = new mysqli("localhost", "root", "", "資料庫");

				// 測試連線是否成功
				if(!$connect){
					die("資料庫連線失敗: " . mysqli_connect_error());
				}

                $sql = mysqli_query($connect, "SELECT * FROM 使用者資料表 WHERE ID <> 'admin'");
                if(mysqli_num_rows($sql)){
					while($row = mysqli_fetch_assoc($sql)){
                        echo "<tr>
                                <td>".$row["ID"]."</td>
                                <td>".$row["密碼"]."</td>
                                <td>".$row["姓名"]."</td>
                                <td>".$row["實驗室編號或辦公室編號"]."</td>
                                <td>".$row["Email"]."</td>
                                <td>".$row["聯絡電話"]."</td>
                                <td>".$row["權限"]."</td>
                                <td>
                                    <button type='submit' name='delete{$row["ID"]}'>刪除</button>
                                </td>
                            </tr>";
                    }
                }
			?>

		</table>
	</form>

</body>
</html>
