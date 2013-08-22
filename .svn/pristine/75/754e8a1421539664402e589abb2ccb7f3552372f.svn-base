<?php
include('./MelaClass/functions.php');
include('./MelaClass/Mela_Forms.php');
include('./MelaClass/db.php');
include('./MelaClass/authInitScript.php');

if (!$_REQUEST['lnkid']) die("Necessary data is missing");

$dlkPatID = $lnkID = filter_var($_REQUEST['lnkid'], FILTER_SANITIZE_NUMBER_INT);

$query_PAT = "SELECT dmg.dmg_FirstName, dmg.dmg_Surname, dmg.dmg_DateOfBirth, dmg.dmg_Sex, dmg.dmg_NHSNumber, dmg.dmg_HospitalNumber, adm.adm_Number
		FROM Demographic dmg
		LEFT OUTER JOIN LINK lnk ON lnk.lnk_dmgID = dmg.dmg_ID
		LEFT OUTER JOIN Admission adm ON adm.adm_ID = lnk.lnk_admID
		WHERE lnk.lnk_ID = $lnkID";
try { 
    $result_PAT = odbc_exec($connect,$query_PAT); 
    if ($result_PAT) { 
	$HeaderData = odbc_fetch_array($result_PAT);
    } 
    else { 
	throw new RuntimeException("Failed to connect."); 
    } 
} 
catch (RuntimeException $e) { 
    print("Exception caught: $e");
}
    
$query = "SELECT EWSS_Alarm FROM EWSS";
try { 
    $result = odbc_exec($connect,$query); 
    if ($result) { 
	$EWSS = odbc_fetch_array($result);
    } 
    else { 
	throw new RuntimeException("Failed to connect."); 
    } 
} 
catch (RuntimeException $e) { 
    print("Exception caught: $e");
}

$query = "SELECT adms.HeartRate, adms.RespiratoryRate, adms.Temperature, adms.BloodPressure,
  adms.CNS, adms.Urine, adms.Pain, adms.O2Saturation, adms.RespSupport, adms.GCS, adms.UrineDD,
  adms.HR_Score, adms.RR_Score, adms.Temp_Score, adms.BP_Score, adms.CNS_Score, adms.Urine_Score,
  adms.Pain_Score, adms.O2Sat_Score, adms.Resp_Score, adms.GCS_Score, adms.Total_Score, adms.Score_Date,
  adms.Score_Time, adms.Action_Taken, adms.HR_CalledFor, adms.RR_CalledFor, adms.Temp_CalledFor,
  adms.BP_CalledFor, adms.CNS_CalledFor, adms.Urine_CalledFor, adms.Pain_CalledFor, adms.O2Sat_CalledFor,
  adms.Resp_CalledFor, adms.GCS_CalledFor, adms.BE, adms.BE_Score, adms.BE_CalledFor, adms.pH, adms.pH_Score,
  adms.pH_CalledFor, adms.PaO2, adms.PaO2_Score, adms.PaO2_CalledFor, adms.O2_Sup, adms.O2_Sup_Score, adms.AScore_ID,
  a.adm_ScoreID
  FROM Admission_Score adms, Admission a
  WHERE adms.AScore_ID=a.adm_ScoreID";
try { 
    $result = odbc_exec($connect,$query); 
    if ($result) { 
	$weighted = odbc_fetch_array($result);
    } 
    else { 
	throw new RuntimeException("Failed to connect."); 
    } 
} 
catch (RuntimeException $e) { 
    print("Exception caught: $e");
} //echo $query;

