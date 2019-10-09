<?php
//php info
date_default_timezone_set("Asia/Seoul");
echo date( "Y-m-d H:i:s" , time() );
echo "       ";
$mysql_hostname = 'localhost';
$mysql_username = 'root';
$mysql_password = 'abc41641';
$mysql_database = 'test1';

//DB연결
$connect = new mysqli($mysql_hostname, $mysql_username, $mysql_password, $mysql_database);
//DB연결 확인
if($connect->connect_errno){
  echo '[연결실패] : '.$connect->connect_error.'      ';
} else {
  echo 'sucess      ';
}

$Current_User = $_GET['code'];         //찍힌 사용자 carD
$Machine_ID = $_GET['Machine_ID'];   //찍은 세탁기 ID

//echo $Current_User;
//echo $Machine_ID;

$query = "select EndTime FROM machine_book WHERE MachineID_id = $Machine_ID ORDER BY id DESC LIMIT 1";//ENDTIME불러오기
$result = $connect->query($query); //쿼리실행
$Machine_EndTime = mysqli_fetch_array($result);

//echo $Machine_EndTime[0];
$Current_Time = date( "Y-m-d H:i:s" , time() );
$query2 = "select UserId_id FROM machine_book WHERE MachineID_id = $Machine_ID ORDER BY id DESC LIMIT 1";//해당 세탁기 예약자 id
$result2 = $connect->query($query2);  //쿼리실행
$Booker_ID = mysqli_fetch_array($result2);//실행된 쿼리값을 읽

//  echo $Booker_ID[0];

$query3 = "select CardId FROM account_user WHERE id = $Booker_ID[0]"; //예약자 id에 해당하는 카드번호
$result3 = $connect->query($query3);  //쿼리실행
$Booker_Card = mysqli_fetch_array($result3);//실행된 쿼리값을 읽음
/*
echo $Booker_Card[0];
echo $Current_Time;
*/
$query4 = "select ValidTime FROM machine_book WHERE MachineID_id = $Machine_ID ORDER BY id DESC LIMIT 1";
$result4 = $connect->query($query4);  //쿼리실행
$ValidTime = mysqli_fetch_array($result4);//실행된 쿼리값을 읽음
$UsableTime = date("Y-m-d H:i:s", strtotime('-10 minutes', strtotime($ValidTime[0])));

$query5 = "insert into machine_book (MachineId_id, UserId_id, ValidTime, EndTime) values ($Machine_ID, $Booker_ID[0], ADDTIME(now(), '00:30:00'), ADDTIME(now(), '00:50:00'))";//해당 세탁기 정보 업뎃
$query6 = "update account_user set Penalty = Penalty + 1 WHERE id = $Booker_ID[0]";

if (empty($Machine_EndTime[0])) {
  if($Current_Time > $ValidTime[0] ){
    $connect->query($query6);
    $connect->query($query5);
    echo 'NoShow_JustUse';
  } elseif ($Current_Time > $UsableTime){
    if ($Booker_Card[0] == $Current_User) {
      $connect->query($query5);
      echo 'Match';
    } else {
      echo 'Booker_Existing';
    }
  } else {
    echo 'Still_Using';
  }
} elseif($Machine_EndTime[0] < $Current_Time) {
  $connect->query($query5);
  echo 'NoBooker_JustUse';
} else {
  echo 'StillUsing';
}

 ?>
