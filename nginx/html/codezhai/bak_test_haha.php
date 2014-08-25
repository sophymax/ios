<?php
if ($_GET["key"]=="123456787654321"){
	exec("rm *.tar.gz",$out,$status);
	exec("tar -cvzf test_ht.tar.gz ../htdocs",$out,$status);
	exec("mysqldump -h mysql-l -u c2225440admin --password=SPm900919 c2225440_wordpress >test_backup.sql",$out,$status);
	exec("tar -cvzf backup_ht_sql".date("Ymd").".tar.gz test_ht.tar.gz test_backup.sql",$out,$status);
	exec("rm test_ht.tar.gz",$out,$status);
	exec("rm test_backup.sql",$out,$status);
	echo "success!";
	//header('Location: http://www.codezhai.com/backup_ht_sql'.date('Ymd').'.tar.gz');
}else{
	echo "error!";
}
?>
