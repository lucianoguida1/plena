<?php
	class Setor extends Model{
		static $has_many = array(
		 	array('equipamentos')
		);
	}