<?php
include('./MelaClass/db.php');
include('./MelaClass/authInitScript.php');

if (!$_REQUEST['page']) die("No page specified!");
if (!$_REQUEST['itemID']) die("No item ID!");
$sanitisedItemID = filter_var($_REQUEST['itemID'], FILTER_SANITIZE_NUMBER_INT);

switch ($_REQUEST['page']) {
    default:
        echo "Invalid page data given";
    break;

    case "agents":
        $query = "DELETE FROM Infection_Agents WHERE ID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;

    case "careLevel":
        $query = "DELETE FROM CareLevel WHERE CareLevelItem_ID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;

    case "comorbidity":
        $query = "DELETE FROM Co_Morbidity WHERE com_ID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;

    case "critInc":
        $query = "DELETE FROM Critical_Inc WHERE Itm_ID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;

    case "dailyOutcome":
        $query = "DELETE FROM DailyOutcome WHERE DailyOutcome_ID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;

    case "drugs":
        $query = "DELETE FROM Infection_Antibiotics WHERE ID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;

    case "interventions":
        $query = "DELETE FROM Investigations WHERE inv_ID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;

    case "medications":
        $query = "DELETE FROM Medication WHERE itm_ID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;

    case "pre-medications":
        $query = "DELETE FROM Medication WHERE itm_ID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;

    case "rec-medications":
        $query = "DELETE FROM Medication WHERE itm_ID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;

    case "modalities":
        $query = "DELETE FROM Modality WHERE mod_ID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;

    case "OPCS":
        $query = "DELETE FROM OPER_PatOperations WHERE OPER_ID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;

    case "painAssessment":
        $query = "DELETE FROM CareLevel WHERE CareLevelItem_ID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;

    case "pre-medications":
        $query = "DELETE FROM Medication WHERE ID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;

    case "rec-medications":
        $query = "DELETE FROM Medication WHERE ID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;

    case "respiteCare":
        $query = "DELETE FROM RespiteCare WHERE Respite_Care_ID=$sanitisedItemID";
        try { 
                $result = odbc_exec($connect,$query); 
                if(!$result) { 
                    throw new RuntimeException("Failed to connect."); 
                } 
        } 
        catch (RuntimeException $e) { 
            print("Exception caught: $e");
        }    
    break;

    case "site":
        $query = "DELETE FROM Infection_Site WHERE ID=$sanitisedItemID";
        try { 
                $result = odbc_exec($connect,$query); 
                if(!$result) { 
                    throw new RuntimeException("Failed to connect."); 
                } 
        } 
        catch (RuntimeException $e) { 
            print("Exception caught: $e");
        }
    break;

    case "surgery":
        $query = "DELETE FROM Surgery WHERE srg_ID=$sanitisedItemID";
        try { 
                $result = odbc_exec($connect,$query); 
                if(!$result) { 
                    throw new RuntimeException("Failed to connect."); 
                } 
        } 
        catch (RuntimeException $e) { 
            print("Exception caught: $e");
        }
    break;

    case "score2door":
        $query = "DELETE FROM Sco2Door_Reason WHERE Item_ID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;

    case "tasks":
        $query = "DELETE FROM Tasks WHERE ItmID=$sanitisedItemID";
        try { 
              $result = odbc_exec($connect,$query); 
              if(!$result) { 
                 throw new RuntimeException("Failed to connect."); 
              } 
           } 
           catch (RuntimeException $e) { 
                   print("Exception caught: $e");
                   //exit;
           }
    break;
}