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

$today = date("Y-m-d");

$sql = "SELECT DISTINCT 申請資料表.借用人
        FROM 申請資料表, 申請日期和節數表
        WHERE 申請資料表.申請序號 = 申請日期和節數表.申請序號
        AND 申請資料表.歸還日期 IS NULL
        AND 申請日期和節數表.日期 = '$today'";
$result = mysqli_query($connect, $sql);
$row_count = mysqli_num_rows($result);

for($i=0; $i<$row_count; $i++){
    $row = mysqli_fetch_assoc($result);
    $ID = $row['借用人'];

    $person_info = "SELECT * FROM 使用者資料表 WHERE ID = '$ID'";
    $person_info_result = mysqli_query($connect, $person_info);

    $row_2 = mysqli_fetch_assoc($person_info_result);
    $data[$i][0] = $row_2['姓名'];
    $data[$i][1] = $row_2['Email'];
}

?>

<!-- html part -->
<!DOCTYPE html>
<html>
<head>
    <title>send email</title>
    <meta charset='utf-8'>
    <script type='text/javascript' src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
</head>
<body>

    <script type='text/javascript'>

        var send_number = <?php echo $row_count; ?>;
        if(send_number){
            var data = <?php echo json_encode($data); ?>;
            //初始化emailjs (填入自己的public key)
            emailjs.init('SUNbTzOGA5lHYmAyt');

            for(var i=0; i<send_number; i++){
                //填入service ID 和 template ID
                emailjs.send('service_a2094yn','template_pgcln0s',{
                    from_name: '系辦',
                    to_name: data[i][0],
                    to_email: data[i][1],
                    message: '您所借用的教室和設備尚未歸還，請盡速歸還!'});
            }
        }

    </script>
    <h1 style='text-align: center'>email自動發送成功!!</h1>

</body>
</html>