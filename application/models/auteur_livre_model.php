<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auteur_livre_model extends CI_Model {

	public $auteurs;
	public $l_id;

	public function __construct()
	{
		parent::__construct();
	}

	public function get_all($term = '')
	{
		$q = $this->db
			->from('livre l')
			->join('auteur_livre al', 'l.livre_id=al.livre_id')
			->join('auteur a', 'al.auteur_id=a.auteur_id')
			->like('l.titre', $term)
			->or_like('a.prenom', $term, 'after')
			->order_by('titre, ordre')
			->limit(10)
			->get();
		$result	=	array();

		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				$i	=	$r->livre_id;

				$result[$i]['title']			=	$r->titre;
				$result[$i]['sous_titre']	=	$r->sous_titre;
				$result[$i]['exemplaire']	=	$this->exemplaire_model->get_max_exemplaire($i);
				$result[$i]['authors'][$r->auteur_id]	=	$r->nom.', '.$r->prenom.' '.$r->surnom;
			}
		}

		return $result;
	}

	public function add()
	{
		$data = array();

		foreach($this->auteurs as $key=>$r)
		{
			if( ! $this->db->order_by('ordre')->get_where('auteur_livre', array('livre_id'=>$this->l_id, 'auteur_id'=>$r->auteur_id))->row())
			{
				$data[$key]	=	array(
					'auteur_id'		=>	$r->auteur_id,
					'livre_id'		=>	$this->l_id,
					'ordre'			=>	$key+1
				);
				$data[$key] = array_merge($data[$key], $this->data->prep());
			}
		}
		if(count($data) > 0)
			$this->db->insert_batch('auteur_livre', $data);
	}
}

/* End of file auteur_livre_model.php */
/* Location: ./application/models/auteur_livre_model.php */