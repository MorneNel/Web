<link type="text/css" rel="stylesheet" href="media/css/normalize.css"/>
<link type="text/css" rel="stylesheet" href="media/css/style.css"/>
<link type="text/css" rel="stylesheet" href="media/css/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="media/css/surgery.css"/>
<link type="text/css" rel="stylesheet" href="media/css/GI_Style_real.css"/>
<link type="text/css" rel="stylesheet" href="media/css/Header_style.css">
    
<script src="media/js/jquery-1.10.0.min.js"></script>
<script src="media/js/closeEditPages.js"></script>
<script src="media/js/jquery.validate.min.js"></script>
<script type="text/javascript">    
    $(document).ready(function() {
        function resetField(field) {
		//$(field).val('');
		//$(field + ' option:eq(0)').attr('selected','selected');
		//$($field).attr('selected');
		//$('#' + field + ' option[value=""]').attr('selected', true);
		$(field).get(0).selectedIndex = 0;
	}
            
        $('.resetButton').click(function() {
                    var data = $(this).data();
                    var target = data['target'];
                    resetField(target);
        });
	
	$.validator.addMethod("noFutureDates", function(value, element) {
	    // Check that the date given is not in the future
	    var myDate = value;
	    return Date.parse(myDate) <= new Date();
	}, "Date cannot be in the future");
        
        $.validator.addMethod("notEmpty", function(value, element) {
	    // Check that the data is not empty
	    if (value.length > 0) {
                return value;
            } else return false;
	}, "Data cannot be empty");
        
        var submitted = false;
	    
        $("#surgeryEdit_form").validate({
            errorLabelContainer: ".validationErrorBox",
            wrapper: "li",
            showErrors: function(errorMap, errorList) {
                if (submitted) {
                    if (errorList) {
                        var summary = "Form errors: \n";
                        //$.each(errorList, function() { summary += " * " + this.message + "\n"; });
                        //$(".validationErrorBox").show().text(summary);
                        //$.each(errorList, function() { summary +="\n"; });
                        //$(".validationErrorBox").show().text(summary);
                        submitted = false;	
                    } else {
                        $(".validationErrorBox").hide().val('');    
                    }
                    
                }
                this.defaultShowErrors();
            },          
            invalidHandler: function(form, validator) {
                var submitted = true;
            },
            rules: {
                "date": "noFutureDates",
                "anaesthetist1": "notEmpty"
            },
             messages: {
                "date": "Date set cannot be blank or in the future",
                "anaesthetist1": "Anaesthetist 1 cannot be empty"
            },
            highlight: function(element) {
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            success: function(element) {
                $(element).removeClass('error');
                $(element).remove();
            }
        });
        
        $.validator.setDefaults({
	    ignore: ""
	});
    });
</script>
<?php
/*
 * Edit page for OPCS surgery
 */ 




error_reporting(E_ALL ^ E_NOTICE);
include './MelaClass/functions.php';
include './MelaClass/Mela_Forms.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

// Need post data for this
//if (!$_POST || !$_REQUEST) die("No operation data specified");

// $preferences['OPCS_Outcome'];



if (!$_POST) {
$Form = new Mela_Forms('surgeryEdit','','POST','surgeryEdit_form');

        $operationID = filter_var($_REQUEST['row'], FILTER_SANITIZE_NUMBER_INT);
        $lnkID = filter_var($_REQUEST['lnk'], FILTER_SANITIZE_NUMBER_INT);
        $opr_query="SELECT Oper_Code, DATE_TO_CHAR(OPER_Date,'yyyy-Mm-Dd') AS OPER_DATE, OPER_Comments, OPER_Classification,
		    Anea1, Anea2, Type, IncisionType, Technique, Outcome
		    FROM OPER_PatOperations
		    WHERE OPER_ID=$operationID AND OPER_lnkID=$lnkID";
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
        



    $patquery = "SELECT  d.dmg_FirstName, d.dmg_Surname, d.dmg_DateOfBirth, d.dmg_Sex, d.dmg_NHSNumber, d.dmg_HospitalNumber,  a.adm_Number 
            FROM Demographic d
            LEFT OUTER JOIN LINK l ON d.dmg_ID = l.lnk_dmgID
            LEFT OUTER JOIN Admission a ON a.adm_ID = l.lnk_admID
            WHERE l.lnk_ID=$lnkID";


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
            <!-- <a href="surgeryframe.php?lnkID=<?php echo $lnkID; ?>"><button type="button">Go back</button></a> -->
            <button style="font-size: small; color: red;" type="button" value="Cancel" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" onclick="self.close()">
            <span class="ui-button-text">Cancel</span>
            </button>

            <button style="font-size: small; color: green;" type="submit" value="Save" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
            <span class="ui-button-text">Save</span>
            </button>
        </div>
	
	<div class="validationErrorBox" style="display:none;">
            <!-- Necessary for displaying any form validation errors - leave blank, jQuery fills this in -->
        </div>

            
    <div class="dataContainer">



        <form name="editSurgery" action="?action=edit" method="POST">
        <input type="hidden" name="lnkID" value="<?php echo $lnkID; ?>">
        <input type="hidden" name="operationID" value="<?php echo $operationID; ?>">

                        <table class="Surgery_Table temp">
                            <tr>
                                <td>Anaesthetist 1</td>
                                <td>
                                    <?php $anaesthetist1 = $Mela_SQL->getAnaesthetistDropdown('anaesthetist1','',$operationData['ANEA1']); echo $anaesthetist1; ?>
                                    <button style="font-size: small;" type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only resetbutton" data-target='#anaesthetist1'>
                                    <span class="ui-button-text">Reset</span>
                                    </button>
                                </td>

                                <td>Anaesthetist 2</td>
                                <td>
                                    <?php $anaesthetist2 = $Mela_SQL->getAnaesthetistDropdown('anaesthetist2','',$operationData['ANEA2']); echo $anaesthetist2; ?>
                                    <button style="font-size: small;" type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only resetbutton" data-target='#anaesthetist2'>
                                    <span class="ui-button-text">Reset</span>
                                    </button>
                                </td>
                            </tr>



                            <tr>
                                <td>Date</td>
                                <td><input type="date" class="FormField" name="date" size="6" value="<?php echo stringToDateTime($operationData['OPER_DATE'],2); ?>"></td>

                                <td>Classification</td>
                                <td>
                                    <?php
                                        $srgClassificationDDSQL = $Mela_SQL->tbl_LoadItems('Surgery Classification');
                                        $srgClassificationDDArray = array();
                                        for ($i = 1; $i < (count($srgClassificationDDSQL)+1); $i++) {
                                            array_push($srgClassificationDDArray,$srgClassificationDDSQL[$i]['Long_Name']);
                                        }
                            
                                        $srgClassificationDD = $Form->dropDown('classification',$srgClassificationDDArray,$srgClassificationDDArray,$operationData['OPER_CLASSIFICATION']);
                                        echo $srgClassificationDD;                           
                                    ?>
                                </td>
                            </tr>


                            <tr>
                                <td>Incision site</td>
                                <td>
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
                                <td>Type of Surgery</td>
                                <td>
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

			    
                            <tr>
                                <td>Technique</td>
                                <td>
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
				<?php if ($preferences['OPCS_Outcome'] == 'true') { ?>
                                <td>Outcome</td>
                                <td>
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
                            </tr>
                        </table>
                        


            <div class="OPCS_footer">
                <br />
                <label id="surgLabel">Surgery notes</label><br />
                <textarea class="surgTextArea" name="surgeryNotes"><?php echo $operationData['OPER_COMMENTS']; ?></textarea>
                <br />
            </div>



        </form>
    </div>
</div>



        <?php
    } else {
    
    $ana1 = $_POST['anaesthetist1'];
    $operationID = $_POST['operationID'];
    $lnkID = $_POST['lnkID'];
    
    $srgAnea2SQL = "";
    if (isset($_POST['anaesthetist2']) && strlen($_POST['anaesthetist2']) != 0) {
        $anea2 = filter_var($_POST['anaesthetist2'], FILTER_SANITIZE_NUMBER_INT);
	$srgAnea2SQL = "Anea2=".$anea2.",";
    }
    
    $srgDateSQL = "";
    if (isset($_POST['surgDate']) && strlen($surgeryDate) != 0) {
	$surgeryDate = dateToString($_POST['date']);
        $srgDateSQL = "OPER_Date='".dateToString($surgeryDate)."',";
    }
    
    $srgClassificationSQL = "";
    if (strlen($_POST['classification']) != 0) {
        $classification = filter_var($_POST['classification'], FILTER_SANITIZE_STRING);
	$srgClassificationSQL = "OPER_Classification='".$classification."',";
    }
    
    $srgIncisionTypeSQL = "";
    if (isset($_POST['incisionSite']) && strlen($_POST['incisionSite']) != 0) {
        $incisionType = filter_var($_POST['incisionSite'], FILTER_SANITIZE_STRING);
        $srgIncisionTypeSQL = "IncisionType='$incisionType',";
    }
    
    $srgTypeSQL= "";    
    if (isset($_POST['typeOfSurgery']) && strlen($_POST['typeOfSurgery']) != 0) {
        $type = filter_var($_POST['typeOfSurgery'], FILTER_SANITIZE_STRING);
        $srgTypeSQL = "`Type`='$type',";
    }
    
    $srgOutcomeSQL = "";
    if (isset($_POST['outcome']) && strlen($_POST['outcome']) != 0) {
        $outcome = filter_var($_POST['outcome'], FILTER_SANITIZE_STRING);
        $srgOutcomeSQL = "Outcome='$outcome',";
    }
    
    $srgTechniqueSQL = "";
    if (isset($_POST['technique']) && strlen($_POST['technique']) != 0) {
        $technique = filter_var($_POST['technique'], FILTER_SANITIZE_STRING);
        $srgTechniqueSQL = "Technique='$technique',";
    }
    
    $srgNotesSQL = "";
    if (isset($_POST['surgeryNotes']) && strlen($_POST['surgeryNotes']) != 0) {
        $notes = filter_var($_POST['surgeryNotes'], FILTER_SANITIZE_STRING);
        $srgNotesSQL = "OPER_Comments='$notes',";
    }
    
    $sql = "UPDATE OPER_PatOperations SET $srgAnea2SQL $srgDateSQL $srgClassificationSQL $srgIncisionTypeSQL $srgTypeSQL
	    $srgOutcomeSQL $srgTechniqueSQL $srgNotesSQL Anea1=$ana1 WHERE OPER_ID=$operationID AND OPER_lnkID=$lnkID";
    //$sql = "UPDATE OPER_PatOperations SET IncisionType='1' WHERE OPER_ID=$operationID";
    echo $sql;
    try { 
        $result = odbc_exec($connect,$sql);
        if ($result) { 
            ?>
            <script type="text/javascript">
                CloseAndRefresh(); 
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
?>