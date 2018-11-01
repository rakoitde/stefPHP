<?php

// namespace SimpleAPP;
namespace rakoitde\stefPHP;

/**
 * StefPHP - Simple Template Engine for PHP
 *
 * @link
 * @author Ralf Kornberger <rakoitde@gmail.com>
 * @version 1.0.0
 */
class Engine {

	/**
	 * The filename of the template to load.
	 *
	 * @var string
	 */
	private $file;

	/**
	 * The folder that holds the temmplates.
	 *
	 * @var string
	 */
	private $path = "views/";

	/**
	 * An array of values for replacing each tag on the template
	 *
	 * @var array
	 */
	private $values = array();

	/**
	 * Prints aus expression debug informations
	 *
	 * @var boolean
	 */
	private $debug_expression = false;

	/**
	 * Creates a new Template object and sets its associated file
	 * and values.
	 *
	 * @param string $file the filename of the template to load
	 * @param array $values the values to replace in template
	 */
	public function __construct($file, $values=null) {
		If (!is_null($values)) {
			$this->set($values);
		}
		$this->file = $file;
		return $this;
	}

	/**
	 * Sets a value for replacing a specific tag.
	 *
	 * @param array $key an array with key value pairs for the tags to replace
	 * or
	 * @param string $key the name of the tag to replace
	 * @param string $value the value to replace
	 */
	public function set($key, $value="") {
		If (is_array($key)) {
			ForEach ($key as $k=>$v) {
				$this->values[$k] = $v;
			}
		} else {
			$this->values[$key] = $value;
		}
	}

	/**
	 * Help function for expressions
	 *
	 * @param string $value1 an string with first value to compare or connect
	 * @param string $operator the operator to compare or connect the two values
	 * @param string $value2 an string with second value to compare or connect
	 */
	private function expressions ( $value1, $operator, $value2 ) {
		// DEBUG
		echo ($this->debug_expression) ? "Expression: $value1 $operator $value2 = " : "";

		// comparisons
		$operator = (in_array($operator, array("==","eq","=","is"))) 	? "==" : $operator;    	// equal
		$operator = (in_array($operator, array("!=","ne","isnot","<>")))? "!=" : $operator; 	// not equal
		$operator = (in_array($operator, array(">", "gt"))) 			? ">"  : $operator;		// greater then
		$operator = (in_array($operator, array("<", "lt"))) 			? "<"  : $operator;		// lower then
		$operator = (in_array($operator, array(">=","ge")))	 			? ">=" : $operator;		// greater then
		$operator = (in_array($operator, array("<=","le"))) 			? ">=" : $operator;		// lower then

		// connections
		$operator = (in_array($operator, array("&","&&","and"))) 		? "&&" : $operator;		// and
		$operator = (in_array($operator, array("|","||","or"))) 		? "||" : $operator;		// or
		$operator = (in_array($operator, array("xor"))) 						? "xor" : $operator;		// xor
		$operator = (in_array($operator, array("!", "not")))				? "not" : $operator;		// or

		// do the comparison or connection
		switch ($operator) {
			case "==":
				$result = $value1==$value2;
				break;
			case "!=":
				$result = $value1!=$value2;
				break;
			case ">":
				$result = $value1>$value2;
				break;
			case "<":
				$result = $value1<$value2;
				break;
			case ">=":
				$result = $value1>=$value2;
				break;
			case "<=":
				$result = $value1<=$value2;
				break;
			case "&&":
				$result = $value1&&$value2;
				break;
			case "||":
				$result = $value1||$value2;
				break;
			case "xor":
			$result = $value1 xor $value2;
			break;
			case "not":
				$result = !$value1;
				break;
		}
		// DEBUG
		$r = ($result) ? "true" : "false";
		echo ($this->debug_expression) ? "$r\n" : "";

		return $result;
	}

