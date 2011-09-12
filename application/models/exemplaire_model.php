<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exemplaire_model extends CI_Model {

	public $l_id;
	public $exemp_id;

	public function __construct()
	{
		parent::__construct();
	}

	public function get_max_exemplaire($id)
	{
		return $this->db->select_max('exemplaire')->get_where('exemplaire', array('livre_id'=>$id))->row()->exemplaire;
	}

	public function add()
	{		
		if($this->db->get_where('exemplaire', array('livre_id'=>$this->l_id, 'exemplaire'=>$this->exemp_id))->row())
			return FALSE;

		$this->db->set('livre_id', $this->l_id);
		$this->db->set('exemplaire', $this->exemp_id);
		$this->db->insert('exemplaire', $this->data->prep());

		return TRUE;
	}

	public function update()
	{
		
	}

	public function delete()
	{
		
	}
}

/* End of file exemplaire_model.php */
/* Location: ./application/models/exemplaire_model.php */