<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Model
 *
 * This class is pretty self-explanitory.  It contains all the methods and logic
 * needed to manipulate the database table with the information for the classes.
 *
 * @author Robert Doucette <rice8204@gmail.com>
 * @version 0.5
 */
Class Cours_model extends CI_Model {

	/**
	 * __construct
	 *
	 * @since 0.1
	 * @version 0.3
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Does exactly what the name suggests.  This method returns an array
	 * of the names of the classes in the "Cours" table.  The classes are
	 * seperated according to their type.
	 *
	 * @return array an associative array of the class names
	 * @since 0.1
	 * @version 0.7
	 */
	public function get_classes()
	{
		$new_array = array();
		$q = $this->db->select('cours_id, cours_nom, type')->from('cours')->order_by('type, cours_nom')->get();

		$new_array['vide']	= 'vide';
		$new_array[2]			= 'Pause Café';
		foreach($q->result() as $r)
		{
			switch($r->type)
			{
				case 'a':$new_array[$r->cours_id] = $r->cours_nom;continue 2;
				case 'b':$type='Chapelle';break;
				case 'c':$type='Cours';break;
				case 's':$type='Semaine';break;
				case 'v':$type='Autres';break;
				default:continue 2;
			}
			$new_array[$type][$r->cours_id] = $r->cours_nom;
		}
		return $new_array;
	}

	/**
	 * Add a new class name.
	 *
	 * @param string $name name of the class we want to add
	 * @param string $type type of the class we want to add
	 * @return string a message stating whether the operation was successful or not
	 * @since 0.1
	 * @version 1.2
	 */
	public function add($name, $type)
	{
		switch($type)
		{
			case 'v':	$var	= 'upper';break;
			default:		$var	= 'class';
		}

		$name	=	verify_case($name, $var);

		$data	= array(
			'cours_nom'	=>	$name,
			'type'		=>	$type
		);

		if( ! $this->db->insert('cours', $this->data->prep($data)))return 'Il y a eu un problème pour ajouter le nom à la base de données';

		return 'Le nom du cours a été bien ajouté.';
	}

	/**
	 * Modify an existing class name
	 *
	 * @param string $name the new name for the class we want to update
	 * @param string $type the type of the class we want to update
	 * @param int $old_id the id number of the class we want to update
	 * @return string a message stating whether the operation was successful or not
	 * @since 0.1
	 * @version 1.0
	 */
	public function update($name, $type, $old_id)
	{
		if($old_id === '2')return 'Vous ne pouvez pas mettre à jour ce cours.';
		if($name !== '')
		{
			switch($type)
			{
				case 'v': $var = 'upper';break;
				default : $var = 'class';
			}
			$this->db->set('cours_nom', verify_case($name, $var));
		}

		$this->db->set('type', $type);

		if( ! $this->db->where('cours_id', $old_id)->update('cours', $this->data->prep('', 'update')))return 'Il y a eu un problème :o(';

		return 'Le nom a été bien mis à jour.';
	}

	/**
	 * The checks are taken care of in the controller
	 *
	 * @param int $old_id the id number of the class we want to delete
	 * @return string a message stating whether the operation was successful or not
	 * @since 0.1
	 * @todo add a confirmation so that class names are not accidently deleted
	 * @version 0.4
	 */
	public function delete($old_id)
	{
		if($old_id === '2')return 'Vous ne pouvez pas supprimer ce cours.';
		$this->db->delete('cours', array('cours_id' => $old_id));
		return 'Le nom a été bien supprimé.';
	}

	/**
	 * validating the user input so we keep database integrity
	 *
	 * @param string $type the type of operation we want to perfom
	 * @return array
	 * @since 0.1
	 * @version 1.3
	 */
	public function submit_validate($type)
	{
		$this->form_validation->set_message('required', '*Obligatoire');

		$old_id_rule	= 'required';
		$new_name_rule	= 'alpha-dash';
		$type_rule		= 'required';

		switch($type)
		{
			case 'add':
				$old_id_rule	= 'is_empty';
				$new_name_rule	.= '|required|unique[Cours.cours_nom]';
				break;
			case 'del':
				$new_name_rule	= 'is_empty';
				$type_rule		= 'is_empty';
		}
		$this->form_validation->set_rules('old_id', 'Nom original', $old_id_rule);
		$this->form_validation->set_rules('new-name', 'Nouveau Nom', $new_name_rule);
		$this->form_validation->set_rules('type', 'Type', $type_rule);
		$this->form_validation->set_rules('mod', 'Type de manipulation', 'required|trim');

		return $this->form_validation->run();
	}
}

# Fin du fichier cours_model.php
# Emplacement: ./application/models/cours_model.php