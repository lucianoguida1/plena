<?php
	class Equipamento extends Model{

		static $has_many = array(
		 	array('registros')
		);

	}