if ($_POST) {
    // If there is post data then save it
    // Since most form values save/auto-update due to 4D trigger calculation,
    // we're only really saving called for and date/time
    $checkBoxes = array('heartRateChk' => 'HR_CalledFor',
			'respRateChk' => 'RR_CalledFor',
			'temperatureChk' => 'Temp_CalledFor',
			'sysBPChk' => 'BP_CalledFor',
			'AVPUChk' => 'CNS_CalledFor',
			'UrineChk' => 'Urine_CalledFor',
			'PainChk' => 'Pain_CalledFor',
			'O2SatChk' => 'O2Sat_CalledFor',
			'respSupportChk' => 'Resp_CalledFor',
			'GCSChk' => 'GCS_CalledFor',
			'baseExcessChk' => 'BE_CalledFor',
			'pHChk' => 'pH_CalledFor',
			'pAO2Chk' => 'PaO2_CalledFor');
    
    $query = "UPDATE Admission_Score SET Score_Date='".$_POST['triggerDate']."', Score_Time='".$_POST['triggerTime']."', Action_Taken='".$_POST['ActionTaken']."'";
    
    foreach($checkBoxes as $key => $val) {
	if (!empty($_POST[$key])) {
	    $query .= ", $val=true";
	} else {
	    $query .=", $val=false";
	}
    }
    
    $query .= " WHERE AScore_ID=".$weighted['ADM_SCOREID']."";
    try { 
	$result = odbc_exec($connect,$query); 
	if ($result) { 
	    ?>
	    <input type='hidden' id='triggerScore' value='<?php echo $_POST['MEWSTotal']; ?>'>
	    <script>
		var triggerScore = document.getElementById('triggerScore').value;
		//console.debug(triggerScore);
		window.opener.document.getElementById('adm-myScoreOnREF').value= new Number(triggerScore);
		window.close();
	    </script>
	    <?php
	} 
	else { 
	    throw new RuntimeException("Failed to connect."); 
	} 
    } 
    catch (RuntimeException $e) { 
	print("Exception caught: $e");
    }
}
?>




