<?php
	class Operante extends Model{

		static $belongs_to = array(
			array('registro'),
			array('mecanico')
		);

	}