<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auteur_model extends CI_Model {

	public $prenom;
	public $surnom;
	public $nom;

	public function __construct()
	{
		parent::__construct();
	}

	public function get_all()
	{
		return $this->db->order_by('nom')->get('auteur')->result();
	}

	public function get_single($id)
	{
		
	}

	public function add()
	{
		foreach($this->prenom as $key=>$r)
		{
			$prenom	= verify_case($r);
			$surnom	= verify_case($this->surnom[$key]);
			$nom		= verify_case($this->nom[$key]);
			$q = $this->db->get_where('auteur', array('prenom'=>$prenom, 'surnom'=>$surnom, 'nom'=>$nom))->row();

			if($q)
			{
				$a_id[] = $q;
			}
			else
			{
				$this->db->set('prenom', $prenom);
				$this->db->set('surnom', $surnom);
				$this->db->set('nom', $nom);
				$this->db->insert('auteur', $this->data->prep());
				$a_id[] = $this->db->get_where('auteur', array('auteur_id'=>$this->db->insert_id()))->row();
			}
		}

		return $a_id;
	}

	public function update()
	{
		$this->_row	=	$this->db->get_where('auteur', array('auteur_id'=>$this->a_id))->row();

		if($this->prenom === '' AND $this->nom === '')
			return 'Please change something';

		$this->_prep();

		if($this->_submit_validate('Modifier') !== FALSE)
		{
			$this->db->where('auteur_id', $this->a_id);
			if( ! $this->db->update('auteur', $this->_data)) return 'Nous avons rencontré un problème :o(';

			return 'Auteur mis à jour avec succès !';
		}
	}

	public function delete()
	{
		if($this->_submit_validate('Supprimer') !== FALSE)
		{
			$this->db->where('auteur_id', $this->a_id);
			if($this->db->delete(array('auteur_livre', 'auteur')) !== NULL) return 'Nous avons rencontré un problème :o(';

			return 'Auteur supprimé avec succès !';
		}
	}

	private function _prep()
	{
		if($this->prenom === '' AND $this->_row)
			$this->prenom	= $this->_row->prenom;
		if($this->nom === '' AND $this->_row)
			$this->nom	=	$this->_row->nom;

		$this->_data	=	array(
			'nom'				=> verify_case($this->nom),
			'prenom'			=> verify_case($this->prenom),
			'updated_at'	=> date_mysql()
		);
	}

	private function _submit_validate($type='Ajouter')
	{
		$id_rules		=	'required';
		$prenom_rules	=	'alpha_dash';
		$nom_rules		=	'alpha_dash';

		switch($type)
		{
			case 'Ajouter':
				$id_rules	=	'is_empty';
				$nom_rules	.=	'|required';
				break;
		}

		$this->form_validation->set_rules('auteur_id', 'Choix', $id_rules);
		$this->form_validation->set_rules('prenom', 'Prenom', $prenom_rules);
		$this->form_validation->set_rules('nom', 'Nom', $nom_rules);
		return $this->form_validation->run();
	}
}

/* End of file auteur_model.php */
/* Location: ./application/models/auteur_model.php */