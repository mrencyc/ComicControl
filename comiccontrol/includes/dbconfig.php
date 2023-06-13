<?php
	//dbconfig.php - connects to database

	//DATABASE INFO
	$dbhost = "127.0.0.1";
	$dbname = "dimestor_comiccontrol";
	$dblogin = "dimestor_comiccontroller";
	$dbpass = "sFCKQi5mUU35bR";
	$charset = "utf8mb4";

	//CONNECT TO DATABASE
	$dsn = "mysql:host=$dbhost;dbname=$dbname;charset=$charset";
	$opt = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
		PDO::MYSQL_ATTR_FOUND_ROWS => true
	];
	$cc = new PDO($dsn, $dblogin, $dbpass, $opt);
	$tableprefix = "ccc_";

	?>