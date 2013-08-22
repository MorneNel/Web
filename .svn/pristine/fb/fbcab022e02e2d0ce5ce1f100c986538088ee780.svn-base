<link type="text/css" rel="stylesheet" href="media/css/normalize.css"/>
<link type="text/css" rel="stylesheet" href="media/css/style.css"/>
<link type="text/css" rel="stylesheet" href="media/css/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="media/css/tablesorterStyle.css"/>
<link type="text/css" rel="stylesheet" href="media/css/surgery.css"/>
<link type="text/css" rel="stylesheet" href="media/css/GI_Style_real.css"/>
<link type="text/css" rel="stylesheet" href="media/css/Header_style.css">
    
<script src="media/js/jquery-1.10.0.min.js"></script>
<script src="media/js/closeEditPages.js"></script>
<script>
    function resetField(field) {
        $(field).val('');
        console.debug(field);
        //alert("Hi " + field);
    }
</script>

<?php
include './MelaClass/functions.php';
include './MelaClass/Mela_Forms.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

$Form = new Mela_Forms('editSurgery','','POST','surgery_form');

if (!$_REQUEST['lnk'] || !$_REQUEST['row']) die("Vital information missing");

$dlk = ($_REQUEST['dlk']) ? filter_var($_REQUEST['dlk'], FILTER_SANITIZE_NUMBER_INT) : 0;
$lnk = filter_var($_REQUEST['lnk'], FILTER_SANITIZE_NUMBER_INT);
$row = filter_var($_REQUEST['row'], FILTER_SANITIZE_NUMBER_INT);

$query = "SELECT srg.srg_SurgeryDate, srg.srg_SurgeryTime, srg.srg_Details, srg.srg_Notes, srg.srg_Description,
          srg.Anea1, srg.Anea2, srg.Type, srg.IncisionType, srg.Technique, srg.Outcome, srg.srg_SurgeryMode, 
          itm.Description
          FROM Surgery srg
          LEFT OUTER JOIN Items_Surg itm ON srg.srg_ID = itm.ID
          WHERE srg.srg_ID=$row AND srg.srg_lnkID=$lnk";
    try { 
        $result = odbc_exec($connect,$query); 
            if($result){ 
                $operationData = odbc_fetch_array($result);
            } 
            else{ 
                throw new RuntimeException("Failed to connect."); 
            } 
        } 
    catch (RuntimeException $e) { 
        print("Exception caught: $e");
    }


$patquery = "SELECT  d.dmg_FirstName, d.dmg_Surname, d.dmg_DateOfBirth, d.dmg_Sex, d.dmg_NHSNumber, d.dmg_HospitalNumber,  a.adm_Number 
        FROM Demographic d
        LEFT OUTER JOIN LINK l ON d.dmg_ID = l.lnk_dmgID
        LEFT OUTER JOIN Admission a ON a.adm_ID = l.lnk_admID
        WHERE l.lnk_ID=$lnk";


    try { 
        $patresult = odbc_exec($connect,$patquery); 
            if($patresult){ 
                $PatData = odbc_fetch_array($patresult);
            } 
            else{ 
                throw new RuntimeException("Failed to connect."); 
            } 
        }
    catch (RuntimeException $e) { 
        print("Exception caught: $e");
    }

    if($patresult){ 
        $patresult = odbc_fetch_array($patresult);
        global $patresult;    
}    


$hiddenRow = $Form->hiddenField('row',$row);
$hiddenDLK = $Form->hiddenField('dlk',$dlk);
$hiddenLNK = $Form->hiddenField('lnk',$lnk);

echo $hiddenRow;
echo $hiddenDLK;
echo $hiddenLNK;

