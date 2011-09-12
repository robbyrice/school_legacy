<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Date Mysql
 *
 * @author Robert Doucette
 * @return	the date as a string formatted for a Mysql database
 * @version 0.6
 */
function date_mysql()
{
	return date('Y-m-d H:i:s');
}

/**
 * @author Robert Doucette
 * @return array the keys have accents, the values do not
 * @version 0.2
 */
function get_month_names()
{
	$names = array(
		'janvier'	=>	array(
			'num'				=>1,
			'name_long'		=>'janvier',
			'name_short'	=>'jan'
		),
		'février'	=>	array(
			'num'				=>2,
			'name_long'		=>'fevrier',
			'name_short'	=>'fev'
		),
		'mars'		=>	array(
			'num'				=>3,
			'name_long'		=>'mars',
			'name_short'	=>'mar'
		),
		'avril'		=>	array(
			'num'				=>4,
			'name_long'		=>'avril',
			'name_short'	=>'avr'
		),
		'mai'		=>	array(
			'num'				=>5,
			'name_long'		=>'mai',
			'name_short'	=>'mai'
		),
		'juin'		=>	array(
			'num'				=>6,
			'name_long'		=>'juin',
			'name_short'	=>'jui'
		),
		'septembre'	=>	array(
			'num'				=>9,
			'name_long'		=>'septembre',
			'name_short'	=>'sep'
		),
		'octobre'	=>	array(
			'num'				=>10,
			'name_long'		=>'octobre',
			'name_short'	=>'oct'
		),
		'novembre'	=>	array(
			'num'				=>11,
			'name_long'		=>'novembre',
			'name_short'	=>'nov'
		),
		'décembre'	=>	array(
			'num'				=>12,
			'name_long'		=>'decembre',
			'name_short'	=>'dec'
		)
	);
	return $names;
}

/**
 * @author Robert Doucette
 * @param string $name
 * @param int $year
 * @return obj
 * @version 0.5
 */
function get_month_info($name, $year)
{
	$year_before = $year;
	$year_after = $year;
	switch($name)
	{
		case 'janvier':	$year_before	= $year-1;break;
		case 'décembre':	$year_after		= $year+1;
	}

	
	$names = get_month_names();
	$cur = (array_key_exists($name, $names)) ? $names[$name]['num'] : 9; //showing the month of september during july and august

	$before = $cur-1;
	$after = $cur+1;
	switch($cur)
	{
		case 1:	$before	= 12;break;
		case 12:	$after	= 1;
	}


	$day_num = 1;
	$day_num_before	= cal_days_in_month(0, $before, $year_before);
	$days_in_month		= cal_days_in_month(0, $cur, $year);
	$first_day			= mktime(0,0,0,$cur,1,$year);
	$month_start		= strftime('%a', $first_day);
	switch($month_start)
	{
		case 'mar.':$day_num=0;break;
		case 'mer.':$day_num=-1;$day_num_before=$day_num_before-1;break;
		case 'jeu.':$day_num=-2;$day_num_before=$day_num_before-2;break;
		case 'ven.':$day_num=-3;$day_num_before=$day_num_before-3;break;
		case 'sam.':$day_num=3;break;
		case 'dim.':$day_num=2;
	}


	foreach($names as $key=>$value)
	{
		switch($value['num'])
		{
			case $before == 8 ? 6 : $before:
				$before_long	= $value['name_long'];
				$before_short	= $value['name_short'];
				$before_accent	= $key;
				break;
			case $cur:
				$long		= $value['name_long'];
				$short	= $value['name_short'];
				$accent	= $key;
				break;
			case $after == 7 ? 9 : $after:
				$after_long		= $value['name_long'];
				$after_short	= $value['name_short'];
				$after_accent	= $key;
		}
	}

	
	return (object) array(
		'month' => (object) array(
			'before'	=>	$before,
			'cur'		=>	$cur,
			'after'	=>	$after
		),
		'year'	=>	(object) array(
			'before'	=>	$year_before,
			'cur'		=>	$year,
			'after'	=>	$year_after
		),
		'day'	=>	(object) array(
			'before'	=>	$day_num_before,
			'cur'		=>	$day_num,
			'after'	=>	1
		),
		'name'	=>	(object) array(
			'before'	=>	(object) array(
				'long'	=>	$before_long,
				'short'	=>	$before_short,
				'accent'	=>	$before_accent
			),
			'cur'		=>	(object) array(
				'long'	=>	$long,
				'short'	=>	$short,
				'accent'	=>	$accent
			),
			'after'		=>	(object) array(
				'long'	=>	$after_long,
				'short'	=>	$after_short,
				'accent'	=>	$after_accent
			)
		),
		'days_in_month'	=>	$days_in_month,
	);
}


/**
 *
 * @param int $year
 * @return array
 * @version 0.2
 */
function get_years($year)
{
	$start = '2011';
	$adjust = $year-3;
	if($adjust < $start)
	{
		$adjust = $start;
	}
	$end = $adjust+6;
	for(; $adjust <= $end; $adjust++)
	{
		$years[$adjust] = $adjust;
	}
	return $years;
}

# Fin du fichier MY_date_helper.php
# Emplacement: ./application/helpers/MY_date_helper.php