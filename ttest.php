<?php
//php info
$mysql_hostname = 'localhost';
$mysql_username = 'root';
$mysql_password = 'abc41641';
$mysql_database = 'test1';

//DB연결
$connect = new mysqli($mysql_hostname, $mysql_username, $mysql_password, $mysql_database);
//DB연결 확인
if($connect->connect_errno){
echo '[연결실패] : '.$connect->connect_error.'<br>';
} else {
echo 'sucess';
}


$User_Card_Num = $_GET['code'];         //찍힌 사용자 ID
$Machine_ID = $_GET['Machine_ID'];   //찍은 세탁기 ID
echo $Machine_ID;

$query = "select Card_Num FROM Machine_Table WHERE ID = $Machine_ID";//해당 세탁기 예약자 정보
$result = $connect->query($query);  //쿼리실행
$Booker_ID = mysqli_fetch_array($result);//실행된 쿼리값을 읽음
//echo $Booker_ID[0];


if ($Booker_ID[0] == $User_Card_Num) {//찍은 카드가 예약자 정보와 같은지
  $query2 = "update Machine_Table set Using_Stat = 1, User_ID = '$User_Card_Num', Start_Time = NOW() WHERE ID = $Machine_ID"; //해당 세탁기 정보 업뎃
  $connect->query($query2);
  echo "match";
}
else {
  echo "false";

}








/*

if ($User_penalty = ) {
  // code...
}
 }

 do {  //맨 마지막 레코드를 읽는 쿼리
$query3 = "select * from temp order by no desc limit 1;";
  $result = $connect->query($query3);  //쿼리실행
  $row = mysqli_fetch_object($result); //실행된 쿼리값을 읽음
 } while($row->humidity == 0);

 echo date("Y-m-d H:i:s") . "<br />\n";  //날짜와 시간 표시
 echo "$row->no  ";
 echo "$row->humidity  ";
 echo "$row->temperature";
 if($row->temperature>27) { //온도가 27도 넘으면 경보음 울림(로컬 컴퓨터 하단경로에 MP3파일 넣을 것)
echo '<embed src="c:\test.mp3" loop=-1> </embed>';
 }

//하단 자바스크립트: 웹페이지 자동 REFRESH기능
*/
 ?>