<!DOCTYPE html>
    <html lang="en">
        <head>

        <link type="text/css" rel="stylesheet" href="media/css/normalize.css"/>
        <link type="text/css" rel="stylesheet" href="media/css/jquery-ui.css"/>
	    <link type="text/css" rel="stylesheet" href="media/css/ListingStyle.css">    
	    <link type="text/css" rel="stylesheet" href="media/css/style.css"/>		
	    <link type="text/css" rel="stylesheet" href="media/css/jquery%20css.css"/>
	    <link type="text/css" rel="stylesheet" href="media/css/styleTabs.css">

	    <script src="media/js/jquery-1.10.0.min.js"></script>
	    <script src="media/js/jquery-ui-1.10.3.min.js"></script>
		<script src="media/js/sisyphus.min.js"></script>


	    <script src="media/js/jquery.validate.min.js"></script>
		<script src="media/js/jquery.tablesorter.min.js"></script>
		<script src="media/js/jquery.ui.labeledslider.js"></script>
		<script src="media/js/jsDate.js"></script>
		<script src="media/js/jquery.validate.min.js"></script>
		<script src="media/js/jquery-impromptu.js"></script>

		<script src="media/js/jquery-ui.js"></script>



	    
	    <script>
		$(document).ready(function() {
		    function initialise() {
			var lnkID = $('#hiddenLNKID').val();
			$.ajax({
			    type: "POST",
			    url: "SQL_AdmSco_CondAdd.php",
			    data: "lnkid=" + lnkID,
			    async: true, // This is async because the 4D SQL method needs to be called before anything else in case an ID is not present
			    success: function(msg){
			    },
			    error: function(XMLHttpRequest, textStatus, errorThrown) {
				 rowID = 'Invalid';
				 alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
			    } 
			});
		    }
		    
		    function calculateMEWS(ID) {
			// ID is lnk ID
			$.ajax({
			    type: "POST",
			    url: "calculateMEWS.php",
			    data: "page=ADM&id=" + ID,
			    async: false,
			    success: function(msg){
				updateScores(msg);
			    },
			    error: function(XMLHttpRequest, textStatus, errorThrown) {
				 rowID = 'Invalid';
				 alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
			    } 
			});
		    }
		    
		    function updateScore(field) {
			// Save an individual field when it is updated
			//alert("Triggered it with this field: " + field);
			// Get value from field
			var fieldVal = $('#' + field).val();
			var lnkid = $('#hiddenLNKID').val();
			var ascoreid = $('#ascoreid').val();
			//alert("Field's val is " + fieldVal);
			$.ajax({
			    type: "POST",
			    url: "saveFirstTriggerField.php",
			    data: "field=" + field + "&val=" + fieldVal + "&ascoreid=" + ascoreid,
			    async: false,
			    success: function(msg){
				calculateMEWS(lnkid);
			    },
			    error: function(XMLHttpRequest, textStatus, errorThrown) {
				 rowID = 'Invalid';
				 alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
			    } 
			});
		    }
		    
		    function updateScores(msg) {
			// Accepts return tab separated value from calculateMEWS and updates fields accordingly
			var ValsArr = msg.split('	');
			
			$('#MEWSTotal').val(ValsArr[0]);
			$('#heartRateWeighted').val(ValsArr[1]);
			$('#respRateWeighted').val(ValsArr[2]);
			$('#temperatureWeighted').val(ValsArr[3]);
			$('#sysBPWeighted').val(ValsArr[4]);
			$('#AVPUWeighted').val(ValsArr[5]);
			$('#urineWeighted').val(ValsArr[6]);
			$('#painWeighted').val(ValsArr[7]);
			$('#O2SatWeighted').val(ValsArr[8]);
			$('#respSupportWeighted').val(ValsArr[9]);
			$('#GCSWeighted').val(ValsArr[10]);
			$('#baseExcessWeighted').val(ValsArr[11]);
			$('#pHWeighted').val(ValsArr[12]);
			$('#pAO2Weighted').val(ValsArr[13]);
			
		    }
		    
		    function changeTab(tabIndex) {
			$("#tabs").tabs( "option", "active", tabIndex );
		    }
		    
		    initialise();
		    $("#tabs").tabs();
		    $('#testbutton').click(function() {
			var lnk = $('#hiddenLNKID').val();
			calculateMEWS(lnk);
		    });
		    
		    $('#cancelButton').click(function() {
			window.close();
		    });
		    
		    $('#tabPhysiological').click(function() {
			changeTab(0);
		    });
		    
		    $('#tabQuestions').click(function() {
			changeTab(1);
		    });
		    
		    $('.editable').change(function() {
			var fieldName = $(this).attr('id');
			updateScore(fieldName);
		    });
		    
		    $.validator.setDefaults({
			ignore: ""
		    });
		    
		    var submitted = true;
		    
		    $.validator.addMethod("noFutureDates", function(value, element) {
			// Check that the date given is not in the future
			var myDate = value;
			return Date.parse(myDate) <= new Date();
		    }, "Date cannot be in the future");	
		    
		    $("#mews_form").validate({
			errorLabelContainer: ".validationErrorBox",
			wrapper: "li",
			showErrors: function(errorMap, errorList) {
			    if (submitted) {
				if (errorList) {
				    var summary = "Form errors: \n";
				    $.each(errorList, function() { summary +="\n"; });
				    $(".validationErrorBox").show().text(summary);
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
			    "triggerDate": "noFutureDates"
			},
			 messages: {
			    "triggerDate": "Date cannot be in the future"
			},
			highlight: function(element) {
			    $(element).closest('.control-group').removeClass('success').addClass('error');
			},
			success: function(element) {
			    $(element).removeClass('error');
			    $(element).remove();
			}
		    });
            

			$('.cssmenu ul li a').click(function() {
				$('.cssmenu ul li a.active_pat_tab').removeClass('active_pat_tab');
				$(this).closest('.cssmenu ul li a').addClass('active_pat_tab');
			});

			$('.cssmenu ul li ul li.tabsub a').click(function() {
				$('.cssmenu ul li a.active_pat_tab').removeClass('active_pat_tab');
				$(this).parents('ul').parents('li').find('a').addClass('active_pat_tab');
			});




		});
	    </script>
	</head>
	<body>
	    <?php	    
	    $Form = new Mela_Forms('editMEWS','','POST','mews_form');
	    echo $Form->hiddenField('hiddenLNKID',$lnkID);
	    echo $Form->hiddenField('ascoreid',$weighted['ASCORE_ID']);
	    // CSS class specifically used to select only user editable fields
	    $editable = array("editable");
	    ?>
	    <div class="container clearfix">

            <div class="Header_List">
                <ul id="Head_Left" class="grid_3 alpha">
                    <li><?php echo $HeaderData['DMG_FIRSTNAME']; ?></li> 
                    <li><?php echo $HeaderData['DMG_SURNAME']; ?></li>
                </ul>
                <ul id="Head_Mid" class="grid_3">
                    <li>
                        <table class="Tab_Mid">
                            <tr><td class="Table_Mid">Sex&nbsp;</td><td class="Table_Mid"><?php echo $HeaderData['DMG_SEX']; ?></td></tr>
                            <tr><td class="Table_Mid">DOB&nbsp;</td><td class="Table_Mid"><?php $splitDOB = explode(' ',$HeaderData['DMG_DATEOFBIRTH']); echo $splitDOB[0]; ?></td></tr>
                        </table>
                    </li>
                </ul>
                <ul id="Head_Right" class="grid_3 omega">
                    <li>
                        <table>
                            <tr><td class="Table_Right">NHS No&nbsp;</td><td class="Table_Right"><?php echo $HeaderData['DMG_NHSNUMBER']; ?></td></tr>
                            <tr><td class="Table_Right">Hospital No&nbsp;</td><td class="Table_Right"><?php echo $HeaderData['DMG_HOSPITALNUMBER']; ?></td></tr>
                            <tr><td class="Table_Right">Referral No&nbsp;</td><td class="Table_Right"><?php echo $HeaderData['ADM_NUMBER']; ?></td></tr>
                        </table>
                    </li>
                </ul>
            </div>
	    
		    <div id="tabs2" class="btn_bar">
				<button style="font-size: small; color: red;" type="button" name="vsHTMCancelButt" id="cancelButton" value="Cancel" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
				<span class="ui-button-text">Cancel</span>
				</button>

				<button style="font-size: small; color: green;" type="submit" name="vsHTMSaveButt" value="Save" onclick="submitButton()" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
				<span class="ui-button-text">Save</span>
				</button>

				<?php
				    echo "Date: ".$Form->dateField('triggerDate',stringToDateTime($weighted['SCORE_DATE'],2));
				    echo " Time: ".$Form->timeField('triggerTime',convert4DTime($weighted['SCORE_TIME']));
				?>
		    </div>
	    
	    <div class="validationErrorBox" style="display:none;">
		<!-- Necessary for displaying any form validation errors - leave blank, jQuery fills this in -->
	    </div>
	    

	    <div id="tabs">
			<ul style="display:none;">
			    <li><a href="#page-1"><span>Assess Details</span></a></li>
			    <li><a href="#page-2"><span>Pain Assessment</span></a></li>
			</ul>

		    <div class="cssmenu">
		    	<ul>
				    <li class='tabs_item' id='tabPhysiological'><a href='#page-1' class='active_pat_tab'><span>Physiological</span></a></li>
				    <li class='tabs_item' id='tabQuestions'><a href='#page-2'><span>Questions</span></a></li>
				</ul>
		    </div>



		<div style="clear: both;"></div>    
    
		<!-- Phys -->
		<div id="page-1"> 
			<table>
			    <tr>
				<td>
				<table class='temp'>
				    <thead>
					<tr>
					    <th>
						&nbsp;
					    </th>
					    <th>
						Physiological values
					    </th>
					    <th>
						Weighted score
					    </th>
					    <th>
						Called For
					    </th>
					</tr>
				    </thead>
				    <tbody>
					<?php //if ($weighted['HR_CALLEDFOR']) ?>
					<tr>
					    <td>
						Heart Rate
					    </td>
					    <td>
						<?php
						    $heartRate = $Form->textBox('heartRate',$weighted['HEARTRATE'],'',0,$editable);
						    print $heartRate;
						?>
					    </td>
					    <td>
						<?php
						    $heartRateWeighted = $Form->textBox('heartRateWeighted',$weighted['HR_SCORE'],'',1);
						    print $heartRateWeighted;
						?>
					    </td>
					    <td>
						<?php
						    $heartRateChk = $Form->checkBox('heartRateChk','heartRateChk','',$weighted['HR_CALLEDFOR']);
						    echo $heartRateChk;
						?>
					    </td>
					</tr>
					<tr>
					    <td>
						Respiratory Rate
					    </td>
					    <td>
						<?php
						    $respRate = $Form->textBox('respRate',$weighted['RESPIRATORYRATE'],'',0,$editable);
						    print $respRate;
						?>    
					    </td>
					    <td>
						<?php
						    $respRateWeighted = $Form->textBox('respRateWeighted',$weighted['RR_SCORE'],'',1);
						    print $respRateWeighted;
						?>
					    </td>
					    <td>
						<?php
						    $respRateChk = $Form->checkBox('respRateChk','respRateChk','',$weighted['RR_CALLEDFOR']);
						    echo $respRateChk;
						?>    
					    </td>
					</tr>
					<tr>
					    <td>
						Temperature
					    </td>
					    <td>
						<?php
						    $temperature = $Form->textBox('temperature',$weighted['TEMPERATURE'],'',0,$editable);
						    print $temperature;
						?>
					    </td>
					    <td>
						<?php
						    $temperatureWeighted = $Form->textBox('temperatureWeighted',$weighted['TEMP_SCORE'],'',1);
						    print $temperatureWeighted;
						?>
					    </td>
					    <td>
						<?php
						    $temperatureChk = $Form->checkBox('temperatureChk','temperatureChk','',$weighted['TEMP_CALLEDFOR']);
						    echo $temperatureChk;
						?>    
					    </td>
					</tr>
					<tr>
					    <td>
						Blood Pressure
					    </td>
					    <td>
						<?php
						    $sysBP = $Form->textBox('BloodPressure',$weighted['BLOODPRESSURE'],'',0,$editable);
						    print $sysBP;
						?>
					    </td>
					    <td>
						<?php
						    $sysBPWeighted = $Form->textBox('sysBPWeighted',$weighted['BP_SCORE'],'',1);
						    print $sysBPWeighted;
						?>
					    </td>
					    <td>
						<?php
						    $sysBPChk = $Form->checkBox('sysBPChk','sysBPChk','',$weighted['BP_CALLEDFOR']);
						    echo $sysBPChk;
						?>    
					    </td>
					</tr>
					<tr>
					    <td>
						AVPU
					    </td>
					    <td>
						<?php
						    /*$AVPU = $Form->textBox('AVPU',$MEWS['PAT_AVPU']);
						    print $AVPU;*/
						    $AVPUDDSQL = $Mela_SQL->tbl_LoadItems('AVPU');
						    $AVPUDDArray = array();
						    for ($i = 1; $i < (count($AVPUDDSQL)+1); $i++) {
							array_push($AVPUDDArray,$AVPUDDSQL[$i]['Long_Name']);
						    }
			    
						    $AVPUDD = $Form->dropDown('CNS',$AVPUDDArray,$AVPUDDArray,$weighted['CNS'],'editable');
						    echo $AVPUDD;
						?>    
					    </td>
					    <td>
						<?php
						    $AVPUWeighted = $Form->textBox('AVPUWeighted',$weighted['CNS_SCORE'],'',1);
						    print $AVPUWeighted;
						?>
					    </td>
					    <td>
						<?php
						    $AVPUChk = $Form->checkBox('AVPUChk','AVPUChk','',$weighted['CNS_CALLEDFOR']);
						    echo $AVPUChk;
						?>    
					    </td>
					</tr>
					<tr>
					    <td>
						Urine
					    </td>
					    <td>
						<?php
						    $UrineDDSQL = $Mela_SQL->tbl_LoadItems('Urine');
						    $UrineDDArray = array();
						    for ($i = 1; $i < (count($UrineDDSQL)+1); $i++) {
							array_push($UrineDDArray,$UrineDDSQL[$i]['Long_Name']);
						    }
			    
						    $UrineDD = $Form->dropDown('UrineDD',$UrineDDArray,$UrineDDArray,$weighted['URINEDD'],'editable');
						    echo $UrineDD;
						?>  
					    </td>
					    <td>
						<?php 
						    $urineWeighted = $Form->textBox('urineWeighted',$weighted['URINE_SCORE'],'',1);
						    print $urineWeighted;
						?>
					    </td>
					    <td>
						<?php
						    $urineChk = $Form->checkBox('UrineChk','UrineChk','',$weighted['URINE_CALLEDFOR']);
						    echo $urineChk;
						?>    
					    </td>
					</tr>
					<tr>
					    <td>
						Pain
					    </td>
					    <td>
						<?php
						    $PainDDSQL = $Mela_SQL->tbl_LoadItems('PAIN');
						    $PainDDArray = array();
						    for ($i = 1; $i < (count($PainDDSQL)+1); $i++) {
							array_push($PainDDArray,$PainDDSQL[$i]['Long_Name']);
						    }
			    
						    $PainDD = $Form->dropDown('Pain',$PainDDArray,$PainDDArray,$weighted['PAIN'],'editable');
						    echo $PainDD;
						?>    
					    </td>
					    <td>
						<?php
						    $painWeighted = $Form->textBox('painWeighted',$weighted['PAIN_SCORE'],'',1);
						    print $painWeighted;
						?>
					    </td>
					    <td>
						<?php
						    $painChk = $Form->checkBox('PainChk','PainChk','',$weighted['PAIN_CALLEDFOR']);
						    echo $painChk;
						?>    
					    </td>
					</tr>
					<tr>
					    <td>
						O2 Saturation
					    </td>
					    <td>
						<?php
						    $O2Sat = $Form->textBox('O2Sat',$weighted['O2SATURATION'],'',0,$editable);
						    print $O2Sat;
						?>    
					    </td>
					    <td>
						<?php
						    $O2SatWeighted = $Form->textBox('O2SatWeighted',$weighted['O2SAT_SCORE'],'',1);
						    print $O2SatWeighted;
						?>
					    </td>
					    <td>
						<?php
						    $O2SatChk = $Form->checkBox('O2SatChk','O2SatChk','',$weighted['O2SAT_CALLEDFOR']);
						    echo $O2SatChk;
						?>    
					    </td>
					</tr>
					<tr>
					    <td>
						Resp. Support
					    </td>
					    <td>
						<?php
						    $RespSupportDDSQL = $Mela_SQL->tbl_LoadItems('Respiratory Support');
						    $RespSupportDDArray = array();
						    for ($i = 1; $i < (count($RespSupportDDSQL)+1); $i++) {
							array_push($RespSupportDDArray,$RespSupportDDSQL[$i]['Long_Name']);
						    }
			    
						    $RespSupportDD = $Form->dropDown('RespSupport',$RespSupportDDArray,$RespSupportDDArray,$weighted['RESPSUPPORT'],'editable');
						    echo $RespSupportDD;
						?> 
					    </td>
					    <td>
						<?php
						    $respSupportWeighted = $Form->textBox('respSupportWeighted',$weighted['RESP_SCORE'],'',1);
						    print $respSupportWeighted;
						?>
					    </td>
					    <td>
						<?php
						    $respSupportChk = $Form->checkBox('respSupportChk','respSupportChk','',$weighted['RESP_CALLEDFOR']);
						    echo $respSupportChk;
						?>    
					    </td>
					</tr>
					<tr>
					    <td>
						GCS
					    </td>
					    <td>
						<?php
						    $GCS = $Form->textBox('GCS',$weighted['GCS'],'',0,$editable);
						    print $GCS;
						?>    
					    </td>
					    <td>
						<?php
						    $GCSWeighted = $Form->textBox('GCSWeighted',$weighted['GCS_SCORE'],'',1);
						    print $GCSWeighted;
						?>
					    </td>
					    <td>
						<?php
						    $GCSChk = $Form->checkBox('GCSChk','GCSChk','',$weighted['GCS_CALLEDFOR']);
						    echo $GCSChk;
						?>     
					    </td>
					</tr>
					<tr>
					    <td>
						Base Excess
					    </td>
					    <td>
						<?php
						    $baseExcess = $Form->textBox('BE',$weighted['BE'],'',0,$editable);
						    print $baseExcess;
						?>    
					    </td>
					    <td>
						<?php
						    $baseExcessWeighted = $Form->textBox('baseExcessWeighted',$weighted['BE_SCORE'],'',1);
						    print $baseExcessWeighted;
						?>
					    </td>
					    <td>
						<?php
						    $baseExcessChk = $Form->checkBox('baseExcessChk','baseExcessChk','',$weighted['BE_CALLEDFOR']);
						    echo $baseExcessChk;
						?>    
					    </td>
					</tr>
					<tr>
					    <td>
						pH
					    </td>
					    <td>
						<?php
						    $pH = $Form->textBox('pH',$weighted['PH'],'',0,$editable);
						    print $pH;
						?>    
					    </td>
					    <td>
						<?php
						    $pHWeighted = $Form->textBox('pHWeighted',$weighted['PH_SCORE'],'',1);
						    print $pHWeighted;
						?>
					    </td>
					    <td>
						<?php
						    $pHChk = $Form->checkBox('pHChk','pHChk','',$weighted['PH_CALLEDFOR']);
						    echo $pHChk;
						?>    
					    </td>
					</tr>
					<tr>
					    <td>
						PaO2
					    </td>
					    <td>
						<?php
						    $pAO2 = $Form->textBox('pAO2',$weighted['PAO2'],'',0,$editable);
						    print $pAO2;
						?>    
					    </td>
					    <td style="border-bottom: 1px solid black;">
						<?php
						    $pAO2Weighted = $Form->textBox('pAO2Weighted',$weighted['PAO2_SCORE'],'',1);
						    print $pAO2Weighted;
						?>
					    </td>
					    <td>
						<?php
						    $pAO2Chk = $Form->checkBox('pAO2Chk','pAO2Chk','',$weighted['PAO2_CALLEDFOR']);
						    echo $pAO2Chk;
						?>    
					    </td>
					</tr>
					<tr>
					    <td>
						Trigger score
					    </td>
					    <td>
						<?php
						    $EWSSAlarm = $Form->textBox('EWSSAlarm',$EWSS['EWSS_ALARM']);
						    print $EWSSAlarm;
						?>    
					    </td>
					    <td>
						<?php
						    $MEWS_Total = $Form->textBox('MEWSTotal','',2);
						    print "Total: ".$MEWS_Total;
						?>
					    </td>
					</tr>
				    </tbody>
				</table>
				
				<!--<div id="MEWSTrig">
				    Hello
				</div>-->
				
				<?php
				    $actionTakenDDSQL = $Mela_SQL->tbl_LoadItems('Action Taken On First Trigger');
				    $actionTakenDDArray = array();
				    for ($i = 1; $i < (count($actionTakenDDSQL)+1); $i++) {
					array_push($actionTakenDDArray,$actionTakenDDSQL[$i]['Long_Name']);
				    }
	    
				    $actionTakenDD = $Form->dropDown('ActionTaken',$actionTakenDDArray,$actionTakenDDArray,$weighted['ACTION_TAKEN']);
				    echo "Action Taken: ".$actionTakenDD;
				?> 
				</td>
			    </tr>
			</table>
		</div>  <!-- Phys -->


		<!-- Questions -->
		<div id="page-2"> 
			<table>
			    <tr>
				<td>
				    <table class="temp">
					<thead>
					    <tr>
						<th>
						    Group
						</th>
						<th>
						    Answer
						</th>
						<th>
						    Question
						</th>
					    </tr>
					</thead>
					<tbody>
					<?php					
					$sql = "SELECT AdmQuest_Question, AdmQuest_Answer, AdmQuest_CalledFor
					        FROM Admission_Score_Questions
						WHERE AdmQuest_lnkID = $lnkID";
					try { 
					    $result = odbc_exec($connect,$sql); 
					    if ($result) {
						while ($admScore = odbc_fetch_array($result)) {
						    //var_dump($admScore);
						    print "<tr>
								<td>
								    ???
								</td>
								<td>
								    ".$admScore['AdmQuest_Answer']."
								</td>
								<td>
								    ".$admScore['AdmQuest_Question']."
								</td>
							   </tr>"; 
						}
					    } 
					    else { 
						throw new RuntimeException("Failed to connect."); 
					    } 
					} 
					catch (RuntimeException $e) { 
					    print("Exception caught: $e");
					}
					?>
					</tbody>
				    </table>
				</td>
			    </tr>
			</table>      
		</div>  <!-- Questions -->
	    </div>
	    </div>
	</body>
    </html>