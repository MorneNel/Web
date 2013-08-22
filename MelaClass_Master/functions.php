<?php

//------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------

// --- NOT used in folder option 2
// /* As below, but rets the full program path (so can be used in includes directly) */
// function getProgFolder()
// {
//     return $_SERVER['DOCUMENT_ROOT'].'/Web Folder/'.getProgName().'/';
// }

// /* Rets the current program name based on the php file call history (actually the application name folder part)
//    Rets either: "Outreach" (OR+Pain+TV+etc), "Medicus", "Paediatric"
// */
// function getProgName()
// {

//     // Uses simple array=>str=>strsearch 
//     // If problematic later, then look for a specifc (last) array element or similar
//     $arr = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
//     $str = print_r($arr,true);
//     //echo 

//     // $$$ constants in a file

//     if (strpos($str,"\Outreach"))
//         return "Outreach"; 
//     if (strpos($str,"\Medicus"))
//         return "Medicus"; 
//     if (strpos($str,"\Paediatric"))
//         return "Paediatric"; 

//     return "PROGRAM NOT RECOGNISED ".$str; // err msg if fails above
//     //var_dump($ORPos);
//     //echo "OR:".$ORPos." Medi:".$MediPos
// }


function stringToDateTime ($string,$format = 1) {
    // Format date/time values from database so they are suitable
    // to insert as default [input type=date] and [input type=datetime-local] values
    
    // Typical format fed in is: 30/03/2005 00:00:00    
    // Date needs to take YYYY-MM-DD format
    // Datetime-local format is YYYY-MM-DDT00:00:00
    
    $splitString = explode(' ',$string);
    if (!isset($splitString[1])) return $splitString[0];
    $splitString2 = explode('/', $splitString[0]);
    $date = "".$splitString2[2]."-".$splitString2[1]."-".$splitString2[0]."";
    $datetime = "".$date."T".$splitString[1]."";
    
    // Which format to return?
    // 1 = date time
    // 2 = date
    // 3 = time
    switch($format) {
    case 1:
        return $datetime;
    break;

    case 2:
        return $date;    
    break;
    
    case 3:
        return $splitString[1];
    break;
    }
}

function dateToString ($string) {
    // Opposite function of stringToDateTime, converts
    // [input type=date] to the date format used by 4D SQL Date format    
    // Format fed: YYYY-MM-DD
    // 4D Date format: DD/MM/YYYY
    
    // Date should be exactly 10 characters long
    if (strlen($string) != 10) return false;
    
    $splitString = explode('-',$string);
    $date = "".$splitString[2]."/".$splitString[1]."/".$splitString[0]."";
    
    return $date;
}

function soft_Clean($str_input) {
    $str_input = trim($str_input);
    $str_input = htmlspecialchars($str_input);
    $str_input = utf8_encode ($str_input);
    $str_input = str_replace ('<', '<', $str_input);
    $str_input = str_replace ("\'", "'", $str_input);
    $str_input = str_replace("'", "'", $str_input);
    $str_input = str_replace("<?", "", $str_input);
    $str_input = str_replace("<!", "", $str_input);
    $str_input = str_replace("<script", "", $str_input);
    $str_input = str_replace("<a href", "", $str_input);
    $str_input = str_replace('">', '', $str_input);
    $str_input = str_replace('</A>', '', $str_input);
    $str_input = str_replace('</a>', '', $str_input);
    return $str_input;
}

function checkValues($value)
{
	 // Use this function on all those values where you want to check for both sql injection and cross site scripting
	 //Trim the value
	 $value = trim($value);

	// Stripslashes
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}

	 // Convert all &lt;, &gt; etc. to normal html and then strip these
	 $value = strtr($value,array_flip(get_html_translation_table(HTML_ENTITIES)));

	 // Strip HTML Tags
	 $value = strip_tags($value);

	// Quote the value
	//$value = mysql_real_escape_string($value);
	return $value;

}

function stripslashes_deep($value)
{
    $value = is_array($value) ?
                array_map('stripslashes_deep', $value) :
                stripslashes($value);

    return $value;
}

/*
 * convert4DTime
 * 4D appears to save Time values in a weird
 * format like 0:9:35:0 which assumedly is 09:35
 * so this generic function formats a 4D time to
 * be human readable
 * @param Time $time The 4D time field to be converted
 * @return string Human readable 24hr time, such as 09:35
 */
function convert4DTime($time) {
    $timeSplits = explode(':',$time);
    if (!isset($timeSplits[2])) return $time;
    
    // Ony interested in [1] and [2]
    $hour = str_pad($timeSplits[1], 2, '0', STR_PAD_LEFT);
    $minutes = str_pad($timeSplits[2], 2, '0', STR_PAD_LEFT);
    
    $formattedTime = "".$hour.":".$minutes."";
    
    return $formattedTime;
}

function array_pshift(&$array) { 
    $keys = array_keys($array); 
    $key = array_shift($keys); 
    $element = $array[$key]; 
    unset($array[$key]); 
    return $element; 
}

/*
 * Returns in text format the day of the week
 * as taken from [DAILY_LINK]dlkAssessDate
 * Example input format: 10/07/2003 00:00:00
 */ 

function getDayFromDate($date) {
    $newdate = str_replace('/','-',$date);
    $dateSplit = explode(' ', $newdate);
    $dayofWeek = date('l', strtotime($dateSplit[0]));
    return $dayofWeek;
}

/*
 * Functions much like array_push but can be
 * used for associative arrays
 */

    function array_push_associative(&$arr) {
       $args = func_get_args();
       foreach ($args as $arg) {
           if (is_array($arg)) {
               foreach ($arg as $key => $value) {
                   $arr[$key] = $value;
                   $ret++;
               }
           }else{
               $arr[$arg] = "";
           }
       }
       return $ret;
    }
?>