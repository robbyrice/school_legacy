<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Livre_model extends CI_Model {

	public $livre_id;
	public $titre;
	public $sous_titre;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('exemplaire_model');
	}

	public function get_all()
	{
		
	}

	public function add()
	{
		if($this->livre_id === '')
		{
			$this->db->set('titre', $this->titre);
			$this->db->set('sous_titre', $this->sous_titre);
			$this->db->insert('livre', $this->data->prep());

			$this->livre_id	=	$this->db->insert_id();
		}

		$num = $this->exemplaire_model->get_max_exemplaire($this->livre_id);
		$this->exemplaire_model->l_id			=	$this->livre_id;
		$this->exemplaire_model->exemp_id	=	($num >= 1) ? $num+1 : 1;
		$this->exemplaire_model->add();

		return $this->livre_id;
	}

	public function update()
	{
		
	}

	public function delete()
	{
		
	}
}

/* End of file livre_model.php */
/* Location: ./application/models/livre_model.php */