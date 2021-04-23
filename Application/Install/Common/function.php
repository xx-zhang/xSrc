<?php

	function try_mysql($host,$db,$db_user,$db_pwd){
		$mysql_conf = array(
			'host'    => explode(':',$host)[0], 
			'port'    => explode(':',$host)[1],
			'db'      => $db, 
			'db_user' => $db_user, 
			'db_pwd'  => $db_pwd, 
			);
		
		$pdo = new PDO("mysql:host=" . $mysql_conf['host'] . "; port=". $mysql_conf['port'] . "; dbname=" . $mysql_conf['db'], $mysql_conf['db_user'], $mysql_conf['db_pwd']);
		
		if($pdo){
			$pdo->db = null;
			return true;
		}
		
	}
	
	// 递归删除缓存目录
	function remove_dir($dirname)
	   {
		   $result = false;
		   if (!is_dir($dirname)) {
			   exit(0);
		   }
		   $handle = opendir($dirname);
		   while (($file = readdir($handle)) !== false) {
			   if ($file != '.' && $file != '..') {
				   $dir = $dirname .'/' . $file;
				   is_dir($dir) ? remove_dir($dir) : unlink($dir);
			   }
		   }
		   closedir($handle);
		   $result = rmdir($dirname) ? true : false;
		   return $result;
	}

?>