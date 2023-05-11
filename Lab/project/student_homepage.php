<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
	<title>教室借用系統</title>
	<link rel="stylesheet" href="student_homepage.css">
</head>
<body>
	<div class="container">

		<div class="left">
			<!-- 左側內容 -->
      <div class="classroom_info">
        <?php
        session_start();
        echo "<h1>";
        echo $_SESSION['借用人姓名'];
        echo "，您好!</h1>";
        echo "<form action='logout.php' method='POST' style='width: 70px; height: 70px;'>
                <button type='submit' name='logout'>登出</button><br><br>
              </form>";
        ?>
        <h1>教室資訊</h1>
        <table>

          <tr>
            <th>教室編號</th>
            <th>教室位置</th>
            <th>容納人數</th>
          </tr>

          <!-- 透過PHP來呼叫資料庫的資訊 -->
          <?php
          $connect = new mysqli("localhost", "root", "", "資料庫");

          // 測試連線是否成功
          if(!$connect){
            die("資料庫連線失敗: " . mysqli_connect_error());
          }
          
          $sql = "SELECT * FROM 教室資料表";
          $result = mysqli_query($connect, $sql);
          if(mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)){
              echo "<tr>
                        <td>".$row["教室編號"]."</td>
                        <td>".$row["教室位置"]."</td>
                        <td>".$row["容納人數"]."</td>
                    </tr>";
            }
          }
          ?>
        </table>
        <br><br><br>
      </div>

      <div class="borrow">
        <form action="classroom_query.php" method="POST">
          <h1>查詢教室是否被借用</h1>

          <!-- <label for="classroom_query">請輸入要查詢的教室編號：</label> -->
          <h3>請輸入要查詢的教室編號：</h3>
          <input type="text" name="query_id" style="width: 50%">

          <!-- <label for="date_query">請輸入要查詢的日期：</label> -->
          <h3>請輸入要查詢的日期：</h3>
          <input type="date" name="query_date" style="width: 50%">
          <br>
          
          <button type="submit" name="query_button" style="width: 10%">查詢</button>
          
        </form>
      </div>

		</div>
    
		<div class="right">
			<h1>教室借用表單</h1>
			<form action="classroom_borrow.php" method="post">
        <br>
        <h3>借用人學號：</h3>

        <?php 
        echo $_SESSION['借用人學號'];
        ?>
				<br><br>

        <h3>借用人姓名：</h3>
        <?php 
        echo $_SESSION['借用人姓名'];
        ?>
				<br><br><br>

        <h3>要借用的教室編號：</h3>
				<input type="text" name="room_no" style="width: 75%" required>
				<br>


				<h3>日期：</h3>
        <input type="date" name="date" style="width: 75%" required>
				<br>

				<h3>節數：</h3>
        <div class="period">
          <input type="checkbox" id="checkbox1" name="period1">
          <label for="checkbox1">第一節</label>
          <input type="checkbox" id="checkbox2" name="period2">
          <label for="checkbox2">第二節</label>
          <input type="checkbox" id="checkbox3" name="period3">
          <label for="checkbox3">第三節</label>
          <input type="checkbox" id="checkbox4" name="period4">
          <label for="checkbox4">第四節</label>
          <input type="checkbox" id="checkbox5" name="period5">
          <label for="checkbox5">第五節</label>
          <input type="checkbox" id="checkbox6" name="period6">
          <label for="checkbox6">第六節</label>
          <input type="checkbox" id="checkbox7" name="period7">
          <label for="checkbox7">第七節</label>
          <input type="checkbox" id="checkbox8" name="period8">
          <label for="checkbox8">第八節</label>
        </div>
				<br>


        <h3>附加申請設備：</h3>
        <div class="device">
          <input type="checkbox" id="laptop" name="device1">
          <label for="laptop">筆記型電腦</label>
          <input type="checkbox" id="mic" name="device2">
          <label for="mic">麥克風</label>
          <input type="checkbox" id="laser" name="device3">
          <label for="laser">雷射筆</label>
          <input type="checkbox" id="adapter" name="device4">
          <label for="adapter">轉接頭</label>
          <input type="checkbox" id="alcohol" name="device5">
          <label for="alcohol">酒精</label>
        </div>
				<br>

				<input type="submit" value="送出">
			</form>
		</div>
	</div>
</body>
</html>
