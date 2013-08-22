<?php
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

if (!$_REQUEST['input'] || !is_numeric($_REQUEST['input'])) die("No input value specified or invalid input format!");
if (!$_REQUEST['category']) die("No category specified!");

$input = filter_var($_REQUEST['input'], FILTER_SANITIZE_NUMBER_INT);

// This is used to build the SQL query by selecting which fields to use
switch (strtoupper($_REQUEST['category'])) {
    case "BE":
    case "BP":
    case "CNS":
    case "GCS":
    case "HR":
    case "O2":
    case "PAO2":
    case "PH":
    case "RR":
    case "URINE":
    case "URINEDD":
        $formCategory = strtoupper($_REQUEST['category']);
    break;

    case "PAIN":
        $formCategory = "Pain";
    break;

    case "RESP":
        $formCategory = "Resp";
    break;

    case "TEMP":
        $formCategory = "Temp";
    break;

    default:
        die("Invalid category given!");
    break;
}

// For some reason the lowest field is ...0H, ...0L for ints but just ...0 for strings
switch (strtoupper($_REQUEST['category'])) {
    case "BE":
    case "BP":    
    case "GCS":
    case "HR":
    case "O2":
    case "PAO2":
    case "PH":
    case "RR":
    case "TEMP":
    case "URINE":
        $lowestField = "EWSS_".$formCategory."_0H, EWSS_".$formCategory."_0L";
    break;

    case "CNS":
    case "PAIN":
    case "RESP":
    case "URINEDD":
        $lowestField = "EWSS_".$formCategory."_0";
    break;

    default:
        $lowestField = "EWSS_".$formCategory."_0H, EWSS_".$formCategory."_0L";
    break;
}

// Not every category is consistent with the last/highest field either...some use 5H, some use Max
switch (strtoupper($_REQUEST['category'])) {    
    case "CNS":
    case "PAIN":
    case "RESP":
    case "URINEDD":
        $highestField = "EWSS_".$formCategory."_5H";
    break;

    case "BE":
    case "BP":
    case "GCS":
    case "HR":
    case "O2":
    case "PAO2":
    case "PH":
    case "RR":
    case "TEMP":
    case "URINE":
        $highestField = "EWSS_".$formCategory."_Max";
    break;

    default:
        $highestField = "EWSS_".$formCategory."_Max";
    break;
}

$result = getTriggerScore($connect,$input,$formCategory,$lowestField,$highestField);
echo $result;

function getTriggerScore($connect,$input,$category,$lowestField,$highestField) {
    $upperCat = strtoupper($category);
    $triggerLevel = '0';
    // get field values
    /*
    * There are 3 rows for EWSS
    * Which one to pick?
    */ 
    $query = "SELECT $lowestField, EWSS_".$category."_1H, EWSS_".$category."_1L, EWSS_".$category."_2H, EWSS_".$category."_2L,
              EWSS_".$category."_3H, EWSS_".$category."_3L, EWSS_".$category."_4H, EWSS_".$category."_4L, EWSS_".$category."_5L, $highestField
              FROM EWSS
              WHERE EWSS_Type=2 AND".$Mela_SQL->sqlHUMinMax("EWSS_ID");
    try { 
        $result = odbc_exec($connect,$query); 
        if($result){ 
            $EWSS = odbc_fetch_array($result);
        } 
        else{ 
        throw new RuntimeException("Failed to connect."); 
        } 
            } 
        catch (RuntimeException $e) { 
                print("Exception caught: $e");
        }
        
    // Find out correct trigger value
    // Some categories use 0H & 0L, some just use 0...would kill for consistency
    // Resp, Pain are different
        switch ($upperCat) {
            case "PAIN":
            case "RESP":
            case "CNS":
                if (($EWSS['EWSS_'.$upperCat.'_5L'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_5L'])) {
                    $triggerLevel = 5;
                }
                elseif (($EWSS['EWSS_'.$upperCat.'_4L'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_4L'])) {
                    $triggerLevel = 4;
                }
                elseif (($EWSS['EWSS_'.$upperCat.'_3L'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_3L'])) {
                    $triggerLevel = 3;
                }
                elseif (($EWSS['EWSS_'.$upperCat.'_2L'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_2L'])) {
                    $triggerLevel = 2;
                }
                elseif (($EWSS['EWSS_'.$upperCat.'_1L'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_1L'])) {
                    $triggerLevel = 1;
                }
                 
                elseif ($EWSS['EWSS_'.$upperCat.'_0'] != 0) {
                    $triggerLevel = 0;
                }
                
                elseif (($EWSS['EWSS_'.$upperCat.'_1H'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_1H'])) {
                    $triggerLevel = 1;
                }
                elseif (($EWSS['EWSS_'.$upperCat.'_2H'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_2H'])) {
                    $triggerLevel = 2;
                }
                elseif (($EWSS['EWSS_'.$upperCat.'_3H'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_3H'])) {
                    $triggerLevel = 3;
                }
                elseif (($EWSS['EWSS_'.$upperCat.'_4H'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_4H'])) {
                    $triggerLevel = 4;
                }
                /*elseif (($EWSS['EWSS_'.$upperCat.'_MAX'] != 0) && ($input > $EWSS['EWSS_'.$upperCat.'_4H'])) {
                    $triggerLevel = 5;
                }*/
            break;
        
            default:
                if (($EWSS['EWSS_'.$upperCat.'_5L'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_5L'])) {
                    $triggerLevel = 5;
                }
                elseif (($EWSS['EWSS_'.$upperCat.'_4L'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_4L'])) {
                    $triggerLevel = 4;
                }
                elseif (($EWSS['EWSS_'.$upperCat.'_3L'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_3L'])) {
                    $triggerLevel = 3;
                }
                elseif (($EWSS['EWSS_'.$upperCat.'_2L'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_2L'])) {
                    $triggerLevel = 2;
                }
                elseif (($EWSS['EWSS_'.$upperCat.'_1L'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_1L'])) {
                    $triggerLevel = 1;
                }
                 
                elseif (($EWSS['EWSS_'.$upperCat.'_0L'] != 0) && ($input >= $EWSS['EWSS_'.$upperCat.'_0L']) && ($input <= $EWSS['EWSS_'.$upperCat.'_0H'])) {
                    $triggerLevel = 0;
                }
                
                elseif (($EWSS['EWSS_'.$upperCat.'_1H'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_1H'])) {
                    $triggerLevel = 1;
                }
                elseif (($EWSS['EWSS_'.$upperCat.'_2H'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_2H'])) {
                    $triggerLevel = 2;
                }
                elseif (($EWSS['EWSS_'.$upperCat.'_3H'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_3H'])) {
                    $triggerLevel = 3;
                }
                elseif (($EWSS['EWSS_'.$upperCat.'_4H'] != 0) && ($input <= $EWSS['EWSS_'.$upperCat.'_4H'])) {
                    $triggerLevel = 4;
                }
                /*elseif (($EWSS['EWSS_'.$upperCat.'_MAX'] != 0) && ($input > $EWSS['EWSS_'.$upperCat.'_4H'])) {
                    $triggerLevel = 5;
                }*/    
            break;
        }
        
        
        //var_dump($EWSS);
        
        return $triggerLevel;
}