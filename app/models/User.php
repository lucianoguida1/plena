<?php
	class User extends Model{

		static $has_many = array(
		 	array('registros')
		);

	}