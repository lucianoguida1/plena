<?php

	/**
	 * Constates para ambiente local
	 */
	if($_SERVER['SERVER_NAME'] === 'localhost'){
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