<?php
include './MelaClass/db.php';
// $$$$$$ FAILS sometimes with DOM expception 19, but should be called --- include './MelaClass/authInitScript.php';
include './MelaClass/authInitScript.php';

$group = $_REQUEST['group'];
$dlkID = $_REQUEST['dlk_ID'];
$lnkID = $_REQUEST['lnk_ID'];
$itemID = $_REQUEST['itemID'];

$sanitisedSelect = filter_var($group, FILTER_SANITIZE_STRING);
$sanitisedDLKID = filter_var($dlkID, FILTER_SANITIZE_NUMBER_INT);
$sanitisedLnkID = filter_var($lnkID, FILTER_SANITIZE_NUMBER_INT);
$sanitisedItemID = filter_var($itemID, FILTER_SANITIZE_NUMBER_INT);

//---------------------------------------------------------------------------------------

/* $Type: 1=current, 2=prescribed, 3=recommended */
function AddMedication ($Type)
{
    global $sanitisedSelect,$sanitisedDLKID,$sanitisedLnkID,$sanitisedItemID; // use the vars from outside
    global $connect;

    // --- Already in trigger --- $ID = $Mela_SQL->GetPK('Medication',true);
    $query = "INSERT INTO Medication (itm_ID,med_dlkID,med_lnkID,med_Type) VALUES ($sanitisedItemID,$sanitisedDLKID,$sanitisedLnkID,$Type)";
    try { 
        $result = odbc_exec($connect,$query); 
        if($result){ 
              echo $sanitisedItemID;
                // // Get the row just created - unfortunately the table does not provide unique row IDs <--- this one is ---
                // // so get the last row added
                // $query = "SELECT itm_ID FROM Medication WHERE itm_ID=$sanitisedItemID AND med_dlkID=$sanitisedDLKID AND med_lnkID=$sanitisedLnkID AND med_Type=1";
                //  try { 
                //     $result = odbc_exec($connect,$query);
                //     if($result){
                //         $newestRow = odbc_fetch_array($result);
                //         echo $newestRow['ITM_ID'];
                //     } 
                //     else{ 
                //     throw new RuntimeException("Failed to connect."); 
                //     } 
                //         } 
                //     catch (RuntimeException $e) { 
                //             print("Exception caught: $e");
                //             //exit;
                //     }
        } 
        else{ 
          throw new RuntimeException("Failed to connect."); 
          } 
        } 
        catch (RuntimeException $e) { 
                print("Exception caught: $e");
        }
}

//---------------------------------------------------------------------------------------

if (!$_REQUEST['destination']) die("A specific dropdown list must be specified");

