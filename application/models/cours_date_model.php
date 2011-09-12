<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Cours_date_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_cell_data($type, $year, $month)
	{
		$cell = array();

		$q = $this->db
			->select("d.hour, d.day, c.type, GROUP_CONCAT(CONCAT(c.cours_nom, IF(c.type = 'c', CONCAT(' ', d.count), '')) ORDER BY d.ordre SEPARATOR ' / ') AS 'name'", FALSE)
			->from('cours c')->join('cours_date d', 'c.cours_id=d.cours_id')
			->where('d.year', $year)->where('d.month', $month)->where("(d.type='$type' OR d.type='all')")
			->group_by('d.hour, d.day')
			->get();

		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				$cell[$r->hour][$r->day] = array('type'=>$r->type, 'name'=>$r->name);
			}
		}

		return $cell;
	}

	public function add($type, $year, $month, $day, $hour, $id, $original_type)
	{

		$data = $this->db
			->select('cours_id, type')
			->from('cours_date')
			->where('year', $year)->where('month', $month)->where('day', $day)->where('hour', $hour)->where("(type='$original_type' OR type='all')")
			->order_by('year, month, day, hour, ordre')->get()->result();
		$i = 0;

		foreach($id as $key=>$id)
		{
			if($id == 'vide')
			{
				$this->db->delete('cours_date', array('type'=>$data[$i]->type, 'year'=>$year, 'month'=>$month, 'day'=>$day, 'hour'=>$hour, 'ordre'=>$i));

				$this->_update_class_count($data[$i]->cours_id, $data[$i]->type, $month, $year, $day);
			}
			elseif(array_key_exists($i, $data))
			{
				$this->db->where('type', $data[$i]->type);
				$this->db->where('year', $year);
				$this->db->where('month', $month);
				$this->db->where('day', $day);
				$this->db->where('hour', $hour);
				$this->db->where('ordre', $i);
				if($id != '')$this->db->set('cours_id', $id);
				$this->db->set('type', $type[$i]);

				if( ! $this->db->update('cours_date', $this->data->prep('', 'update')))return 'There was a problem updating the record in the database.';

				$this->_update_class_count($id, $type[$i], $month, $year, $day);
				$this->_update_class_count($data[$i]->cours_id, $data[$i]->type, $month, $year, $day);
			}
			else
			{
				if($id != '')
				{
					$data = array(
						'cours_id'	=>	$id,
						'type'		=>	$type[$i],
						'year'		=>	$year,
						'month'		=>	$month,
						'day'			=>	$day,
						'hour'		=>	$hour,
						'ordre'		=>	$i
					);
					if( ! $this->db->insert('cours_date', $this->data->prep($data)))return 'There was a problem adding the record to the database.';

					$this->_update_class_count($id, $type[$i], $month, $year, $day);
				}
			}
			$i+=1;
		}
	}

	/**
	 * @param int $year
	 * @param int $month
	 * @param int $day
	 * @return string
	 * @since 0.2
	 * @version 1.0
	 */
	public function delete($year, $month, $day, $hours)
	{
		$total = 0;
		for($i=0, $size=count($hours); $i<$size; $i+=1)
		{
			$total+=array_sum($hours[$i]);
		}

		if($total <= 18)
		{
			$q = $this->db->from('cours_date')->where('year', $year)->where('month', $month)->where('day', $day)->get();

			if($q->num_rows() == 0)return "Il n'y a rien à supprimer.";
			foreach($q->result() as $r)
			{
				if(!$this->db->delete('cours_date', array('cours_id'=>$r->cours_id, 'year'=>$year, 'month'=>$month, 'day'=>$day)))return 'There was a problem deleting the record';

				$this->_update_class_count($r->cours_id, $month, $year);
			}
		}
		else
		{
			foreach($hours as $key=>$value)
			{
				foreach($value as $id)
				{
					if($id == 1)continue;
					$this->db->delete('cours_date', array('cours_id'=>$id, 'year'=>$year, 'month'=>$month, 'day'=>$day, 'hour'=>$key+1));

					$this->_update_class_count($id, $month, $year);
				}
			}
		}

		return 'The record was deleted successfully.';
	}

	/**
	 * @param int $cours_id
	 * @param int $month
	 * @param int $year
	 * @since 0.6
	 * @version 1.0
	 */
	private function _update_class_count($cours_id, $type, $month, $year, $day)
	{
		$sem_start = config_item('sem_start');
		$yearb = ($month <= 2) ? $year-1 : $year+1;

		if(($month<7 AND $month>2) OR ($month==2 AND $day>=$sem_start)) //are we adding a class for the second semester ?
		{
			$first	= 'year='.$year;
			$second	= '(month<7 AND month>2)';
			$third	= '(month=2 AND day>='.$sem_start.')';
			
		}
		else //we must be adding a class for the first semester
		{
			$first	= '(year='.$year.' OR year='.$yearb.')';
			$second	= '((month>=9 OR month<2)';
			$third	= '(month=2 AND day<'.$sem_start.'))';
		}

		$q_string = '('.$first.' AND '.$second.' OR '.$third.')';

		$q = $this->db
			->from('cours_date')
			->where('cours_id', $cours_id)->where('type', $type)
			->where($q_string)
			->order_by('year, month, day, hour')
			->get();
		$data = array();
		$i = 1;

		if($q->num_rows() > 0)
		{
			foreach($q->result_array() as $r)
			{
				$data[] = array('count'=>$i) + $r;
				$i+=1;
			}
			$this->db->where('cours_id', $cours_id)->where('type', $type)->where($q_string)->delete('cours_date');
			$this->db->insert_batch('cours_date', $data);
		}
	}
}

# Fin du fichier cours_date_model.php
# Emplacement: ./application/models/cours_date_model.php