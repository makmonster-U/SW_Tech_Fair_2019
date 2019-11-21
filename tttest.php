<?php
$query2 = "select UserId_id FROM machine_book WHERE MachineID_id = $Machine_ID LIMIT 1";//해당 세탁기 예약자 id
$result2 = $connect->query($query2);  //쿼리실행
$Booker_ID = mysqli_fetch_array($result2);//실행된 쿼리값을 읽

//  echo $Booker_ID[0];

$query3 = "select CardId FROM account_user WHERE id = $Booker_ID[0]"; //예약자 id에 해당하는 카드번호
$result3 = $connect->query($query3);  //쿼리실행
$Booker_Card = mysqli_fetch_array($result3);//실행된 쿼리값을 읽음

//  echo $Booker_Card[0];

$query4 = "select ValidTime FROM machine_book WHERE MachineID_id = $Machine_ID LIMIT 1";
$result4 = $connect->query($query4);  //쿼리실행
$ValidTime = mysqli_fetch_array($result4);//실행된 쿼리값을 읽음

$query5 = "insert into machine_book (MachineId_id, UserId_id, ValidTime, EndTime) values ($Machine_ID, $Booker_ID[0], ADDTIME(now(), '00:30:00'), ADDTIME(now(), '00:50:00'))";//해당 세탁기 정보 업뎃

if ($Machine_EndTime[0] == NULL) {
  if($Current_Time > $ValidTime ){
    $connect->query($query5);
    echo 'NoShow_JustUse';
  } else if($Booker_Card[0] == $Current_User){
    $connect->query($query5);
    echo 'Match';
  } else {
    echo 'Mismatch';
  }
} elseif($Machine_EndTime[0] < $Current_Time) {
  $connect->query($query5);
  echo 'NoBooker_JustUse';
} else {
  echo 'StillUsing';
}
?>
