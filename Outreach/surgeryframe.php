<?php
include './MelaClass/db.php';
$surgeryLNKID = filter_var($_REQUEST['lnkID'], FILTER_SANITIZE_NUMBER_INT);
?>  
<!--     <fieldset style="width:95%;"> -->
        <!--<form action="surgeryEdit.php" method="post" target="_blank">-->
        <form action="surgeryEdit.php" method="post">
        <input type="hidden" name="lnkID" value="<?php echo $surgeryLNKID; ?>">
        <select size="7" name="operationID" style="width: 100%;">
            <?php
            $opr_query="SELECT po.OPER_lnkID, po.OPER_ID, oc.Oper_Code, oc.Oper_Title, oc.Oper_Name
            FROM OPER_PatOperations po
            LEFT OUTER JOIN OPER_Codes oc ON po.OPER_ID = oc.Oper_ID
            LEFT OUTER JOIN LINK l ON po.OPER_lnkID = l.lnk_ID
            WHERE po.OPER_lnkID = $surgeryLNKID";

            try { 
                  $result = odbc_exec($connect,$opr_query); 
            if($result){ 
                    while ($oper = odbc_fetch_array($result)) {
                        echo "<option value='".$oper['OPER_ID']."'>
                                ".$oper['OPER_NAME']."
                            </option>";    
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
?>


        </select>
        <br />
        <input type="submit" value="View/edit selected operation">
        
<!--     </fieldset> -->
            </form>



 





