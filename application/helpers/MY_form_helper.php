<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * creates the output for the options of a select menu
	 *
	 * @param array $data
	 * @param int $num
	 * @param string $select
	 * @return string
	 * @version 0.4
	 */
	function dropdown_options($data, $num=1, $select=NULL)
	{
		$options = '';
		$tab = '';

		for($i=1; $i<=$num; $i+=1)
		{
			$tab .= "\t";
		}

		foreach($data as $key=>$value)
		{
			if(!is_array($value))
			{
				switch($key)
				{
					case $select:$selected = ' selected="selected"';break;
					default:$selected = '';
				}
				$options .= $tab.'<option'.$selected.' value="'.$key.'">'.$value.'</option>'."\n";
			}
			else
			{
				$options .= $tab.'<optgroup label="'.$key.'">'."\n";
				foreach($value as $key=>$value)
				{
					switch($key)
					{
						case $select:$selected = ' selected="selected"';break;
						default:$selected = '';
					}
					$options .= $tab."\t".'<option'.$selected.' value="'.$key.'">'.$value.'</option>'."\n";
				}
				$options .= $tab."</optgroup>\n";
			}
		}
		return $options;
	}

	/**
	 * this function can create either radio buttons or checkboxes
	 *
	 * @param string $type the type of input we want to create (radio or checkbox)
	 * @param array $data an array where the key will be used in the input and the value will be used in the label
	 * @param string $name the name of the input
	 * @param int $tabindex the number we want to start counting up from
	 * @param int $num
	 * @param string/array $select the value(s) that should be display(ed) when the input is displayed
	 * @return string
	 * @version 0.3
	 */
	function rad_check($type, $data, $name, $tabindex=0, $num=1, $select=NULL)
	{
		$output = '';
		$tab = '';

		for($i=1; $i<=$num; $i+=1)
		{
			$tab .= "\t";
		}

		foreach($data as $key=>$value)
		{
			if(is_array($select))
			{
				foreach($select as $s)
				{
					switch($key)
					{
						case $s:$selected = ' checked="checked"';break 2;
						default:$selected = '';
					}
				}
			}
			else
			{
				switch($key)
				{
					case $select:$selected = ' checked="checked"';break;
					default:$selected = '';
				}
			}
				$output .= $tab."<p>\n";
				$output .= $tab."\t".'<label for="'.$key.'">'.$value.'</label>'."\n";
				$output .= $tab."\t".'<input'.$selected.' id="'.$key.'" name="'.$name.'" tabindex="'.$tabindex.'" type="'.$type.'" value="'.$key.'" />'."\n";
				$output .= $tab."</p>\n";
				$tabindex+=1;
		}
		return $output;
	}

# Fin du fichier MY_form_helper.php
# Emplacement: /application/helpers/MY_form_helper.php