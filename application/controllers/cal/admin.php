<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	private $_message;
	private $_mod;

	public function __construct()
	{
		parent::__construct();
		if( ! $this->current_user->is_logged_in()) exit();
		$this->load->library('data', array('u_id' => $this->current_user->info()->user_id));
	}

	public function index()
	{
		
	}

	public function noms()
	{
		$this->load->model('cours_model');
		//$this->load->model('cours_date_model');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');

		$this->_message	=	'';
		$this->_mod			=	$this->input->post('mod');

		if( ! $this->_mod)$this->_mod = 'add'; //making sure that when the page is loaded for the first time the correct option is displayed

		$new_name	=	trim($this->input->post('new-name'));
		$old_id		=	$this->input->post('old_id');
		$type			=	$this->input->post('type');

		if($this->input->post('submit_name'))
		{
			if($this->cours_model->submit_validate($this->_mod) !== FALSE)
			{
				switch($this->_mod)
				{
					case 'add':$this->_message	=	$this->cours_model->add($new_name, $type);break;
					case 'mod':$this->_message	=	$this->cours_model->update($new_name, $type, $old_id);break;
					case 'del':$this->_message	=	$this->cours_model->delete($old_id);
				}

				$this->_mod	=	'add';
				$new_name	=	'';
				$old_id		=	'';
				$type			=	'';
			}
		}

		$data = array(
			'data'		=>	$this->cours_model->get_classes(),
			'message'	=>	$this->_message,
			'mod'			=>	$this->_mod,
			'new_name'	=>	$new_name,
			'old_id'		=>	$old_id,
			'required'	=>	'Administration',
			'title'		=>	'Administration',
			'type'		=>	$type,
			'view'		=>	'cal/admin/names'
		);

		$this->load->view('templates/main', $data);
	}

	public function jours($original_type)
	{
		$this->load->model('cours_date_model');
		$info		= explode('_', $this->input->post('info'));
		$type		= array($info[0], $info[1]);
		$year 	= $info[2];
		$month	= $info[3];
		$day		= $info[4];
		$hour		= $info[5];
		$id		= array($this->input->post('cours1', ''), $this->input->post('cours2', ''));

		$this->cours_date_model->add($type, $year, $month, $day, $hour, $id, $original_type);
	}

	public function hour()
	{
		echo '[';
		foreach($this->db->select('cours_id, cours_nom')->like('cours_nom', $this->input->get('term'), 'after')->order_by('cours_nom')->get('cours')->result() as $key=>$r)
		{
			echo ($key === 0) ? '{' : ',{';
			echo '"label":"'.$r->cours_nom.'","value":"'.$r->cours_nom.'","id":"'.$r->cours_id.'"';
			echo '}';
		}
		echo ',{"label":"vide","value":"vide","id":"vide"}]';
	}

	public function box($type, $day)
	{
		$info		= explode('_', $day);
		$result	= $this->db->select('c.cours_id, c.cours_nom, d.type')->from('cours c')->join('cours_date d', 'c.cours_id=d.cours_id')
						->where('year', $info[0])->where('month', $info[1])->where('day', $info[2])->where('hour', $info[3])->where("(d.type = '$type' OR d.type='all')")
						->order_by('d.hour, d.ordre')->get()->result();
		$name		= '';
		$id		= '';
		$hour		= $info[3];

		if(array_key_exists(0, $result))
		{
			$name = $result[0]->cours_nom;
			$id	= $result[0]->cours_id;
			$type	= $result[0]->type;
		}

		if($hour < 4)
		{
			$output = $hour.($hour==1?'ère':'ème').' heure';
		}
		elseif($hour == 4)
		{
			$output = 'Chapelle';
		}
		elseif($hour == 5)
		{
			$output = 'pause';
		}
		elseif($hour > 5)
		{
			$output = ($hour-2).'ème heure';
		}

		echo '<p>Ajouter ou modifier les données pour la <strong>'.$output.' </strong> du <strong>'.utf8_encode(strftime('%A %d %B', mktime(0, 0, 0, $info[1], $info[2], $info[0]))).'</strong><br /><label for="">Cours 1 : </label><input value="'.$name.'" /><input type="hidden" value="'.$id.'" /><select>';
		echo dropdown_options(array('all'=>'Tout', 'triennal'=>'Triennal', 'annuel'=>'Annuel'), 2, $type);
		echo '</select><br /><label for="">Cours 2 : </label><input /><input type="hidden" /><select>';
		echo dropdown_options(array('all'=>'Tout', 'triennal'=>'Triennal', 'annuel'=>'Annuel'), 2, $type);
		echo '</select><button>Action</button><button id="cancel">Annuler</button></p>';
	}
}

# Fin du fichier admin.php
# Emplacement: ./application/controllers/cal/admin.php