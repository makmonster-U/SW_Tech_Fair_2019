import pymysql
conn = pymysql.connect(host='localhost', user='root', password='abc41641', db='test1')
curs = conn.cursor()

#사용할 쿼리문
query1 = "select EndTime FROM reserve_d_book WHERE MachineId = $Machine_ID ORDER BY id DESC LIMIT 1";//ENDTIME불러오기
query2 = "select UserID FROM reserve_d_book WHERE MachineId = $Machine_ID ORDER BY id DESC LIMIT 1";//해당 세탁기 예약자 id
query3 = "select CardId FROM account_user WHERE id = $Booker_ID[0]"; //예약자 id에 해당하는 카드번호
query4 = "select ValidTime FROM reserve_d_book WHERE MachineId = $Machine_ID ORDER BY id DESC LIMIT 1";
query5 = "insert into reserve_d_book (MachineId, UserID, ValidTime, EndTime) values ($Machine_ID, $Booker_ID[0], ADDTIME(now(), '00:30:00'), ADDTIME(now(), '00:50:00'))";//해당 세탁기 정보 업뎃
query6 = "update account_user set Penalty = Penalty + 1 WHERE id = $Booker_ID[0]";
