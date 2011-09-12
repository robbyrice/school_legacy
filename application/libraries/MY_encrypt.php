<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Encrypt extends CI_Encrypt {

	private $_CI;

	public function __construct()
	{
		parent::__construct();
		$this->_CI =& get_instance();
	}

	public function sha1($str)
	{
		$str = 'Limay===Fra'.$str.'nce==86204';

		if ( ! function_exists('sha1'))
		{
			if ( ! function_exists('mhash'))
			{
				require_once(BASEPATH.'libraries/Sha1'.EXT);
				$SH = new CI_SHA;
				return $SH->generate($str);
			}
			else
			{
				return bin2hex(mhash(MHASH_SHA1, $str));
			}
		}
		else
		{
			return sha1($str);
		}
	}
}

# Fin du fichier MY_encrypt.php
# Emplacement: /application/libraries/MY_encrypt.php