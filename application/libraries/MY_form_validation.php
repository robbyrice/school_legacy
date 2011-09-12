<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Adding some specific checks to the form validation class
 *
 * @author Robert Doucette <rice8204@gmail.com>
 * @version 0.2
 */
class MY_Form_validation extends CI_Form_validation {

	private $_CI;

	public function __construct()
	{
		parent::__construct();
		$this->_CI =& get_instance();
	}

	public function alpha_da($str)
	{
		return ( ! preg_match("/^([-a-z0-9_-àâéèêîïôùû])+$/i", $str)) ? FALSE : TRUE;
	}

	/**
	 * Unique
	 *
	 * @param string $val the user input we want to verify
	 * @param string $info the table and column in the database we will use for the lookup
	 * @return boolean
	 * @since 0.1
	 * @version 1.2
	 */
	public function unique($val, $info)
	{
		$this->_CI->form_validation->set_message('unique', '*Cette valeur existe déjà dans la base de données.');
		list($table, $col) = explode('.', $info, 2);

		if($this->_CI->db->get_where($table, array($col => $val), 1)->row())
		{
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * Is the form field empty ?
	 *
	 * @param string $val the value of the input we want to verify
	 * @return boolean
	 * @since 0.2
	 * @version 1.4
	 */
	public function is_empty($val)
	{
		$this->_CI->form_validation->set_message('is_empty', '*Le champ "%s" doit être vide.');

		if($val)
		{
			return FALSE;
		}
		return TRUE;
	}
}

# Fin du fichier MY_form_validation.php
# Emplacement: /application/libraries/MY_form_validation.php