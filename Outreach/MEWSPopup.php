<?php

include('./MelaClass/functions.php');
include('./MelaClass/Mela_Forms.php');
include('./MelaClass/db.php');
include('./MelaClass/authInitScript.php');

if (!$_REQUEST['dlk_patID'] || !$_REQUEST['dlk_MEWSID'] || !$_REQUEST['lnkid']) die("Necessary data is missing");

$dlkPatID = filter_var($_REQUEST['dlk_patID'], FILTER_SANITIZE_NUMBER_INT);
$dlkMEWS_ID = filter_var($_REQUEST['dlk_MEWSID'], FILTER_SANITIZE_NUMBER_INT);
$lnkID = filter_var($_REQUEST['lnkid'], FILTER_SANITIZE_NUMBER_INT);


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

$query = "SELECT pat_HeartRate, pat_RespiratoryRate, pat_Temperature, pat_Systolic_BP, pat_AVPU, pat_UrineDD,
          pat_Pain, pat_O2Saturation, pat_GCS, pat_Base_Excess, pat_PH, pat_PaO2, pat_EWSSFDDCI  
          FROM PhyAssess_AtTime
          WHERE pat_ID=$dlkPatID";
try { 
    $result = odbc_exec($connect,$query); 
    if ($result) { 
	$MEWS = odbc_fetch_array($result);
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

$query = "SELECT MEWS_HR, MEWS_RR, MEWS_Temp, MEWS_BP, MEWS_CNS, MEWS_Urine, MEWS_Pain, MEWS_O2, MEWS_Resp,
          MEWS_GCS, MEWS_BE, MEWS_pH, MEWS_PaO2
          FROM PhyAssess_MEWS
          WHERE MEWS_ID=$dlkMEWS_ID";
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
}

$Form = new Mela_Forms('editMEWS','','POST','mews_form');
// CSS class for weighted textboxes
$weightedCSS = array("weighted newsScore");
echo $Form->hiddenField('user',$auth->UsrKeys->Username);
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



	    <script>
		$(document).ready(function() {
		    function calculateMEWS(ID) {
			var user = $('#user').val();
			$.ajax({
			    type: "POST",
			    url: "calculateMEWS.php",
			    data: "page=PHYS&id=" + ID + "&user=" + user,
			    async: false,
			    success: function(msg){
				//$('#testdiv').text(msg);
				updateScores(msg);
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
			$('#MEWSTrig').text(ValsArr[1]);
			$('#heartRateWeighted').val(ValsArr[2]);
			$('#respRateWeighted').val(ValsArr[3]);
			$('#temperatureWeighted').val(ValsArr[4]);
			$('#sysBPWeighted').val(ValsArr[5]);
			$('#AVPUWeighted').val(ValsArr[6]);
			$('#urineWeighted').val(ValsArr[7]);
			$('#painWeighted').val(ValsArr[8]);
			$('#O2SatWeighted').val(ValsArr[9]);
			$('#respSupportWeighted').val(ValsArr[10]);
			$('#GCSWeighted').val(ValsArr[11]);
			$('#baseExcessWeighted').val(ValsArr[12]);
			$('#pHWeighted').val(ValsArr[13]);
			$('#pAO2Weighted').val(ValsArr[14]);
			
			window.opener.$('#phys-EWSSScore').val(ValsArr[0]);
			
		    }
		    
		    function run() {
			var dlk = $('#hiddenDLK').val();
			calculateMEWS(dlk);
		    }
		    
		    $('#cancelButton').click(function() {
			window.close();
		    });
		    
		    $('#testbutton').click(function() {
			var data = $(this).data();
			var dlk = data['id'];
			calculateMEWS(dlk);
		    });
		    
		    function changeTab(tabIndex) {
			$("#tabs").tabs( "option", "active", tabIndex );
		    }
		    
		    $('#tabPhysiological').click(function() {
			changeTab(0);
		    });
		    
		    $('#tabQuestions').click(function() {
			changeTab(1);
		    });
		    
		    run();
		    $("#tabs").tabs();
		    
		    
		    /*$('.weighted').change(function() {
			
		    });*/

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
	    <?php echo $Form->hiddenField('hiddenDLK',$dlkPatID); ?>
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
	    </div>
	    
	    <div class="validationErrorBox" style="display:none;">
		<!-- Necessary for displaying any form validation errors - leave blank, jQuery fills this in -->
	    </div>
	    

 	    <div id="tabs">
			<ul style="display:none;">
			    <li><a href="#page-1"><span>Physiological</span></a></li>
			    <li><a href="#page-2"><span>Questions</span></a></li>
			</ul>

		    <div class="cssmenu">
		    	<ul>
				    <li class='tabs_item' id='tabPhysiological'><a href='#page-1' class='active_pat_tab'><span>Physiological</span></a></li>
				    <li class='tabs_item' id='tabQuestions'><a href='#page-2' class='tab_sub'><span>Questions</span></a></li>
				</ul>
		    </div>



			<div style="clear: both;"></div>    
    
			<!-- Phys -->
			<div id="page-1"> 
			    <table class='temp MEWSTable'>

				    <tr>
						<td>&nbsp;</td>
						<td>Physiology</td>
						<td>Score</td>
				    </tr>

				    <tr>
						<td>Heart Rate</td>
						<td>
						    <?php
						    $mewsClass =array('mewsField');
							$heartRate = $Form->textBox('heartRate',$MEWS['PAT_HEARTRATE'],'',0,$mewsClass);
							print $heartRate;
						    ?>
						</td>
						<td>
						    <?php
							$heartRateWeighted = $Form->textBox('heartRateWeighted',$weighted['MEWS_HR'],'',1,$weightedCSS);
							print $heartRateWeighted;
						    ?>
						</td>
				    </tr>
				    <tr>
						<td>Respiratory Rate</td>
						<td>
						    <?php
							$respRate = $Form->textBox('respRate',$MEWS['PAT_RESPIRATORYRATE'],'',0,$mewsClass);
							print $respRate;
						    ?>    
						</td>
						<td>
						    <?php
							$respRateWeighted = $Form->textBox('respRateWeighted',$weighted['MEWS_RR'],'',1,$weightedCSS);
							print $respRateWeighted;
						    ?>
						</td>
				    </tr>
				    <tr>
						<td>Temperature</td>
						<td>
						    <?php
							$temperature = $Form->textBox('temperature',$MEWS['PAT_TEMPERATURE'],'',0,$mewsClass);
							print $temperature;
						    ?>
						</td>
						<td>
						    <?php
							$temperatureWeighted = $Form->textBox('temperatureWeighted',$weighted['MEWS_TEMP'],'',1,$weightedCSS);
							print $temperatureWeighted;
						    ?>
						</td>
				    </tr>
				    <tr>
						<td>Blood Pressure</td>
						<td>
						    <?php
							$sysBP = $Form->textBox('sysBP',$MEWS['PAT_SYSTOLIC_BP'],'',0,$mewsClass);
							print $sysBP;
						    ?>
						</td>
						<td>
						    <?php
							$sysBPWeighted = $Form->textBox('sysBPWeighted',$weighted['MEWS_BP'],'',1,$weightedCSS);
							print $sysBPWeighted;
						    ?>
						</td>
				    </tr>
				    <tr>
						<td>AVPU</td>
						<td>
						    <?php
							$AVPU = $Form->textBox('AVPU',$MEWS['PAT_AVPU'],'',0,$mewsClass);
							print $AVPU;
						    ?>    
						</td>
						<td>
						    <?php
							$AVPUWeighted = $Form->textBox('AVPUWeighted',$weighted['MEWS_CNS'],'',1,$weightedCSS);
							print $AVPUWeighted;
						    ?>
						</td>
				    </tr>
				    <tr>
						<td>Urine</td>
						<td>
						    <?php
							$urine = $Form->textBox('Urine',$MEWS['PAT_URINEDD'],'',0,$mewsClass);
							print $urine;
						    ?>  
						</td>
						<td>
						    <?php
							$urineWeighted = $Form->textBox('urineWeighted',$weighted['MEWS_URINE'],'',1,$weightedCSS);
							print $urineWeighted;
						    ?>
						</td>
				    </tr>
				    <tr>
						<td>Pain</td>
						<td>
						    <?php
							$pain = $Form->textBox('Pain',$MEWS['PAT_PAIN'],'',0,$mewsClass);
							print $pain;
						    ?>    
						</td>
						<td>
						    <?php
							$painWeighted = $Form->textBox('painWeighted',$weighted['MEWS_PAIN'],'',1,$weightedCSS);
							print $painWeighted;
						    ?>
						</td>
				    </tr>
				    <tr>
						<td>O2 Saturation</td>
						<td>
						    <?php
							$O2Sat = $Form->textBox('O2Sat',$MEWS['PAT_O2SATURATION'],'',0,$mewsClass);
							print $O2Sat;
						    ?>    
						</td>
						<td>
						    <?php
							$O2SatWeighted = $Form->textBox('O2SatWeighted',$weighted['MEWS_O2'],'',1,$weightedCSS);
							print $O2SatWeighted;
						    ?>
						</td>
				    </tr>
				    <tr>
						<td>Resp. Support</td>
						<td>
						    <?php
							//$Resp = $Form->textBox('Resp',$MEWS['MEWS_RESP'],'',0);
							//print $Resp;
						    ?> 
						</td>
						<td>
						    <?php
							$respSupportWeighted = $Form->textBox('respSupportWeighted',$weighted['MEWS_RESP'],'',1,$weightedCSS);
							print $respSupportWeighted;
						    ?>
						</td>
				    </tr>
				    <tr>
						<td>GCS</td>
						<td>
						    <?php
							$GCS = $Form->textBox('GCS',$MEWS['PAT_GCS'],'',0,$mewsClass);
							print $GCS;
						    ?>    
						</td>
						<td>
						    <?php
							$GCSWeighted = $Form->textBox('GCSWeighted',$weighted['MEWS_GCS'],'',1,$weightedCSS);
							print $GCSWeighted;
						    ?>
						</td>
				    </tr>
				    <tr>
						<td>Base Excess</td>
						<td>
						    <?php
							$baseExcess = $Form->textBox('BaseExcess',$MEWS['PAT_BASE_EXCESS'],'',0,$mewsClass);
							print $baseExcess;
						    ?>    
						</td>
						<td>
						    <?php
							$baseExcessWeighted = $Form->textBox('baseExcessWeighted',$weighted['MEWS_BE'],'',1,$weightedCSS);
							print $baseExcessWeighted;
						    ?>
						</td>
				    </tr>
				    <tr>
						<td>pH</td>
						<td>
						    <?php
							$pH = $Form->textBox('pH',$MEWS['PAT_PH'],'',0,$mewsClass);
							print $pH;
						    ?>    
						</td>
						<td>
						    <?php
							$pHWeighted = $Form->textBox('pHWeighted',$weighted['MEWS_PH'],'',1,$weightedCSS);
							print $pHWeighted;
						    ?>
						</td>
				    </tr>
				    <tr>
						<td>PaO2</td>
						<td>
						    <?php
							$pAO2 = $Form->textBox('pAO2',$MEWS['PAT_PAO2'],'',0,$mewsClass);
							print $pAO2;
						    ?>    
						</td>
						<td style="border-bottom: 1px solid black;">
						    <?php
							$pAO2Weighted = $Form->textBox('pAO2Weighted',$weighted['MEWS_PAO2'],'',1,$weightedCSS);
							print $pAO2Weighted;
						    ?>
						</td>
				    </tr>
				    <tr>
						<td>Trigger score</td>
						<td>
						    <?php
							$EWSSAlarm = $Form->textBox('EWSSAlarm',$EWSS['EWSS_ALARM'],'','',$mewsClass);
							print $EWSSAlarm;
						    ?>    
						</td>
						<td>
						    <?php
						    $mewsClass =array('newsTotal');
							$MEWS_Total = $Form->textBox('MEWSTotal','','',1,$mewsClass);
							print "Total: ".$MEWS_Total;
						    ?>
						</td>
				    </tr>
			    </table>
			    
			    <div id="MEWSTrig" style="color: red; font-weight: bold;">
				
			    </div>
			
			</div> <!-- Phys -->


			<!-- Questions -->
			<div id="page-2"> 


			<table>
				<tr>
					<td class="selected_table">

			            <table class="MOTable temp SelTable" id="tasks">
			                <thead>
			                    <tr>
			                        <th>Group</th>
			                        <th>Item</th>
			                        <th>Notes</th>
			                    </tr>
			                </thead>
			                <tbody>            
			                    <?php


									// SELECT A.AssessQuest_Question, A.AssessQuest_Answer
									// FROM Assess_Questions A
									// WHERE A.AssessQuest_dlkID = 452102539
									// AND A.AssessQuest_EWSSID = 452100001
									// AND A.AssessQuest_Question <> ''



									// SELECT Q.EWSS_Quest, G.QstGrpDescription
									// FROM EWSS_Questions Q
									// LEFT OUTER JOIN EWSS_QuestionGRP G 
									// ON G.QstGrpID = Q.QstGrpID_fk


									$query =  "SELECT Q.EWSS_Quest, G.QstGrpDescription
											FROM EWSS_Questions Q
											LEFT OUTER JOIN EWSS_QuestionGRP G 
											ON G.QstGrpID = Q.QstGrpID_fk";






			                        try { 
				                            $result = odbc_exec($connect,$query); 
				                            if($result){ 
						        				while ($admScore = odbc_fetch_array($result)) {
											    print "<tr>
													<td>".$admScore['EWSS_QUEST']."</td>
													<td>".$admScore['QSTGRPDESCRIPTION']."</td>
													<td>???</td>
												   </tr>"; 
						        				}
				                            } else { 
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


<!-- 				<table>
				    <tr>
					<td>
					    <table class="temp">
						<thead>
						    <tr>
								<th>Group</th>
								<th>Answer</th>
								<th>Question</th>
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
									<td>???</td>
									<td>".$admScore['AdmQuest_Answer']."</td>
									<td>".$admScore['AdmQuest_Question']."</td>
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
				</table> -->      
			</div>  <!-- Questions -->		
		</div>
	</body>
    </html>