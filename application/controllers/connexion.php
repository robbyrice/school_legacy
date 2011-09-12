<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Robert Doucette
 * @version 1.4
*/
class Connexion extends CI_Controller {
	/**
	 * @since 1.0
	 * @version 0.5
	*/
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @since 1.0
	 * @version 0.9
	*/
	public function index()
	{
		if($this->current_user->info())redirect('/'); //there is no reason for a logged in user to see this page
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');

		if( ! isset($_SERVER['HTTP_REFERER']) OR $_SERVER['HTTP_REFERER'] === base_url().'connexion')
		{
			$goto = $this->input->post('goto');
		}else
		{
			$goto = $_SERVER['HTTP_REFERER'];
		}

		if($this->input->post('submit'))
		{
			if($this->_submit_validate() !== FALSE)
			{
				redirect($goto);
			}
		}
		$data = array(
			'goto'		=>	$goto,
			'title'		=>	'Connexion',
			'view'		=>	'connexion'
		);

		$this->load->view('templates/main', $data);
	}

	/**
	 * @since 1.2
	 * @version 0.1
	*/
	public function logout()
	{
		$this->current_user->logout();
		redirect($_SERVER['HTTP_REFERER']);
	}

	/**
	 * @return boolean
	 * @since 1.1
	 * @version 0.2
	*/
	private function _submit_validate()
	{
		$this->form_validation->set_rules('pseudo', 'Pseudo', 'required|callback_authenticate');
		$this->form_validation->set_rules('password', 'Mot de passe', 'required');

		$this->form_validation->set_message('required', 'Le champ "%s" est obligatoire');
		$this->form_validation->set_message('authenticate', 'Mauvaise combinaison, veuillez essayer de nouveau.');

		return $this->form_validation->run();
	}

	/**
	 * Nothing needs to be supplied to this function because everything is taken
	 * care of internally.  This function authenticates the input and starts a
	 * session for the user if the credentials supplied are correct.
	 *
	 * @return boolean
	 * @since 1.1
	 * @version 0.2
	*/
	public function authenticate()
	{
		$pseudo		=	trim($this->input->post('pseudo'));
		$password	=	trim($this->input->post('password'));
		$u = $this->db->select('user_id, password, current_login')->from('user')->where('pseudo', $pseudo)->get()->row();

		if($u)
		{
			if($u->password === $this->encrypt->sha1($password))
			{
				$this->session->set_userdata('user_id', $u->user_id);
				$this->db
					->where('user_id', $u->user_id)
					->update('user', array('current_login'=>date_mysql(), 'last_login'=>$u->current_login));

				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}
}

# Fin du fichier connexion.php
# Emplacement: /application/controllers/connexion.php