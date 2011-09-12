<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Robert Doucette
 * @version 1.0
*/
class User_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function add($pseudo, $password, $email, $gender='m')
	{
		$this->db->set('pseudo', $pseudo);
		$this->db->set('password', $this->encrypt->sha1($password));
		$this->db->set('email', $email);
		$this->db->set('gender', $gender);
		if( ! $this->db->insert('user', $this->data->prep())) return FALSE;

		return TRUE;
	}
}


# Fin du fichier user_model.php
# Emplacement: /application/models/user_model.php