if (!$_POST) {    
    ?>


        <div class="container clearfix">

            <div class="Header_List">
                <ul id="Head_Left" class="grid_3 alpha">
                    <li><?php echo $PatData['DMG_FIRSTNAME']; ?></li> 
                    <li><?php echo $PatData['DMG_SURNAME']; ?></li>
                </ul>
                <ul id="Head_Mid" class="grid_3">
                    <li>
                        <table class="Tab_Mid">
                            <tr><td class="Table_Mid">Sex&nbsp;</td><td class="Table_Mid"><?php echo $PatData['DMG_SEX']; ?></td></tr>
                            <tr><td class="Table_Mid">DOB&nbsp;</td><td class="Table_Mid"><?php $splitDOB = explode(' ',$PatData['DMG_DATEOFBIRTH']); echo $splitDOB[0]; ?></td></tr>
                        </table>
                    </li>
                </ul>
                <ul id="Head_Right" class="grid_3 omega">
                    <li>
                        <table>
                            <tr><td class="Table_Right">NHS No&nbsp;</td><td class="Table_Right"><?php echo $PatData['DMG_NHSNUMBER']; ?></td></tr>
                            <tr><td class="Table_Right">Hospital No&nbsp;</td><td class="Table_Right"><?php echo $PatData['DMG_HOSPITALNUMBER']; ?></td></tr>
                            <tr><td class="Table_Right">Referral No&nbsp;</td><td class="Table_Right"><?php echo $PatData['ADM_NUMBER']; ?></td></tr>
                        </table>
                    </li>
                </ul>
            </div>



                <div id="tabs2" class="btn_bar">
                    <button style="font-size:small;color:red" type="button"  value="Cancel" onclick="CloseAndRefresh()" href=>Cancel</button>
                    <button style="font-size:small;color:green" type="submit" value="Save">Save</button>
                    <!-- <input type="submit" value="Save"> -->
                    <!-- Form submission success -->
                    <div id="success" style="display: none;">
                        Success
                    </div>
                </div>


        <div class="dataContainer">


            <table class="OPCS_Contain_Table temp">
                            <tr>
                                <td colspan="4">Anaesthetist 1</td>
                                <td colspan="6">
                                    <?php
                                        $anaesthetist1 = $Mela_SQL->getAnaesthetistDropdown('anaesthetist1','',$operationData['ANEA1']);
                                        echo $anaesthetist1;
                                    ?>
                                    <input type="reset" onclick="resetField('#anaesthetist1');">
                                </td>
                                <td colspan="4">Anaesthetist 2</td>
                                <td colspan="6">
                                    <?php
                                        $anaesthetist2 = $Mela_SQL->getAnaesthetistDropdown('anaesthetist2','',$operationData['ANEA2']);
                                        echo $anaesthetist2;
                                    ?>
                                    <input type="reset" onclick="resetField('#anaesthetist2');">
                                </td>
                            </tr>


                            <tr>
                                <td colspan="4">
                                    <?php
                                    if ($appName == "AcutePain") {
                                        echo "Date";
                                    } else {
                                        echo "Date/Time";
                                    }
                                    ?>
                                </td>
                                <td colspan="6">
                                    <?php
                                        $surgDate = $Form->dateField('surgDate',stringToDateTime($operationData['SRG_SURGERYDATE'],2));
                                        echo $surgDate;
                                        
                                        if ($appName == "Outreach") {                        
                                            $surgTime = $Form->timeField('surgTime',convert4DTime($operationData['SRG_SURGERYTIME']));
                                            echo $surgTime;
                                        }
                                    ?>
                                </td>
                                <td colspan="4">Classification</td>
                                <td colspan="6">
                                    <?php
                                        $srgClassificationDDSQL = $Mela_SQL->tbl_LoadItems('Surgery Classification');
                                        $srgClassificationDDArray = array();
                                        for ($i = 1; $i < (count($srgClassificationDDSQL)+1); $i++) {
                                            array_push($srgClassificationDDArray,$srgClassificationDDSQL[$i]['Long_Name']);
                                        }
                            
                                        $srgClassificationDD = $Form->dropDown('classification',$srgClassificationDDArray,$srgClassificationDDArray,$operationData['SRG_SURGERYMODE']);
                                        echo $srgClassificationDD;                           
                                    ?>
                                </td>
                            </tr>

                            <?php if ($appName == "AcutePain") { ?>
                            <tr>
                                <td colspan="4">Incision site</td>
                                <td colspan="6">
                                    <?php
                                        $srgIncisionDDSQL = $Mela_SQL->tbl_LoadItems('Incision Site');
                                        $srgIncisionDDArray = array();
                                        for ($i = 1; $i < (count($srgIncisionDDSQL)+1); $i++) {
                                            array_push($srgIncisionDDArray,$srgIncisionDDSQL[$i]['Long_Name']);
                                        }
                            
                                        $srgIncisionDD = $Form->dropDown('incisionSite',$srgIncisionDDArray,$srgIncisionDDArray,$operationData['INCISIONTYPE']);
                                        echo $srgIncisionDD;                         
                                    ?>
                                </td>
        
                                <td colspan="4">Type of Surgery</td>
                                <td colspan="6">
                                    <?php
                                        $srgIncisionDDSQL = $Mela_SQL->tbl_LoadItems('Type Of Surgery');
                                        $srgIncisionDDArray = array();
                                        for ($i = 1; $i < (count($srgIncisionDDSQL)+1); $i++) {
                                            array_push($srgIncisionDDArray,$srgIncisionDDSQL[$i]['Long_Name']);
                                        }
                            
                                        $srgIncisionDD = $Form->dropDown('typeOfSurgery',$srgIncisionDDArray,$srgIncisionDDArray,$operationData['TYPE']);
                                        echo $srgIncisionDD;                         
                                    ?>
                                </td>
                            </tr>
                            <?php } ?>


                            <?php if ($appName == "AcutePain") { ?>
                            <tr>
                                <?php if ($preferences['OPCS_Outcome'] == 'true') { ?>
                                <td colspan="4">Outcome</td>
                                <td colspan="6">
                                    <?php
                                        $srgOutcomeDDSQL = $Mela_SQL->tbl_LoadItems('Surgery Outcome');
                                        $srgOutcomeDDArray = array();
                                        for ($i = 1; $i < (count($srgOutcomeDDSQL)+1); $i++) {
                                            array_push($srgOutcomeDDArray,$srgOutcomeDDSQL[$i]['Long_Name']);
                                        }
                            
                                        $srgOutcomeDD = $Form->dropDown('outcome',$srgOutcomeDDArray,$srgOutcomeDDArray,$operationData['OUTCOME']);
                                        echo $srgOutcomeDD;                             
                                    ?>
                                </td>
                                <?php } ?>
                                <td colspan="4">Technique</td>
                                <td colspan="6">
                                    <?php
                                        $srgTechniqueDDSQL = $Mela_SQL->tbl_LoadItems('Technique');
                                        $srgTechniqueDDArray = array();
                                        for ($i = 1; $i < (count($srgTechniqueDDSQL)+1); $i++) {
                                            array_push($srgTechniqueDDArray,$srgTechniqueDDSQL[$i]['Long_Name']);
                                        }
                            
                                        $srgTechniqueDD = $Form->dropDown('technique',$srgTechniqueDDArray,$srgTechniqueDDArray,$operationData['TECHNIQUE']);
                                        echo $srgTechniqueDD;                             
                                    ?>
                                </td>
                            </tr>
                            <?php } ?>
            </table>
             

            <div class="OPCS_footer">
                <br />
                <label id="surgLabel">Surgery notes</label><br />
                <?php
                    $srgNotes = $Form->textArea('surgeryNotes',$operationData['SRG_NOTES'],'','','','surgTextArea');
                    echo $srgNotes;
                ?>
                <br />
                
            </div>

        </div>    

    </div>






<?php
} else {
    $rowID = filter_var($_POST['row'], FILTER_SANITIZE_NUMBER_INT);
    $dlkID = filter_var($_POST['dlk'], FILTER_SANITIZE_NUMBER_INT);
    $lnkID = filter_var($_POST['lnk'], FILTER_SANITIZE_NUMBER_INT);
    $surgeryDate = $_POST['surgDate'];
    $surgeryTime = $_POST['surgTime'];
    $anea1 = filter_var($_POST['anaesthetist1'], FILTER_SANITIZE_NUMBER_INT);
    $anea2 = filter_var($_POST['anaesthetist2'], FILTER_SANITIZE_NUMBER_INT);
    $type = filter_var($_POST['typeOfSurgery'], FILTER_SANITIZE_STRING);
    $incisionType = filter_var($_POST['incisionSite'], FILTER_SANITIZE_STRING);
    $classification = filter_var($_POST['classification'], FILTER_SANITIZE_STRING);
    $technique = filter_var($_POST['technique'], FILTER_SANITIZE_STRING);
    $outcome = filter_var($_POST['outcome'], FILTER_SANITIZE_STRING);
    $notes = filter_var($_POST['surgeryNotes'], FILTER_SANITIZE_STRING);
    
    $srgDateSQL = "";
    if (strlen($surgeryDate) != 0) {
          $srgDateSQL = "srg_SurgeryDate='".$surgeryDate."',";
    }
    
    $srgTimeSQL = "";
    if (strlen($surgeryTime) != 0) {
          $srgTimeSQL = "srg_SurgeryTime='".$surgeryTime."',";
    }
    $hiddenNotes = $Form->hiddenField('hiddenNotes',$notes);
    echo $hiddenNotes;
    //var_dump($_POST);
    
    $query = "UPDATE Surgery SET $srgDateSQL $srgTimeSQL Anea1=$anea1, Anea2=$anea2, `Type`='$type',
              IncisionType='$incisionType', Technique='$technique', Outcome='$outcome', srg_Notes='$notes', srg_SurgeryMode='$classification',
              srg_Details='".$operationData['DESCRIPTION']."'
              WHERE srg_ID=$rowID AND srg_lnkID=$lnkID";
    try { 
        $result = odbc_exec($connect,$query); echo $query;
        if($result){ 
            ?>
            <script type="text/javascript">
                CloseAndRefresh('row','hiddenNotes','sunotes'); 
            </script>
            <?php
        } 
        else{ 
        throw new RuntimeException("Failed to connect."); 
        } 
            } 
        catch (RuntimeException $e) { 
            print("Exception caught: $e");
        }
}