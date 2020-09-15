<?php	
	function getDbh(){	
		$servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "healthcare_db";
        $dbh = new mysqli($servername, $username, $password, $dbname);
        $dbh->set_charset("utf8");
		return $dbh;
	}

	function exec_query ($sql, $multi = false, $database = null){
		$dbh = $database;
		if (is_null ($database)){ $dbh = getDbh(); }
		if ($multi == true){ $dbh->multi_query ($sql); }
		else { $dbh->query ($sql); }
		if (is_null ($database)){ $dbh->close(); }
	}
?>