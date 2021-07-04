REM データベースを初期化するバッチ。
REM データベースの削除も行うため、使用するには注意が必要。
REM データベースの削除、作成、テーブルの作成、データ投入を行う。

mysql -u root -ppassword < ./sql/DropDatabase.sql
mysql -u root -ppassword < ./sql/CreateDatabase.sql
mysql -u root -ppassword project < ./sql/CreateTable.sql
mysql -u root -ppassword project < ./sql/InsertUser.sql
mysql -u root -ppassword project < ./sql/InsertJobChange.sql
mysql -u root -ppassword project < ./sql/InsertCareer.sql
mysql -u root -ppassword project < ./sql/InsertBook.sql
mysql -u root -ppassword project < ./sql/InsertAdmin.sql