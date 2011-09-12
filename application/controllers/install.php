<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Install extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$date = date_mysql();
		$this->load->library('data', array('user_id'=>1));

		//Creating the tables
		$this->db->trans_start();
			$this->db->query("CREATE TABLE  `user` (
					`user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					`pseudo` varchar(20) NOT NULL,
					`password` char(40) NOT NULL,
					`email` varchar(255) NOT NULL,
					`gender` char(1) NOT NULL DEFAULT 'm',
					`created_by` int(10) unsigned NOT NULL,
					`updated_by` int(10) unsigned NOT NULL,
					`created_at` datetime NOT NULL,
					`updated_at` datetime NOT NULL,
					`current_login` datetime DEFAULT NULL,
					`last_login` datetime DEFAULT NULL,
					PRIMARY KEY (`user_id`),
					UNIQUE KEY `Index_2` (`pseudo`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
			");
			$this->db->query("CREATE TABLE `auteur` (
					`auteur_id` int(11) unsigned NOT NULL auto_increment,
					`nom` varchar(75) NOT NULL,
					`prenom` varchar(75) default NULL,
					`surnom` varchar(75) default NULL,
					`created_by` int(10) unsigned NOT NULL,
					`updated_by` int(10) unsigned NOT NULL,
					`created_at` datetime NOT NULL,
					`updated_at` datetime NOT NULL,
					PRIMARY KEY  (`auteur_id`),
					UNIQUE KEY `nom` (`nom`,`prenom`),
					CONSTRAINT `FK_auteur_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
					CONSTRAINT `FK_auteur_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
			");
			$this->db->query("CREATE TABLE `livre` (
					`livre_id` int(11) unsigned NOT NULL auto_increment,
					`titre` varchar(250) NOT NULL,
					`sous_titre` varchar(250) default NULL,
					`created_by` int(10) unsigned NOT NULL,
					`updated_by` int(10) unsigned NOT NULL,
					`created_at` datetime NOT NULL,
					`updated_at` datetime NOT NULL,
					PRIMARY KEY  (`livre_id`),
					UNIQUE KEY `titre` USING BTREE (`titre`,`sous_titre`),
					CONSTRAINT `FK_livre_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
					CONSTRAINT `FK_livre_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
			");
			$this->db->query("CREATE TABLE `auteur_livre` (
					`auteur_id` int(10) unsigned NOT NULL,
					`livre_id` int(10) unsigned NOT NULL,
					`ordre` smallint(5) unsigned NOT NULL,
					`created_by` int(10) unsigned NOT NULL,
					`updated_by` int(10) unsigned NOT NULL,
					`created_at` datetime NOT NULL,
					`updated_at` datetime NOT NULL,
					PRIMARY KEY  (`auteur_id`,`livre_id`,`ordre`),
					CONSTRAINT `FK_auteur_livre_1` FOREIGN KEY (`auteur_id`) REFERENCES `auteur` (`auteur_id`) ON UPDATE CASCADE,
					CONSTRAINT `FK_auteur_livre_2` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`livre_id`) ON UPDATE CASCADE,
					CONSTRAINT `FK_auteur_livre_3` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
					CONSTRAINT `FK_auteur_livre_4` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;
			");
			$this->db->query("CREATE TABLE `exemplaire` (
					`livre_id` int(10) unsigned NOT NULL,
					`exemplaire` smallint(5) unsigned NOT NULL,
					`volume` smallint(5) unsigned default NULL,
					`pages` smallint(5) unsigned default NULL,
					`created_by` int(10) unsigned NOT NULL,
					`updated_by` int(10) unsigned NOT NULL,
					`created_at` datetime NOT NULL,
					`updated_at` datetime NOT NULL,
					PRIMARY KEY  (`livre_id`,`exemplaire`),
					CONSTRAINT `FK_exemplaire_1` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`livre_id`) ON UPDATE CASCADE,
					CONSTRAINT `FK_exemplaire_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
					CONSTRAINT `FK_exemplaire_3` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;			
			");
			$this->db->query("CREATE TABLE  `role` (
					`role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					`role_name` varchar(45) NOT NULL,
					`description` varchar(45) DEFAULT NULL,
					`created_by` int(10) unsigned NOT NULL,
					`updated_by` int(10) unsigned NOT NULL,
					`created_at` datetime NOT NULL,
					`updated_at` datetime NOT NULL,
					PRIMARY KEY (`role_id`),
					UNIQUE KEY `name_unique` (`role_name`),
					CONSTRAINT `FK_role_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
					CONSTRAINT `FK_role_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
			");
			$this->db->query("CREATE TABLE  `role_user` (
					`user_id` int(10) unsigned NOT NULL,
					`role_id` int(10) unsigned NOT NULL,
					`created_by` int(10) unsigned NOT NULL,
					`updated_by` int(10) unsigned NOT NULL,
					`created_at` datetime NOT NULL,
					`updated_at` datetime NOT NULL,
					PRIMARY KEY (`user_id`,`role_id`) USING BTREE,
					CONSTRAINT `FK_role_user_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
					CONSTRAINT `FK_role_user_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON UPDATE CASCADE,
					CONSTRAINT `FK_role_user_3` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
					CONSTRAINT `FK_role_user_4` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;
			");
			$this->db->query("CREATE TABLE  `cours` (
					`cours_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					`cours_nom` varchar(55) NOT NULL,
					`type` char(2) NOT NULL,
					`created_by` int(10) unsigned NOT NULL,
					`updated_by` int(10) unsigned NOT NULL,
					`created_at` datetime NOT NULL,
					`updated_at` datetime NOT NULL,
					PRIMARY KEY (`cours_id`),
					UNIQUE KEY `Index_2` (`cours_nom`),
					CONSTRAINT `FK_cours_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
					CONSTRAINT `FK_cours_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
			");
			$this->db->query("CREATE TABLE  `cours_date` (
					`cours_id` int(10) unsigned NOT NULL,
					`type` varchar(10) NOT NULL,
					`year` int(4) unsigned NOT NULL,
					`month` int(2) unsigned NOT NULL,
					`day` int(2) unsigned NOT NULL,
					`hour` int(1) unsigned NOT NULL,
					`ordre` smallint(5) unsigned NOT NULL DEFAULT 0,
					`count` int(10) unsigned NOT NULL DEFAULT 0,
					`created_by` int(10) unsigned NOT NULL,
					`updated_by` int(10) unsigned NOT NULL,
					`created_at` datetime NOT NULL,
					`updated_at` datetime NOT NULL,
					PRIMARY KEY (`cours_id`,`type`,`year`,`month`,`day`,`hour`,`ordre`) USING BTREE,
					CONSTRAINT `FK_cours_date_1` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`cours_id`) ON UPDATE CASCADE,
					CONSTRAINT `FK_cours_date_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE,
					CONSTRAINT `FK_cours_date_3` FOREIGN KEY (`updated_by`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;
			");
		$this->db->trans_complete();
		if( ! $this->db->trans_status())exit('There was problem creating the tables.  Please verify the settings');


		//Creating the users and inserting them into the proper table
		$user_data[0] = (object) array(
			'pseudo'		=>	'admin',
			'password'	=>	'password',
			'email'		=>	'rice8204@gmail.com'
		);

		foreach($user_data as $r)
		{
			$this->db->set('pseudo', $r->pseudo);
			$this->db->set('password', $this->encrypt->sha1($r->password));
			$this->db->set('email', $r->email);
			$this->db->set('gender', 'm');
			if( ! $this->db->insert('user', $this->data->prep()))exit('There was a problem adding the user :o(');
		}


		//Creating the roles and inserting them into the proper table
		$role_data[0] = (object) array(
			'name'		=>	'Administrateur'
		);
		$role_data[1] = (object) array(
			'name'		=>	'Administration'
		);
		$role_data[2] = (object) array(
			'name'		=>	'Library'
		);

		foreach($role_data as $r)
		{
			$this->db->set('role_name', $r->name);
			if( ! $this->db->insert('role', $this->data->prep()))exit('There was a problem adding the role :o(');
		}


		//Creating the relationships between the users and their roles
		$role_user[0] = (object) array(
			'user_id'	=>	1,
			'role_id'	=>	1
		);
		$role_user[1] = (object) array(
			'user_id'	=>	1,
			'role_id'	=>	2
		);
		$role_user[2] = (object) array(
			'user_id'	=>	1,
			'role_id'	=>	3
		);

		foreach($role_user as $r)
		{
			$this->db->set('user_id', $r->user_id);
			$this->db->set('role_id', $r->role_id);
			if( ! $this->db->insert('role_user', $this->data->prep()))exit('There was a problem assigning the roles :o(');
		}


		//Creating the initial class name
		$this->db->set('cours_id', 2);
		$this->db->set('cours_nom', 'Pause Café');
		$this->db->set('type', 'y');
		if( ! $this->db->insert('cours', $this->data->prep()))exit('There was a  problem adding the class name :o(');

		echo "<html><head><meta http-equiv='refresh' content='2; URL=".base_url()."' /><title>Success!</title></head><body>The tables have been successfully created and populated.</body></html>";
	}
}

# Fin du fichier install.php
# Emplacement: ./application/controllers/install.php