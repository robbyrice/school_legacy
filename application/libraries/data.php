<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data {

	private $_date;
	private $_u_id;

	public function __construct($params)
	{
		extract($params);
		$this->_date	=	date_mysql(); //called from the MY_date_helper.php file
		$this->_u_id	=	$u_id;
	}

	public function prep($data = array(), $type = 'insert')
	{
		switch($type)
		{
			case 'insert':
				$data['created_by']	=	$this->_u_id;
				$data['created_at']	=	$this->_date;break;
		}
		$data['updated_by']	=	$this->_u_id;
		$data['updated_at']	=	$this->_date;

		return $data;
	}
}

# Fin du fichier data.php
# Emplacement: /application/libraries/data.php