	/**
	 *
   * Get the content of the template, go through the logic and replace
	 * the keys for the corresponding values.
	 *
	 * @return string
	 */
	public function get() {
		/**
		 * Verify if the file exists. If not, use $file as template string.
		 */
		$file = $this->path.$this->file;
		if (!file_exists($file)) {
			// use $file as template
			$output = $this->file;
		} else {
			// load template from file
			$output = file_get_contents($file);
		}

		// if no variables set, return template
		if (count($this->values)==0) {
			return $output;
		}

		$outputs = "";
		$newline = "";
// IF THEN ELSE >>>>>>>

		## Find IfNot Pattern
		$ifnot_pattern = "/\[\!([a-zA-Z_=0-9! ]*?)\]/s";
		preg_match_all($ifnot_pattern, $output, $matchnot);
		//print_r($output);
		//print_r($matchnot);

		## Find If Pattern
		$if_pattern    = "/\[\?([a-zA-Z_]*?)\]/s";
		$if_pattern    = "/\[\?([a-zA-Z_=0-9<>&! ]*?)\]/s";
		preg_match_all($if_pattern, $output, $match);
		//print_r($match);

		//print_r($match[1]);

		## Find All IfNOT Tags
		$matchesnot=array();
		$matches=array();
		$n=0;
		ForEach($matchnot[1] as $m) {
			$ifnot_pattern = "/\[\!(".$m."?)\](.*?)\[\/\!".$m."*?\]/s";
			preg_match_all($ifnot_pattern, $output, $allmatches);
			//print_r($allmatches);
			$matchesnot[0][]=$allmatches[0][0];
			$matchesnot[1][]=$allmatches[1][0];
			$matchesnot[2][]=$allmatches[2][0];
			$n++;
		}
		//print_r(	$matchesnot);

		## Find All If Tags
		$matches=array();
		$n=0;
		ForEach($match[1] as $m) {
			$m2 = explode(" ", $m);
			//echo "$m : ".$m2[0]." \n";
			$if_pattern = "/\[\?(".$m."?)\](.*?)\[\/\?".$m2[0]."*?\]/s";
			$if_pattern = "/\[\?(".$m."?)\](.*?)\[\/\?".$m2[0]."*?\]/s";
			preg_match_all($if_pattern, $output, $allmatches);
			//print_r($allmatches);
			$matches[0][]=$allmatches[0][0];
			$matches[1][]=$allmatches[1][0];
			$matches[2][]=$allmatches[2][0];
			$n++;
		}
		//print_r($matches);

		## IF NOT Tags
		If (isset($matchesnot[0]) && count($matchesnot[0])>0) {
			$mn=0;
			//print_r($matchesnot);
			// print_r($this->values);
			ForEach ($matchesnot[1] as $data) {
				$template = $matchesnot[2][$mn];
				$replace = $matchesnot[0][$mn];
				//echo "\n\n\n>>>>>> $data <<<<<<< \n";
				//echo "Template: $template \n";

				If (isset($this->values[$data])) {
					$type = gettype($this->values[$data]);
					$b = false;
					//echo "Type: $type ";
					switch ($type) {
						case "boolean":
							//echo "Boolean: ".print_r($this->values[$data], true);
							$b = $this->values[$data];
							break;
						case "array":
							//echo "Array: ".count($this->values[$data])."<";
							$b = (count($this->values[$data])>0) ? true : false;
							break;
						case "string":
							$b = ($this->values[$data]!="") ? true : false;
							break;
						default:
							print_r("IF THEN ELSE TYPE: $type");
					}
					If ($b) {
						$output = str_replace($replace, "", $output); // "<!-- [!$data]...[/$data] removed -->"
					} else {
						$output = str_replace($replace, $template, $output);
					}
				}


				$mn++;
			}
		}

		## IF Tags
		If (isset($matches[0]) && count($matches[0])>0) {
			$mn=0;
			// print_r($matches);
			//print_r($this->values);
			ForEach ($matches[1] as $data) {
				$template = $matches[2][$mn];
				$replace = $matches[0][$mn];
				echo ($this->debug_expression) ? "\n\n\n>>>>>> $data <<<<<<< \n" : "";
				//echo "\n\n\n>>>>>> $data <<<<<<< \n";
				//echo "Template: $template \n";

				$param = explode(" ", $data);
				$data = $param[0];

				//print_r($this->values[$data]);

				If (isset($this->values[$data])) {
					$type = gettype($this->values[$data]);

					$b = true;
					echo ($this->debug_expression) ? "Type: $type \n" : "";
					switch ($type) {
						case "boolean":
							//echo "Boolean: ".print_r($this->values[$data], true);
							$b = $this->values[$data];
							break;
						case "array":
							//echo "Array: ".count($this->values[$data])."<";
							$b = (count($this->values[$data])>0) ? true : false;
							break;
						case "string":
							// echo "String: ".$this->values[$data],"\n";
							if (count($param)>1) {

								$b = ( $this->expressions($this->values[$data], $param[1], (isset($param[2])) ? $param[2] : "" ) ) ? true : false;
								//$b = ($this->values[$data]==$param[2]) ? true : false;
							} else {
								$b = ($this->values[$data]=="") ? false : true;
							}
							break;
						default:
							print_r("IF THEN ELSE TYPE: $type");
					}
					If (!$b) {
						$output = str_replace($replace, "", $output); // <!-- [?$data]...[/$data] removed -->
					} else {
						$output = str_replace($replace, $template, $output);
					}
				}


				$mn++;
			}

		}
// <<<<<<<< IF THEN ELSE

// LOOPS >>>>>>>

		$loop_pattern = "/\[\%([a-zA-Z]*?)\](.*?)\[\/%[a-zA-Z]\]/s";
		$loop_pattern = "/\[\%([a-zA-Z]*?)\](.*?)\[\/[a-zA-Z]*?\]/s";
		$loop_pattern = "/\[\%([a-zA-Z_]*?)\]/s";
		preg_match_all($loop_pattern, $output, $match);

		$matches=array();
		$n=0;
		ForEach($match[1] as $m) {
			$loop_pattern = "/\[\%(".$m."?)\](.*?)\[\/\%".$m."*?\]/s";
			preg_match_all($loop_pattern, $output, $allmatches);
			// print_r($allmatches);
			$matches[0][]=$allmatches[0][0];
			$matches[1][]=$allmatches[1][0];
			$matches[2][]=$allmatches[2][0];
			$n++;
		}

		// $f=$matches[1][0];
		//echo "1: ($f) ".$$f."\n";

		// print_r($matches);

		If (isset($matches[0]) && count($matches[0])>0) {
			$mn=0;
			//print_r($matches[1]);
			//print_r($this->values);
			ForEach ($matches[1] as $data) {
				$template = $matches[2][$mn];
				$replace = $matches[0][$mn];
				//echo "\n\n\n>>>>>> $data <<<<<<< \n";
				//echo "Template: $template \n";

				// Array Loops
				If (isset($this->values[$data])) {
					$result="";
					//print_r($this->values[$data]);
					ForEach ($this->values[$data] as $d) {
						$t = new Engine($template, $d);
						$result.=$t->get();
					}
					// echo "RRRRRRR>>>> $result";
					$output = str_replace($replace, $result, $output);
					// echo $output;
					// $output = str_replace("%$data"."_", "%", $output);
					// $output = str_replace("/$data"."_", "%", $output);

				// Key Value Loops
				} elseif ($data=="loop") {
					//echo "\n\n\n######### $data ######### \n";

					//print_r($this->values);
					$new_value = array();
					foreach ($this->values as $new_key=>$new_val) {
						$new_value[]=array("key"=>$new_key, "value"=>$new_val);
					}

					//echo "\n\n\n>>>>>> NEW VALUE <<<<<<< \n";
					//print_r($new_value);

					$results = "";
					ForEach ($new_value as $nv) {

						If (!is_array($nv['key']) && !is_array($nv['value'])) {
							$result = str_replace("[@key]", $nv['key'], $template);
							$result = str_replace("[@value]", $nv['value'], $result);
							$results.=$result;
						}
					}
					//echo "RRRRRRR>>>> $results";
					$output = str_replace($replace, $results, $output);
				}
				$mn++;
			}
			$outputs = $output;
		}

// <<<<<<  LOOPS

		//
		foreach ($this->values as $key => $value) {
			If (is_string($value) && !is_int($key)) {
				If ($outputs=="") { $outputs = $output; }
				$tagToReplace = "[#$key]";
				$outputs = str_replace($tagToReplace, $value, $outputs);
				$tagToReplace = "[@$key]";
				$outputs = str_replace($tagToReplace, $value, $outputs);
			} ElseIf (1==2) {
				$o = $output;
				// IMPORT ToDo >>>>>
									$import = "/\[!import (.*?)\]/";
									preg_match_all($import, $output, $matches);
									If (count($matches['0'])>0) {
										$new_value = array();
										foreach ($value as $new_key=>$new_val) {
											$new_value[]=array("key"=>$new_key, "value"=>$new_val);
										}
										$i = new Engine($matches['1']['0'].".tpl", $new_value);
										$o = str_replace($matches['0']['0'], $i->get(), $o);
									}
				// <<<<< IMPORT ToDo
				ForEach ($value as $k=>$v) {
					//
					$keyToReplace = "[#$k]";
					$o = str_replace($keyToReplace, $k, $o);
					$tagToReplace = "[@$k]";
					$o = str_replace($tagToReplace, $v, $o);
				}
				$outputs = $outputs.$newline.$o;
				$newline = "\n";
			}
		}
		return $outputs;
	}
}

?>
