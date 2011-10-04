<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Bib extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$message = ' ';
		$this->load->model('livre_model');
		$this->load->model('auteur_livre_model');
		if($this->input->post('action'))
		{
			extract($this->input->post());
			$this->load->model('auteur_model');
			$this->load->library('data', array('u_id'=>$this->current_user->info()->user_id));

			$this->form_validation->set_rules('titre', 'Titre', 'required');
			$this->form_validation->set_rules('prenom[]', 'Prenom', 'required');

			if($this->form_validation->run() !== FALSE)
			{
				$this->db->trans_start();
					$this->livre_model->livre_id		=	$livre_id;
					$this->livre_model->titre			=	verify_case($titre, 'sentence');
					$this->livre_model->sous_titre	=	verify_case($sous_titre, 'sentence');

					$this->auteur_model->prenom		=	$prenom;
					$this->auteur_model->surnom		=	$surnom;
					$this->auteur_model->nom			=	$nom;
					$auteurs									=	$this->auteur_model->add();

					//this model does not need to be loaded because it is loaded by the livre_model
					$this->auteur_livre_model->auteurs	=	$auteurs;
					$this->auteur_livre_model->l_id		=	$this->livre_model->add();
					$this->auteur_livre_model->add();
				$this->db->trans_complete();

				$message	=	($this->db->trans_status() === FALSE) ? 'Il y a eu un problème :o(' : 'Livre ajouté avec succès !';
			}
		}
		$data = array(
			'data'		=>	$this->auteur_livre_model->get_all(),
			'message'	=>	$message,
			'title'		=>	'Bibliothèque',
			'view'		=>	'bib/main'
		);

		$this->load->view('templates/main', $data);
	}

	public function rechercher()
	{
		
	}

	public function auteurs()
	{
		echo '[';
		foreach($this->db->like('prenom', $this->input->get('term'), 'after')->order_by('nom')->get('auteur')->result() as $key=>$r)
		{
			echo ($key === 0) ? '{' : ',{';
			echo '"label":"'.$r->prenom.' '.$r->surnom.' '.$r->nom.'","value":"'.$r->prenom.'","surnom":"'.$r->surnom.'","nom":"'.$r->nom.'"';
			echo'}';
		}
		echo ']';
	}

	public function livres()
	{
		echo '[';
		foreach($this->db->select('livre_id, titre, sous_titre')->like('titre', $this->input->get('term'), 'after')->order_by('titre')->get('livre')->result() as $key=>$r)
		{
			echo ($key === 0) ? '{' : ',{';
			echo '"label":"'.$r->titre.' '.$r->sous_titre.'","value":"'.$r->titre.'","sous_titre":"'.$r->sous_titre.'","id":"'.$r->livre_id.'"';
			echo '}';
		}
		echo ']';
	}
}

 /* End of file bib.php */
 /* Location: ./application/controllers/bib.php */