switch ($_REQUEST['destination']) {
    default:
        echo "Invalid destination data given";
    break;

    case "agents":
        $query = "INSERT INTO Infection_Agents (ID,agent_dlkID,agent_lnkID) VALUES ($sanitisedItemID,$sanitisedDLKID,$sanitisedLnkID)";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
                echo $sanitisedItemID;
                    // // Get the row just created - unfortunately the table does not provide unique row IDs,
                    // // so get the last row added
                    // $query = "SELECT ID FROM Infection_Agents WHERE ID=$sanitisedItemID AND agent_dlkID=$sanitisedDLKID AND agent_lnkID=$sanitisedLnkID";
                    //  try { 
                    //     $result = odbc_exec($connect,$query);
                    //     if($result){
                    //         $newestCareLevelRow = odbc_fetch_array($result);
                    //         echo $newestCareLevelRow['ID'];
                    //     } 
                    //     else{ 
                    //     throw new RuntimeException("Failed to connect."); 
                    //     } 
                    //         } 
                    //     catch (RuntimeException $e) { 
                    //             print("Exception caught: $e");
                    //             //exit;
                    //     }
            } 
            else{ 
            throw new RuntimeException("Failed to connect."); 
            } 
                } 
            catch (RuntimeException $e) { 
                    print("Exception caught: $e");
            }    
    break;

    case "careLevel":
        /* Cannot have duplicate rows so we'll have to check if more than one row
        * already exists for this request
        *
        * Only one CareLeveltem_ID per CL_dlkID+lnk_ID is allowed since CareLevelItem_ID
        * is not a unique field
        */
       $query = "SELECT CareLevelItem_ID FROM CareLevel WHERE CareLevelItem_ID=$sanitisedItemID AND CL_dlkID=$sanitisedDLKID AND lnk_ID=$sanitisedLnkID";
           try {
              $result = odbc_exec($connect,$query);
              if($result){
                  $rowcount = odbc_num_rows($result);
                  // Only one row can exist with the unique above database row parameters
                  if ($rowcount >= 1) {
                      echo "Row already exists for this group/item combination with the specified Daily Link/Link parameters.";
                  } else {
                      $query = "INSERT INTO CareLevel (CareLevelItem_ID,CL_dlkID,lnk_ID) VALUES ($sanitisedItemID,$sanitisedDLKID,$sanitisedLnkID)";
                      try { 
                          $result = odbc_exec($connect,$query); 
                          if($result){ 
                              echo $sanitisedItemID;
                                  // // Get the row just created - unfortunately the table does not provide unique row IDs,
                                  // // so get the last row added
                                  // $query = "SELECT CareLevelItem_ID FROM CareLevel WHERE CareLevelItem_ID=$sanitisedItemID AND CL_dlkID=$sanitisedDLKID AND lnk_ID=$sanitisedLnkID";
                                  //  try { 
                                  //     $result = odbc_exec($connect,$query);
                                  //     if($result){
                                  //         $newestCareLevelRow = odbc_fetch_array($result);
                                  //         echo $newestCareLevelRow['CARELEVELITEM_ID'];
                                  //     } 
                                  //     else{ 
                                  //     throw new RuntimeException("Failed to connect."); 
                                  //     } 
                                  //         } 
                                  //     catch (RuntimeException $e) { 
                                  //             print("Exception caught: $e");
                                  //             //exit;
                                  //     }
                          } 
                          else{ 
                          throw new RuntimeException("Failed to connect."); 
                          } 
                              } 
                          catch (RuntimeException $e) { 
                                  print("Exception caught: $e");
                          }    
                  }
              } 
              else{ 
              throw new RuntimeException("Failed to connect."); 
              } 
                  } 
              catch (RuntimeException $e) { 
                      print("Exception caught: $e");
                      //exit;
              }
    break;

    case "comorbidity":
        $query = "INSERT INTO Co_Morbidity (com_ID,lnk_ID) VALUES ($sanitisedItemID,$sanitisedLnkID)";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
                echo $sanitisedItemID;
                    // // Get the row just created - unfortunately the table does not provide unique row IDs,
                    // // so get the last row added
                    // $query = "SELECT com_ID FROM Co_Morbidity WHERE com_ID=$sanitisedItemID AND lnk_ID=$sanitisedLnkID";
                    //  try { 
                    //     $result = odbc_exec($connect,$query);
                    //     if($result){
                    //         $newestRow = odbc_fetch_array($result);
                    //         echo $newestRow['COM_ID'];
                    //     } 
                    //     else{ 
                    //     throw new RuntimeException("Failed to connect."); 
                    //     } 
                    //         } 
                    //     catch (RuntimeException $e) { 
                    //             print("Exception caught: $e");
                    //             //exit;
                    //     }
            } 
            else{ 
            throw new RuntimeException("Failed to connect."); 
            } 
                } 
            catch (RuntimeException $e) { 
                    print("Exception caught: $e");
            }
    break;

    case "critInc":

        // --- Already in trigger --- $ID = $Mela_SQL->GetPK('Critical_Inc',false);
        $query = "INSERT INTO Critical_Inc (Itm_ID,cc_dlkID,cc_lnkID) VALUES ($sanitisedItemID,$sanitisedDLKID,$sanitisedLnkID)";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
               echo $sanitisedItemID;
                    // // Get the row just created - unfortunately the table does not provide unique row IDs <--- this one does ($ID)
                    // // so get the last row added
                    // $query = "SELECT Itm_ID FROM Critical_Inc WHERE Itm_ID=$sanitisedItemID AND cc_dlkID=$sanitisedDLKID AND cc_lnkID=$sanitisedLnkID";
                    //  try { 
                    //     $result = odbc_exec($connect,$query);
                    //     if($result){
                    //         $newestCareLevelRow = odbc_fetch_array($result);
                    //         echo $newestCareLevelRow['ITM_ID'];
                    //     } 
                    //     else{ 
                    //     throw new RuntimeException("Failed to connect."); 
                    //     } 
                    //         } 
                    //     catch (RuntimeException $e) { 
                    //             print("Exception caught: $e");
                    //             //exit;
                    //     }
            } 
            else{ 
            throw new RuntimeException("Failed to connect."); 
            } 
                } 
            catch (RuntimeException $e) { 
                    print("Exception caught: $e");
            }
    break;

    case "dailyOutcome":
        /* Cannot have duplicate rows so we'll have to check if more than one row
        * already exists for this request
        */
       $query = "SELECT DailyOutcome_ID FROM DailyOutcome WHERE DailyOutcome_ID=$sanitisedItemID AND DailyOutcome_DLnkID=$sanitisedDLKID AND DailyOutcome_LnkID=$sanitisedLnkID";
           try {
              $result = odbc_exec($connect,$query);
              if($result){
                  $rowcount = odbc_num_rows($result);
                  // Only one row can exist with the unique above database row parameters
                  if ($rowcount >= 1) {
                      echo "Row already exists for this group/item combination with the specified Daily Link/Link parameters.";
                  } else {
                      $query = "INSERT INTO DailyOutcome (DailyOutcome_ID,DailyOutcome_DLnkID,DailyOutcome_LnkID) VALUES ($sanitisedItemID,$sanitisedDLKID,$sanitisedLnkID)";
                      try { 
                          $result = odbc_exec($connect,$query); 
                          if($result){
                              echo $sanitisedItemID; 
                                  // // Get the row just created - unfortunately the table does not provide unique row IDs,
                                  // // so get the last row added
                                  // $query = "SELECT DailyOutcome_ID FROM DailyOutcome WHERE DailyOutcome_ID=$sanitisedItemID AND DailyOutcome_DLnkID=$sanitisedDLKID AND DailyOutcome_LnkID=$sanitisedLnkID";
                                  //  try { 
                                  //     $result = odbc_exec($connect,$query);
                                  //     if($result){
                                  //         $newestRow = odbc_fetch_array($result);
                                  //         echo $newestRow['DAILYOUTCOME_ID'];
                                  //     } 
                                  //     else{ 
                                  //     throw new RuntimeException("Failed to connect."); 
                                  //     } 
                                  //         } 
                                  //     catch (RuntimeException $e) { 
                                  //             print("Exception caught: $e");
                                  //             //exit;
                                  //     }
                          } 
                          else{ 
                          throw new RuntimeException("Failed to connect."); 
                          } 
                              } 
                          catch (RuntimeException $e) { 
                                  print("Exception caught: $e");
                          }    
                  }
              } 
              else{ 
              throw new RuntimeException("Failed to connect."); 
              } 
                  } 
              catch (RuntimeException $e) { 
                      print("Exception caught: $e");
                      //exit;
                }
    break;

    case "drugs":
        $query = "INSERT INTO Infection_Antibiotics (ID,antibiotics_dlkID,antibiotics_lnkID) VALUES ($sanitisedItemID,$sanitisedDLKID,$sanitisedLnkID)";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
                  echo $sanitisedItemID;
                    // // Get the row just created - unfortunately the table does not provide unique row IDs,
                    // // so get the last row added
                    // $query = "SELECT ID FROM Infection_Antibiotics WHERE ID=$sanitisedItemID AND antibiotics_dlkID=$sanitisedDLKID AND antibiotics_lnkID=$sanitisedLnkID";
                    //  try { 
                    //     $result = odbc_exec($connect,$query);
                    //     if($result){
                    //         $newestCareLevelRow = odbc_fetch_array($result);
                    //         echo $newestCareLevelRow['ID'];
                    //     } 
                    //     else{ 
                    //     throw new RuntimeException("Failed to connect."); 
                    //     } 
                    //         } 
                    //     catch (RuntimeException $e) { 
                    //             print("Exception caught: $e");
                    //             //exit;
                    //     }
            } 
            else{ 
            throw new RuntimeException("Failed to connect."); 
            } 
                } 
            catch (RuntimeException $e) { 
                    print("Exception caught: $e");
            }    
    break;

    case "interventions":
        $query = "INSERT INTO Investigations (inv_ID,inv_dlkID,inv_lnkID,Planned) VALUES ($sanitisedItemID,$sanitisedDLKID,$sanitisedLnkID,'Done')";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
                  echo $sanitisedItemID;
                    // // Get the row just created - unfortunately the table does not provide unique row IDs,
                    // // so get the last row added
                    // $query = "SELECT inv_ID FROM Investigations WHERE inv_ID=$sanitisedItemID AND inv_dlkID=$sanitisedDLKID AND inv_lnkID=$sanitisedLnkID";
                    //  try { 
                    //     $result = odbc_exec($connect,$query);
                    //     if($result){
                    //         $newestRow = odbc_fetch_array($result);
                    //         echo $newestRow['INV_ID'];
                    //     } 
                    //     else{ 
                    //     throw new RuntimeException("Failed to connect."); 
                    //     } 
                    //         } 
                    //     catch (RuntimeException $e) { 
                    //             print("Exception caught: $e");
                    //             //exit;
                    //     }
            } 
            else{ 
            throw new RuntimeException("Failed to connect."); 
            } 
                } 
            catch (RuntimeException $e) { 
                    print("Exception caught: $e");
            }
    break;

    case "medications":
      AddMedication(1);
        // $query = "INSERT INTO Medication (itm_ID,med_dlkID,med_lnkID,med_Type) VALUES ($sanitisedItemID,$sanitisedDLKID,$sanitisedLnkID,1)";
        // try { 
        //     $result = odbc_exec($connect,$query); 
        //     if($result){ 
        //             // Get the row just created - unfortunately the table does not provide unique row IDs,
        //             // so get the last row added
        //             $query = "SELECT itm_ID FROM Medication WHERE itm_ID=$sanitisedItemID AND med_dlkID=$sanitisedDLKID AND med_lnkID=$sanitisedLnkID AND med_Type=1";
        //              try { 
        //                 $result = odbc_exec($connect,$query);
        //                 if($result){
        //                     $newestRow = odbc_fetch_array($result);
        //                     echo $newestRow['ITM_ID'];
        //                 } 
        //                 else{ 
        //                 throw new RuntimeException("Failed to connect."); 
        //                 } 
        //                     } 
        //                 catch (RuntimeException $e) { 
        //                         print("Exception caught: $e");
        //                         //exit;
        //                 }
        //     } 
        //     else{ 
        //     throw new RuntimeException("Failed to connect."); 
        //     } 
        //         } 
        //     catch (RuntimeException $e) { 
        //             print("Exception caught: $e");
        //     }
    break;

    case "modalities":
        // --- Already in trigger --- $ID = $Mela_SQL->GetPK('Modality',true);
        $query = "INSERT INTO Modality (mod_ID,mod_dlkID,mod_lnkID) VALUES ($sanitisedItemID,$sanitisedDLKID,$sanitisedLnkID)";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
                    // Get ID created by 4D trigger
                    $query = "SELECT ID FROM Modality WHERE mod_ID=$sanitisedItemID AND mod_dlkID=$sanitisedDLKID AND mod_lnkID=$sanitisedLnkID";
                     try { 
                        $result = odbc_exec($connect,$query);
                        if($result){
                            $newestRow = odbc_fetch_array($result);
                            echo $newestRow['ID'];
                        } 
                        else{ 
                        throw new RuntimeException("Failed to connect."); 
                        } 
                            } 
                        catch (RuntimeException $e) { 
                                print("Exception caught: $e");
                                //exit;
                        }
            } 
            else{ 
            throw new RuntimeException("Failed to connect."); 
            } 
                } 
            catch (RuntimeException $e) { 
                    print("Exception caught: $e");
            }
    break;

    case "painAssessment":
        /* Cannot have duplicate rows so we'll have to check if more than one row
        * already exists for this request
        *
        * Only one CareLeveltem_ID per CL_dlkID+lnk_ID is allowed since CareLevelItem_ID
        * is not a unique field
        */
       $query = "SELECT CareLevelItem_ID FROM CareLevel WHERE CareLevelItem_ID=$sanitisedItemID AND CL_dlkID=$sanitisedDLKID AND lnk_ID=$sanitisedLnkID";
           try {
              $result = odbc_exec($connect,$query);
              if($result){
                  $rowcount = odbc_num_rows($result);
                  // Only one row can exist with the unique above database row parameters
                  if ($rowcount >= 1) {
                      echo "Row already exists for this group/item combination with the specified Daily Link/Link parameters.";
                  } else {
                      $query = "INSERT INTO CareLevel (CareLevelItem_ID,CL_dlkID,lnk_ID) VALUES ($sanitisedItemID,$sanitisedDLKID,$sanitisedLnkID)";
                      try { 
                          $result = odbc_exec($connect,$query); 
                          if($result){ 
                              echo $sanitisedItemID;
                                  // // Get the row just created - unfortunately the table does not provide unique row IDs,
                                  // // so get the last row added
                                  // $query = "SELECT CareLevelItem_ID FROM CareLevel WHERE CareLevelItem_ID=$sanitisedItemID AND CL_dlkID=$sanitisedDLKID AND lnk_ID=$sanitisedLnkID";
                                  //  try { 
                                  //     $result = odbc_exec($connect,$query);
                                  //     if($result){
                                  //         $newestCareLevelRow = odbc_fetch_array($result);
                                  //         echo $newestCareLevelRow['CARELEVELITEM_ID'];
                                  //     } 
                                  //     else{ 
                                  //     throw new RuntimeException("Failed to connect."); 
                                  //     } 
                                  //         } 
                                  //     catch (RuntimeException $e) { 
                                  //             print("Exception caught: $e");
                                  //             //exit;
                                  //     }
                          } 
                          else{ 
                          throw new RuntimeException("Failed to connect."); 
                          } 
                              } 
                          catch (RuntimeException $e) { 
                                  print("Exception caught: $e");
                          }    
                  }
              } 
              else{ 
              throw new RuntimeException("Failed to connect."); 
              } 
                  } 
              catch (RuntimeException $e) { 
                      print("Exception caught: $e");
                      //exit;
              }
    break;

    case "pre-medications":
        AddMedication(2);
        // $query = "INSERT INTO Medication (itm_ID,med_dlkID,med_lnkID,med_Type) VALUES ($sanitisedItemID,$sanitisedDLKID,$sanitisedLnkID,2)";
        // try { 
        //     $result = odbc_exec($connect,$query); 
        //     if($result){ 
        //             // Get the row just created - unfortunately the table does not provide unique row IDs,
        //             // so get the last row added
        //             $query = "SELECT itm_ID FROM Medication WHERE itm_ID=$sanitisedItemID AND med_dlkID=$sanitisedDLKID AND med_lnkID=$sanitisedLnkID AND med_Type=2";
        //              try { 
        //                 $result = odbc_exec($connect,$query);
        //                 if($result){
        //                     $newestRow = odbc_fetch_array($result);
        //                     echo $newestRow['ITM_ID'];
        //                 } 
        //                 else{ 
        //                 throw new RuntimeException("Failed to connect."); 
        //                 } 
        //                     } 
        //                 catch (RuntimeException $e) { 
        //                         print("Exception caught: $e");
        //                         //exit;
        //                 }
        //     } 
        //     else{ 
        //     throw new RuntimeException("Failed to connect."); 
        //     } 
        //         } 
        //     catch (RuntimeException $e) { 
        //             print("Exception caught: $e");
        //     }
    break;

    case "rec-medications":
         AddMedication(3);
        // $query = "INSERT INTO Medication (itm_ID,med_dlkID,med_lnkID,med_Type) VALUES ($sanitisedItemID,$sanitisedDLKID,$sanitisedLnkID,3)";
        // try { 
        //     $result = odbc_exec($connect,$query); 
        //     if($result){ 
        //             // Get the row just created - unfortunately the table does not provide unique row IDs,
        //             // so get the last row added
        //             $query = "SELECT itm_ID FROM Medication WHERE itm_ID=$sanitisedItemID AND med_dlkID=$sanitisedDLKID AND med_lnkID=$sanitisedLnkID AND med_Type=3";
        //              try { 
        //                 $result = odbc_exec($connect,$query);
        //                 if($result){
        //                     $newestRow = odbc_fetch_array($result);
        //                     echo $newestRow['ITM_ID'];
        //                 } 
        //                 else{ 
        //                 throw new RuntimeException("Failed to connect."); 
        //                 } 
        //                     } 
        //                 catch (RuntimeException $e) { 
        //                         print("Exception caught: $e");
        //                         //exit;
        //                 }
        //     } 
        //     else{ 
        //     throw new RuntimeException("Failed to connect."); 
        //     } 
        //         } 
        //     catch (RuntimeException $e) { 
        //             print("Exception caught: $e");
        //     }
    break;

    case "site":
        $query = "INSERT INTO Infection_Site (ID,site_dlkID,site_lnkID) VALUES ($sanitisedItemID,$sanitisedDLKID,$sanitisedLnkID)";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){
                echo $sanitisedItemID; 
                    // // Get the row just created - unfortunately the table does not provide unique row IDs,
                    // // so get the last row added
                    // $query = "SELECT ID FROM Infection_Site WHERE ID=$sanitisedItemID AND site_dlkID=$sanitisedDLKID AND site_lnkID=$sanitisedLnkID";
                    //  try { 
                    //     $result = odbc_exec($connect,$query);
                    //     if($result){
                    //         $newestCareLevelRow = odbc_fetch_array($result);
                    //         echo $newestCareLevelRow['ID'];
                    //     } 
                    //     else{ 
                    //     throw new RuntimeException("Failed to connect."); 
                    //     } 
                    //         } 
                    //     catch (RuntimeException $e) { 
                    //             print("Exception caught: $e");
                    //             //exit;
                    //     }
            } 
            else{ 
            throw new RuntimeException("Failed to connect."); 
            } 
                } 
            catch (RuntimeException $e) { 
                    print("Exception caught: $e");
            }    
    break;

    case "tasks":
        // --- Already in trigger --- $ID = $Mela_SQL->GetPK('Tasks',true);
        $query = "INSERT INTO Tasks (ItmID,DLnkID,LnkID) VALUES ($sanitisedItemID,$sanitisedDLKID,$sanitisedLnkID)";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
                echo $sanitisedItemID;
                    // // Get the row just created - unfortunately the table does not provide unique row IDs, <---- this one does ---
                    // // so get the last row added
                    // $query = "SELECT ItmID FROM Tasks WHERE ItmID=$sanitisedItemID AND DLnkID=$sanitisedDLKID AND LnkID=$sanitisedLnkID";
                    //  try { 
                    //     $result = odbc_exec($connect,$query);
                    //     if($result){
                    //         $newestRow = odbc_fetch_array($result);
                    //         echo $newestRow['ITMID'];
                    //     } 
                    //     else{ 
                    //     throw new RuntimeException("Failed to connect."); 
                    //     } 
                    //         } 
                    //     catch (RuntimeException $e) { 
                    //             print("Exception caught: $e");
                    //             //exit;
                    //     }
            } 
            else{ 
            throw new RuntimeException("Failed to connect."); 
            } 
                } 
            catch (RuntimeException $e) { 
                    print("Exception caught: $e");
            }
    break;

    case "surgery":
        $query = "INSERT INTO Surgery (srg_ID,srg_dlkID,srg_lnkID,srg_Details) VALUES ($sanitisedItemID,$sanitisedDLKID,$sanitisedLnkID,'$sanitisedSelect')";
        try { 
            $result = odbc_exec($connect,$query);
            if($result){ 
                  echo $sanitisedItemID;
                    // // Get the row just created - unfortunately the table does not provide unique row IDs,
                    // // so get the last row added
                    // $query = "SELECT srg_ID FROM Surgery WHERE srg_ID=$sanitisedItemID AND srg_dlkID=$sanitisedDLKID AND srg_lnkID=$sanitisedLnkID";
                    //  try { 
                    //     $result = odbc_exec($connect,$query);
                    //     if($result){
                    //         $newestRow = odbc_fetch_array($result);
                    //         echo $newestRow['SRG_ID'];
                    //     } 
                    //     else{ 
                    //     throw new RuntimeException("Failed to connect."); 
                    //     } 
                    //         } 
                    //     catch (RuntimeException $e) { 
                    //             print("Exception caught: $e");
                    //             //exit;
                    //     }
            } 
            else{ 
            throw new RuntimeException("Failed to connect."); 
            } 
                } 
            catch (RuntimeException $e) { 
                    print("Exception caught: $e");
            }
    break;

    case "score2door":
        $query = "INSERT INTO Sco2Door_Reason (Item_ID,Link_ID) VALUES ($sanitisedItemID,$sanitisedLnkID)";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
                echo $sanitisedItemID;
                    // // Get the row just created - unfortunately the table does not provide unique row IDs,
                    // // so get the last row added
                    // $query = "SELECT Item_ID FROM Sco2Door_Reason WHERE Item_ID=$sanitisedItemID AND Link_ID=$sanitisedLnkID";
                    //  try { 
                    //     $result = odbc_exec($connect,$query);
                    //     if($result){
                    //         $newestRow = odbc_fetch_array($result);
                    //         echo $newestRow['ITEM_ID'];
                    //     } 
                    //     else{ 
                    //     throw new RuntimeException("Failed to connect."); 
                    //     } 
                    //         } 
                    //     catch (RuntimeException $e) { 
                    //             print("Exception caught: $e");
                    //             //exit;
                    //     }
            } 
            else{ 
            throw new RuntimeException("Failed to connect."); 
            } 
                } 
            catch (RuntimeException $e) { 
                    print("Exception caught: $e");
            }
    break;

} // switch $_REQUEST['destination']
