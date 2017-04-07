<?php
	class Registro extends Model{

		/**
		 * Configuração para a associação entre tabelas
		 * @var array
		 */
		static $belongs_to = array(
			array('user'),
			array('equipamento')
		);

		/**
		 * Configuração para a associação entre tabelas
		 * @var array
		 */
		static $has_many = array(
		 	array('pecas'),
		 	array('operantes'),
		 	array('users', 'through' => 'payments')
		);

	}