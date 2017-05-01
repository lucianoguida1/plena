<?php

	/**
	 * Constates para ambiente local
	 */
	if($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '192.168.0.101'){
		$db_config=array(
			'HOST'=>'localhost',
			'USER'=>'root',
			'PASS'=>'',
			'DBNAME'=>'plena'
		);
	}
	/**
	 * Constantes para ambiente remoto
	 */
	else{
		$db_config=array(
			'HOST'=>'site.com.br',
			'USER'=>'user',
			'PASS'=>'pass',
			'DBNAME'=>'plena'
		);
	}
	//Declaração das constantes
	foreach($db_config as $key => $value)
		define($key,$value);