<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Afficher extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index($type='triennal', $name=NULL, $year=NULL)
	{
		$this->load->library('calendrier');
		$this->load->model('cours_date_model');
		$name = ($name)?urldecode($name):utf8_encode(strftime('%B'));
		$year = ($year)?$year:strftime('%Y');

		$month_info	= get_month_info($name, $year);
		$month_num	= $month_info->month;
		$year_num	= $month_info->year;

		$data = array(
			'cell_data'		=>	array(
				$this->cours_date_model->get_cell_data($type, $year_num->before, $month_num->before),
				$this->cours_date_model->get_cell_data($type, $year_num->cur, $month_num->cur),
				$this->cours_date_model->get_cell_data($type, $year_num->after, $month_num->after)
			),
			'month_info'	=>	$month_info,
			'title'			=>	ucfirst($type).' - '.ucfirst($name).' '.$year,
			'type'			=>	$type,
			'view'			=>	'cal/cal'
		);

		$this->load->view('templates/main', $data);
	}
}

# Fin du fichier afficher.php
# Emplacement: ./application/controllers/cal/afficher.php