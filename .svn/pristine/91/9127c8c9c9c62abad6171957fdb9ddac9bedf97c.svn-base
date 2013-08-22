<script language="JavaScript" type="text/javascript">
 function CloseAndRefresh() 
    {
        opener.surgeryIframe.location.reload();
        self.close();
    }
</script>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include './MelaClass/functions.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

// Need post data for this
if (!$_POST || !$_REQUEST) die("No task data specified");

/*
 * Currently simply copied over from surgeryPopup because I don't know what fields the task edit window
 * contains
 */ 
switch ($_REQUEST['action']) {
    default:
        $operationID = $_POST['operationID'];
        $lnkID = $_POST['lnkID'];
        $opr_query="SELECT * FROM OPER_PatOperations WHERE OPER_ID=$operationID AND OPER_lnkID=$lnkID";
        
                    try { 
                          $result = odbc_exec($connect,$opr_query); 
                    if($result){ 
                            $operationData = odbc_fetch_array($result);
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
        <form name="editSurgery" action="?action=edit" method="POST">
        <input type="hidden" name="lnkID" value="<?php echo $lnkID; ?>">
        <input type="hidden" name="operationID" value="<?php echo $operationID; ?>">
            <fieldset style="width:95%;">
                        <legend>
                            Selected record
                        </legend>
                        
                        <table class="temp" cellpadding="5">
                            <tr>
                                <td>
                                    
                                </td>
                            </tr>
                        </table>

                    <input type="submit" value="Save" onClick="return CloseAndRefresh()">
            </fieldset>
        </form>
        <?php
    break;

    case "edit":
    
    $ana1 = $_POST['anaesthetist1'];
    $ana2 = $_POST['anaesthetist2'];
    $date = dateToString($_POST['date']);
    $classification = $_POST['classification'];
    $incision = $_POST['incisionSite'];
    $surgerytype = $_POST['typeOfSurgery'];
    $outcome = $_POST['outcome'];
    $technique = $_POST['technique'];
    $notes = $_POST['surgeryNotes'];
    $operationID = $_POST['operationID'];
    $lnkID = $_POST['lnkID'];
    
    //print_r($_POST);        
    
    //$sql = "UPDATE OPER_PatOperations SET Anea1=$ana1, Anea2=$ana2, OPER_Date='$date', OPER_Classification='$classification', IncisionType='$incision', Type='$surgerytype', Outcome='$outcome', Technique='$technique', OPER_Comments='$notes' WHERE OPER_ID=$operationID AND OPER_lnkID=$lnkID";
    //$sql = "UPDATE OPER_PatOperations SET IncisionType='1' WHERE OPER_ID=$operationID";
    try { 
        $update = odbc_exec($connect,$sql) or die(odbc_errormsg());
        
        header("Location: surgeryframe.php?lnkID=$lnkID");
        } 
        catch (RuntimeException $e) { 
                print("Exception caught: $e");
                exit;
        }  
        
    break;
}*/
?>