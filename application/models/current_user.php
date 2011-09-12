<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This class is pretty self-explanitory.  It contains all the methods and properties
 * for the currently logged in user.
 * 
 * This class is auto-loaded.
 *
 * @author Robert Doucette
 * @version 1.3
*/
class Current_user extends CI_Model {
	/**
	 * @since 1.0
	 * @version 0.1
	*/
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @return boolean
	 * @since 1.0
	 * @version 0.2
	*/
	public function is_logged_in()
	{
		if($this->session->userdata('user_id'))
		{
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * @param string $role
	 * @return boolean
	 * @since 1.0
	 * @version 0.3
	*/
	public function has_role($role)
	{
		if($role !== '') //the user is trying to access a protected page, so we check to see if they have permission
		{
			$q = $this->db
				->select('role_name')
				->from('user')
				->join('role_user', 'user.user_id=role_user.user_id')->join('role', 'role_user.role_id=role.role_id')
				->where('user.user_id', $this->session->userdata('user_id'))
				->where('role.role_name', $role)
				->limit(1)
				->get();

			if( ! $q->result())
			{
				return FALSE; //the user is not allowed to see the page they requested
			}
		}

		return TRUE; // the user has the proper credentials or the page is not protected
	}

	/**
	 * @return boolean/object false or an object of the currently logged in user's information
	 * @since 1.1
	 * @todo possibly have this return all the info on a user (roles, class names, etc.)
	 * @version 0.6
	*/
	public function info()
	{
		if($this->is_logged_in())
		{
			$u = $this->db
				->select('user_id, pseudo, email, gender')
				->from('user')
				->where('user.user_id', $this->session->userdata('user_id'))
				->limit(1)->get()->row();

			$r = $this->db
				->select('role.role_name')
				->from('role')
				->join('role_user', 'role.role_id = role_user.role_id')
				->join('user', 'role_user.user_id = user.user_id')
				->where('user.user_id', $u->user_id)
				->order_by('role.role_name')->get();

			foreach($r->result() as $row)
			{
				$names[] = $row->role_name;
			}

			$info = array(
				'user_id'	=>	$u->user_id,
				'pseudo'		=>	$u->pseudo,
				'email'		=>	$u->email,
				'type'		=>	$u->gender,
				'num_roles'	=>	$this->db->from('role_user')->where('user_id', $u->user_id)->count_all_results(),
				'r_names'	=>	$names
			);
			return (object) $info;
		}

		return FALSE;
	}

	/**
	 * @since 1.2
	 * @version 0.1
	*/
	public function logout()
	{
		$this->session->sess_destroy();
	}
}


# Fin du fichier current_user.php
# Emplacement: ./application/models/current_user.php