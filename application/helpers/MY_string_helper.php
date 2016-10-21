<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Verify Case
 *
 * Lets us manipulate the input string to make sure the output is
 * capitalized the way we want it. The inner-most "switch" needs
 * to be changed to control what the function interprets as a word,
 * and what it does with that word. The second parameter is optional
 * and can be any of the following to control how the output looks.
 *
 * name		-	name capitalization (default)
 * sentence	-	sentence capitalization
 * class	-	class name capitalization
 * upper	-	all uppercase
 * lower	-	all lowercase
 *
 * @access	public
 * @param	string
 * @param	string
 * @return	the modified input string
 */
function verify_case($input, $type='name')
{
	//no need to return anything if the user hasn't supplied us with anything to work with
	if($input === '') return NULL;

	$new = '';

	//just in case the user has done something weird
	$input = mb_strtolower($input);

	//splitting the input string at apostrophes, hyphens and spaces
	$input = preg_split("/(['\- ])/", $input, NULL, PREG_SPLIT_DELIM_CAPTURE);
	$len = count($input);

	foreach($input as $key=>$value)
	{
		if(strpos($value, '\\') === 0)
		{
			$new .=	mb_strtoupper(ltrim($value, '\\'));
		}
		elseif(strpos($value, '_') === 0)
		{
			$new .=	ucfirst(ltrim($value, '_'));
		}
		else
		{
			switch($type)
			{
				case 'upper':	$new	.= mb_strtoupper($value);break;
				case 'lower':	$new	.= mb_strtolower($value);break;
				case 'name' :
					if(strlen($value) === 1 AND $len === 1)
					{
						$new .= mb_strtoupper($value).'.';
					}
					else
					{
						$new .=	ucfirst($value);
					}
					break;
				case 'sentence':
					switch($key)
					{
						case 0:	$new .= ucfirst($value);break;  //only the first word in a sentence should be capitalized
						default:
							switch($value)
							{
								case 'god':		$new .=	ucfirst($value);break;
								case 'dieu':	$new .=	ucfirst($value);break;
								case 'christ':	$new .=	ucfirst($value);break;
								case 'jesus':	$new .= ucfirst($value);break;
								case 'jésus':	$new .= ucfirst($value);break;
								case 'lord':	$new .=	ucfirst($value);break;
								case 'bible':	$new .=	ucfirst($value);break;
								case 'i':		$new .=	mb_strtoupper($value);break;
								default:		$new .=	$value;
							}
					}
					break;
				case 'class':
					switch($value)
					{
						case 'at':	$new .=	mb_strtoupper($value);break;
						case 'au':	$new .=	$value;break;
						case 'de':	$new .= $value;break;
						case 'du':	$new .= $value;break;
						case 'et':	$new .= $value;break;
						case 'ii':	$new .=	mb_strtoupper($value);break;
						case 'iii':	$new .=	mb_strtoupper($value);break;
						case 'l':	$new .= $value;break;
						case 'nt':	$new .= mb_strtoupper($value);break;
						default:	$new .=	ucfirst($value);
					}
					break;
			}
		}
	}

	return trim($new);
}

# Fin du fichier MY_string_helper.php
# Emplacement: ./application/helpers/MY_string_helper.php
