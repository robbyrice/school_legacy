<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function list_nav($base, $cur, $items, $num=1)
{
	$nav = '';
	$tab = '';

	for($i=1; $i<=$num; $i++)
	{
		$tab .= "\t";
	}

	foreach($items as $key=>$value)
	{
		$active = '';
		$ref = $base.$key;
		switch($cur)
		{
			case ltrim($key,'/'):$active = " class='active'";
		}
		$nav .= $tab."<li><a".$active." href='$ref'>".$value."</a></li>\n";
	}
	return $nav;
}

/*
 * @param string $base
 * @param obj $month_num
 * @param obj $year_num
 * @param int $num
 * @return string
 * @version 0.3
 */
function cal_nav($base, $month_num, $month_name, $year_num, $num=1)
{
	$out	= '';
	$tab	= '';

	for($i=1; $i<=$num; $i+=1)
	{
		$tab .= "\t";
	}

	foreach(array('before', 'cur', 'after') as $type)
	{
		$style = '><a href="'.base_url().$base.$month_name->$type->accent.'/'.$year_num->$type.'">';
		$content = $month_name->$type->short;
		$end = '</a></div>';

		switch($type)
		{
			case 'cur':
				$style		=	' class="active">';
				$content	=	$month_name->cur->long;
				$end		=	'</div>';
				break;
			case 'before':
				$style		.= '< ';break;
			case 'after':
				$end		= ' >'.$end;
		}

		$out .= $tab.'<div'.$style.$content.' '.$year_num->$type.$end."\n";
	}

	return $out;
}

# Fin du fichier nav_helper.php
# Emplacement: ./application/helpers/nav_helper.php