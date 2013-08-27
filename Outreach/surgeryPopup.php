<link type="text/css" rel="stylesheet" href="media/css/normalize.css"/>
<link type="text/css" rel="stylesheet" href="media/css/style.css"/>
<link type="text/css" rel="stylesheet" href="media/css/jquery-ui.css">
<link type="text/css" rel="stylesheet" href="media/css/surgery.css"/>
<link type="text/css" rel="stylesheet" href="media/css/GI_Style_real.css"/>
<link type="text/css" rel="stylesheet" href="media/css/Header_style.css">
<link type="text/css" rel="stylesheet" href="media/css/jquery-impromptu.css"/>
    
<script src="media/js/jquery-1.10.0.min.js"></script>
<script src="media/js/closeEditPages.js"></script>
<script src="media/js/jquery.validate.min.js"></script>

<script language="JavaScript" type="text/javascript">
 function CloseAndRefresh() 
    {
	var code = $('#hiddenCode').val();
	var operID = $('#hiddenOPERID').val();
	var operName = $('#hiddenOPERName').val();
	var tr = $('<tr>'
		    + '<td class="cat">&nbsp; &nbsp;' + code + '</td>' 
		    + '<td class="sel">&nbsp; ' + operName + '</td>'
		    + '<td id="Button_cell"><button id="' + operID + '" type="button" data-page="OPCSSurgery" class="editRow ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" style="line-height: normal; height: 28px; width: 39px;"><img src="Media/img/pencil.gif" alt="Edit"/></button></td>'
		    + '<td id="Button_cell"><button id="' + operID + '" type="button" data-page="OPCS" class="deleteRow ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" style="line-height: normal; height: 28px; width: 39px;"><img src="Media/img/bin.gif" alt="Delete"/></button></td>'
		    + '</tr>');
	$('#OPER > tbody:last', window.opener.document).one().append(tr);
        self.close();
    }
    
    $(document).ready(function() {
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
	    
        $("#surgeryAdd_form").validate({
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
include './MelaClass/functions.php';
include './MelaClass/Mela_Forms.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

$Form = new Mela_Forms('surgeryAdd','','POST','surgeryAdd_form');

if (!$_REQUEST['lnkid']) die ("No lnk ID has been specified");
if (!$_REQUEST['code']) die("No code has been specified");

$LNKID = filter_var($_REQUEST['lnkid'], FILTER_SANITIZE_NUMBER_INT);

$hiddenCode = $Form->hiddenField('hiddenCode',$_REQUEST['code']);
echo $hiddenCode;


    $patquery = "SELECT  d.dmg_FirstName, d.dmg_Surname, d.dmg_DateOfBirth, d.dmg_Sex, d.dmg_NHSNumber, d.dmg_HospitalNumber,  a.adm_Number 
            FROM Demographic d
            LEFT OUTER JOIN LINK l ON d.dmg_ID = l.lnk_dmgID
            LEFT OUTER JOIN Admission a ON a.adm_ID = l.lnk_admID
            WHERE l.lnk_ID=$LNKID";


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






if ($_POST) {
    $surgeryFields = array('anaesthetist1','anaesthetist2','date','classification','incisionSite','typeOfSurgery','outcome','technique','surgeryNotes');
    
    // Form sanitisation
    for ($i = 0; $i < count($surgeryFields); $i++) {
    $_POST[$surgeryFields[$i]] = checkValues($_POST[$surgeryFields[$i]]);
        //print "$surgeryFields[$i] - ".$_POST[$surgeryFields[$i]]." <br />";
    }
    
    $surgeryCode = stripslashes_deep(checkValues(soft_Clean($_REQUEST['code'])));
    $anea1 = $_POST[$surgeryFields[0]];
    $anea2 = $_POST[$surgeryFields[1]];
    $surgeryDate = $_POST[$surgeryFields[2]];
    $classification = $_POST[$surgeryFields[3]];
    $incision = $_POST[$surgeryFields[4]];
    $surgeryType = $_POST[$surgeryFields[5]];
    $outcome = $_POST[$surgeryFields[6]];
    $technique = $_POST[$surgeryFields[7]];
    $notes = $_POST[$surgeryFields[8]];
    
    $srgAnea2SQL = "";
    $srgAnea2 = "";
    if (isset($_POST[$surgeryFields[1]]) && strlen($_POST[$surgeryFields[1]]) != 0) {
        $anea2 = filter_var($_POST[$surgeryFields[1]], FILTER_SANITIZE_NUMBER_INT);
	$srgAnea2SQL = "".$anea2.",";
	$srgAnea2 = "Anea2,";
    }
    
    // get details from OPER_Codes based on $surgeryCode
    $OCodequery = "SELECT Oper_ID, Oper_Title, Oper_Name
        FROM OPER_Codes
        WHERE Oper_Code='$surgeryCode' AND".$Mela_SQL->sqlHUMinMax("Oper_ID");

        try { 
              $OCoderesult = odbc_exec($connect,$OCodequery); 
        if($OCoderesult){ 
                $OCode = odbc_fetch_array($OCoderesult);
        } 
        else{ 
        throw new RuntimeException("Failed to connect."); 
        } 
            } 
        catch (RuntimeException $e) { 
            print("Exception caught: $e");
        }
        
    $operID = $OCode['OPER_ID'];    
    


    //print "<h1>".$OCode['OPER_ID']." - ".$OCode['OPER_TITLE']." - ".$OCode['OPER_NAME']."</h1>";
    //var_dump($_POST);
    $opr_updQuery = "INSERT INTO OPER_PatOperations (OPER_lnkID, OPER_ID, Oper_Code, Anea1, $srgAnea2 OPER_Date, OPER_Classification, IncisionType, `Type`, Outcome, Technique, OPER_Comments)
     VALUES ($LNKID, $operID, '$surgeryCode', $anea1, $srgAnea2SQL '$surgeryDate', '$classification', '$incision', '$surgeryType', '$outcome', '$technique','$notes')";
    //echo "update query is ".$opr_updQuery;
    /*
     * This updates the wrong table
     *$opr_updQuery = "INSERT INTO Surgery (srg_lnkID, Oper_Code, Anea1, Anea2, OPER_Date, OPER_Classification, IncisionType, Type, Outcome, Technique, OPER_Comments)
     VALUES ($LNKID,'$surgeryCode', $anea1, $anea2, '$surgeryDate', '$classification', '$incision', '$surgeryType', '$outcome', '$technique','$notes')";*/
    $opr_update = odbc_prepare($connect, $opr_updQuery);
    $opr_updResult = odbc_execute($opr_update) or die(odbc_errormsg());
    
    
    $hiddenOperID = $Form->hiddenField('hiddenOPERID',$operID);
    echo $hiddenOperID;
    $hiddenOperName = $Form->hiddenField('hiddenOPERName',$OCode['OPER_NAME']);
    echo $hiddenOperName;
?>
<script type="text/javascript">
    CloseAndRefresh();
</script>

<?php } else { ?>

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


<!-- <input type="submit" value="Add New Procedure" > -->
        <div id="tabs2" class="btn_bar">
            <button style="font-size: small; color: red;" type="button" value="Cancel" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false" onclick="self.close()">
            <span class="ui-button-text">Cancel</span>
            </button>

            <button style="font-size: small; color: green;" type="submit" value="Save" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
            <span class="ui-button-text">Save</span>
            </button>
        </div>
        
        <div class="validationErrorBox" style="display:none;">
            <!-- Necessary for displaying any form validation errors - leave blank, jQuery fills this in -->
        </div>


<!-- searchBtn -->



    <div class="dataContainer">



            <table class="Surgery_Table temp">
                <tr>
                    <td>Anaesthetist 1</td>
                    <td>
                        <?php $anaesthetist1 = $Mela_SQL->getAnaesthetistDropdown('anaesthetist1',''); echo $anaesthetist1; ?>
                        <button style="font-size: small;" type="reset" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
                        <span class="ui-button-text">Reset</span>
                        </button>
                    </td>

                    <td>Anaesthetist 2</td>
                    <td><?php $anaesthetist2 = $Mela_SQL->getAnaesthetistDropdown('anaesthetist2',''); echo $anaesthetist2; ?>
                        <button style="font-size: small;" type="reset" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
                        <span class="ui-button-text">Reset</span>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>
                        <?php
                        echo $Form->dateField('date');
                        ?>
                    </td>
                    <td>Classification</td>
                    <td>
                        <?php
                        $srgClassificationDDSQL = $Mela_SQL->tbl_LoadItems('Surgery Classification');
                        $srgClassificationDDArray = array();
                        for ($i = 1; $i < (count($srgClassificationDDSQL)+1); $i++) {
                            array_push($srgClassificationDDArray,$srgClassificationDDSQL[$i]['Long_Name']);
                        }
                    
                        $srgClassificationDD = $Form->dropDown('classification',$srgClassificationDDArray,$srgClassificationDDArray);
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
                    
                        $srgIncisionDD = $Form->dropDown('incisionSite',$srgIncisionDDArray,$srgIncisionDDArray);
                        echo $srgIncisionDD;                         
                        ?>
                    </td>
                    <td>Type of Surgery</td>
                    <td>
                        <?php
                            $srgTypeDDSQL = $Mela_SQL->tbl_LoadItems('Type Of Surgery');
                            $srgTypeDDArray = array();
                            for ($i = 1; $i < (count($srgTypeDDSQL)+1); $i++) {
                            array_push($srgTypeDDArray,$srgTypeDDSQL[$i]['Long_Name']);
                            }
                    
                            $srgTypeDD = $Form->dropDown('typeOfSurgery',$srgTypeDDArray,$srgTypeDDArray);
                            echo $srgTypeDD;                             
                        ?>   
                    </td>
                </tr>
                <tr> 
                    <td>Outcome</td>
                    <td>
                        <?php
                            $srgOutcomeDDSQL = $Mela_SQL->tbl_LoadItems('Surgery Outcome');
                            $srgOutcomeDDArray = array();
                            for ($i = 1; $i < (count($srgOutcomeDDSQL)+1); $i++) {
                            array_push($srgOutcomeDDArray,$srgOutcomeDDSQL[$i]['Long_Name']);
                            }
                    
                            $srgOutcomeDD = $Form->dropDown('outcome',$srgOutcomeDDArray,$srgOutcomeDDArray);
                            echo $srgOutcomeDD;                             
                        ?>
                    </td>
                    <td>Technique</td>
                    <td>
                        <?php
                            $srgTechniqueDDSQL = $Mela_SQL->tbl_LoadItems('Technique');
                            $srgTechniqueDDArray = array();
                            for ($i = 1; $i < (count($srgTechniqueDDSQL)+1); $i++) {
                            array_push($srgTechniqueDDArray,$srgTechniqueDDSQL[$i]['Long_Name']);
                            }
                    
                            $srgTechniqueDD = $Form->dropDown('technique',$srgTechniqueDDArray,$srgTechniqueDDArray);
                            echo $srgTechniqueDD;
                            //echo "The 4D code points to a 'Technique' row in Table_Lists which does not exist and I can find no approximation";
                        ?>
                    </td>
                </tr>
            </table>
            


<!--        <b>Surgery notes</b>
            <br />
            <textarea class="FormBlock" name="surgeryNotes" rows="8" cols="50"></textarea>
            <br /> -->
            
            <div class="OPCS_footer">
                <br />
                <label id="surgLabel">Surgery notes</label><br />
                <textarea class="surgTextArea" name="surgeryNotes"></textarea>
<!--                 <?php
                    $srgNotes = $Form->textArea('surgeryNotes',$notes,'','','','');
                    echo $srgNotes;
                ?> -->
                <br />
                
            </div>



<!--             </form> -->


    </div>
</div>



<?php } ?>


