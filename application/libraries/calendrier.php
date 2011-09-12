<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Robert Doucette
 * @version 1.8
 */
Class Calendrier {
	public function __construct()
	{

	}

	/**
	 *
	 * @param obj $month_num
	 * @param array $cell_data a mulit-dimensional array
	 * @param int $tab_num how much to indent the table (set to 1 by default)
	 * @return string the output for the calendar as html
	 * @since 1.0
	 * @version 1.9
	 */
	public function generate($month_info, $cell_data, $tab_num=1)
	{
		$day_names = array(
			'',
			'lundi',
			'mardi',
			'mercredi',
			'jeudi',
			'vendredi'
		);
		$time = array(
			'',
			'7h30 - 8h15',
			'8h20 - 9h05',
			'9h10 - 9h55',
			'10h00 - 10h30',
			'10h30 - 10h50',
			'10h55 - 11h40',
			'11h45 - 12h30',
			'14h30 - 15h15',
			'15h20 - 16h05',
			'16h10 - 16h55'
		);

		$days_in_month = $month_info->days_in_month;
		$day = $month_info->day;
		$month_num = $month_info->month;
		$year_num = $month_info->year;
		$month_name = $month_info->name;

		$day_num = $day->cur;
		$day_num_before = $day->before;
		$day_num_after = $day->after;
		$real_num = strftime('%m');
		$real_year = strftime('%Y');
		$today = strftime('%d');

		for($i = 1, $tab = "\n", $temp = ''; $i <= $tab_num; $i+=1)
		{
			$tab .= "\t";
			$temp .= "\t";
		}

		$out = $temp.'<table cellspacing="0">';
		$out .= $tab."\t".'<thead>';
		$out .= $tab."\t\t".'<tr>';

		foreach($day_names as $value)
		{
			$out .= $tab."\t\t\t".'<th>'.$value.'</th>';
		}

		$out .= $tab."\t\t".'</tr>';
		$out .= $tab."\t".'</thead>';
		$out .= $tab."\t".'<tbody>';

		$temp_before = $day_num_before;

		while($day_num <= $days_in_month)
		{

			foreach($time as $key=>$value)
			{
				$highlight = '';
				$id = '';
				$out .= $tab."\t\t".'<tr>';
				$out .= $tab."\t\t\t".'<td class="'.($key==0?'d':'time').'">'.$value.'</td>';
				for($i=0, $temp=$day_num-5, $before=$temp_before, $after=1; $i<5; $i+=1)
				{
					if($key == 0)
					{
						if($day_num <= 0)
						{
							$display = $day_num_before;
							$day_num_before+=1;
						}
						elseif($day_num <= $days_in_month)
						{
							$display = $day_num;
						}
						else
						{
							$display = $day_num_after;
							$day_num_after+=1;
						}
						$day_num+=1;
						$type = 'd';
					}
					else
					{
						$display	= '';
						$type		= 'cours';
						if($temp == $today AND $real_num == $month_num->cur AND $real_year == $year_num->cur)
						{
							$highlight = ' today';
						}
						else
						{
							$highlight = '';
						}
						if($temp <= 0)
						{
							if($before == $today AND $real_num == $month_num->before)
							{
								$highlight = ' today';
							}
							if(array_key_exists($key, $cell_data[0]))
							{
								if(array_key_exists($before, $cell_data[0][$key]))
								{
									$piece_1 = $cell_data[0][$key][$before]['type'];
									$name = $cell_data[0][$key][$before]['name'];
									switch($piece_1)
									{
										case 'b': $type.=' b'; $name='Chapelle : '.$name;break;
										case 's': $type.=' s';break;
										case 'v': $type.=' v';break;
										case 'y': $type.=' b';break;
									}
									$display = $name;
								}
							}
							$id = $year_num->before.'_'.$month_num->before.'_'.$before.'_'.$key;
						}
						elseif($temp <= $days_in_month)
						{
							if(array_key_exists($key, $cell_data[1]))
							{
								if(array_key_exists($temp, $cell_data[1][$key]))
								{
									$piece_1 = $cell_data[1][$key][$temp]['type'];
									$name = $cell_data[1][$key][$temp]['name'];
									switch($piece_1)
									{
										case 'b': $type.=' b'; $name='Chapelle : '.$name;break;
										case 's': $type.=' s';break;
										case 'v': $type.=' v';break;
										case 'y': $type.=' b';break;
										default:
										if((($month_num->cur < $real_num AND $year_num->cur == $real_year) OR $year_num->cur < $real_year) OR ($temp < $today AND $real_num == $month_num->cur) OR ($real_num == $month_num->cur AND $temp == $today AND (strftime('%H') > 12 OR (strftime('%H') == 12 AND strftime('%M') > 30))))
										{
											$type .= ' done';
										}
									}
									$display = $name;
								}
							}
							$id = $year_num->cur.'_'.$month_num->cur.'_'.$temp.'_'.$key;
						}
						else
						{
							if($after == $today AND $real_num == $month_num->after)
							{
								$highlight = ' today';
							}
							if(array_key_exists($key, $cell_data[2]))
							{
								if(array_key_exists($after, $cell_data[2][$key]))
								{
									$piece_1 = $cell_data[2][$key][$after]['type'];
									$name = $cell_data[2][$key][$after]['name'];
									switch($piece_1)
									{
										case 'b': $type.=' b'; $name='Chapelle : '.$name;break;
										case 's': $type.=' s';break;
										case 'v': $type.=' v';break;
										case 'y': $type.=' b';break;
									}
									$display = $name;
								}
							}
							$id = $year_num->after.'_'.$month_num->after.'_'.$after.'_'.$key;
							$after+=1;
						}
						$id = ' id="'.$id.'"';
					}
					$out .= $tab."\t\t\t".'<td'.$id.' class="'.$type.$highlight.'">'.$display.'</td>';
					$temp+=1;
					$before+=1;
				}
				$out .= $tab."\t\t".'</tr>';
			}
			$day_num+=2;
		}

		$out .= $tab."\t".'</tbody>';
		$out .= $tab.'</table><!-- end of the schedule table -->';
		return $out."\n";
	}
}

# Fin du fichier calandrier.php
# Emplacement: /application/libraries/calandrier.php