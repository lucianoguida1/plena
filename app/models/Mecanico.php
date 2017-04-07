<?php
	class Mecanico extends Model{

		static $has_many = array(
		 	array('operantes')
		);

	}