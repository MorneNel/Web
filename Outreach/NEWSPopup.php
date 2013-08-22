<?php

include('./MelaClass/functions.php');
include('./MelaClass/Mela_Forms.php');
include('./MelaClass/db.php');
include('./MelaClass/authInitScript.php');

if (!$_REQUEST['dlk_patID'] || !$_REQUEST['lnkid']) die("Necessary data is missing");

$dlkPatID = filter_var($_REQUEST['dlk_patID'], FILTER_SANITIZE_NUMBER_INT);
$lnkID = filter_var($_REQUEST['lnkid'], FILTER_SANITIZE_NUMBER_INT);
$dlkID = filter_var($_REQUEST['dlkid'], FILTER_SANITIZE_NUMBER_INT);


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

$query = "SELECT pat_RespiratoryRate, pat_Temperature, pat_Systolic_BP, pat_AVPU,
          pat_O2Saturation, pat_PaO2, pat_O2Received, pat_HeartRate
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
	    <link type="text/css" rel="stylesheet" href="media/css/news_scoreboard.css">
	    <script src="media/js/jquery-1.10.0.min.js"></script>
	    <script src="media/js/jquery-ui-1.10.3.min.js"></script>
	    <script src="media/js/sisyphus.min.js"></script>
	    <script src="media/js/jquery.validate.min.js"></script>


	    <script>
		$(document).ready(function() {
		    function calculateNEWS(ID) {
			var user = $('#user').val();
			$.ajax({
			    type: "POST",
			    url: "calculateNEWS.php",
			    data: "page=PHYS&id=" + ID + "&user=" + user,
			    async: false,
			    success: function(msg){
				$('#testdiv').text(msg);
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
			
			$('#NEWSTotal').val(ValsArr[0]);
			$('.alertbox-middle').text(ValsArr[1]);
			$('.alertbox-bottom').text(ValsArr[2]);
			$('#respRateWeighted').val(ValsArr[3]);
			$('#O2SatWeighted').val(ValsArr[4]);
			$('#O2ReceivedWeighted').val(ValsArr[5]);
			$('#temperatureWeighted').val(ValsArr[6]);
			$('#sysBPWeighted').val(ValsArr[7]);
			$('#HRWeighted').val(ValsArr[8]);
			$('#AVPUWeighted').val(ValsArr[9]);
			
			$('.alertbox-top').text(ValsArr[0]);
			window.opener.$('#phys-NEWSScore').val(ValsArr[0]);
			
			var NEWScore = ValsArr[0];
			switch (NEWScore) {
			    case '1':
			    case '2':
				$('.alertbox-top').removeClass('okay moderate severe').addClass('okay');
			    break;
			
			    case '3':
			    case '4':
				$('.alertbox-top').removeClass('okay moderate severe').addClass('moderate');
			    break;
			
			    case '5':
			    case '6':
				$('.alertbox-top').removeClass('okay moderate severe').addClass('severe');
			    break;
			
			    default:
				
			    break;
			}
			
		    }
		    
		    function run() {
			var dlk = $('#hiddenDLK').val();
			calculateNEWS(dlk);
		    }
		    
		    $('#cancelButton').click(function() {
			window.close();
		    });
		    
		    $('#testbutton').click(function() {
			var data = $(this).data();
			var dlk = data['dlkid'];
			calculateNEWS(dlk);
		    });		
		    
		    run();
		    
		    
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
	    <?php echo $Form->hiddenField('hiddenDLK',$dlkID); ?>
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
		</div>
	    
	 	<div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
			<ul style="display:none;">
			    <li><a href="#page-1"><span>NEWS Score</span></a></li>
			</ul>

		    <div class="cssmenu">
		    	<ul>
				    <li class='tabs_item' id='tabNEWSns'><a href='#page-1' class='active_pat_tab'><span>NEWS Score</span></a></li>
				</ul>
		    </div>

			<div style="clear: both;"></div>
				<table>
					<tr>
						<td>
							<div id="page-1" class="half">
								<table class='temp NEWSTable'>
										<tr>
										    <td>&nbsp;</td>
										    <td>Physiology</td>
										    <td>Score</td>
										</tr>
										<tr>
										    <td>Respiratory Rate</td>
										    <td><?php $mewsClass =array('mewsField'); $respRate = $Form->textBox('respRate',$MEWS['PAT_RESPIRATORYRATE'],'',1,$mewsClass); print $respRate; ?></td>
										    <td><?php $respRateWeighted = $Form->textBox('respRateWeighted','','',1,$weightedCSS); print $respRateWeighted; ?></td>
										</tr>
										<tr>
										    <td>O2 Saturation</td>
										    <td><?php $mewsClass =array('mewsField'); $O2Sat = $Form->textBox('O2Sat',$MEWS['PAT_O2SATURATION'],'',1,$mewsClass); print $O2Sat; ?></td>
										    <td><?php $O2SatWeighted = $Form->textBox('O2SatWeighted','','',1,$weightedCSS); print $O2SatWeighted; ?></td>
										</tr>
										<tr>
										    <td>O2 Received</td>
										    <td><?php $mewsClass =array('mewsField'); $O2Sat = $Form->textBox('O2Received',$MEWS['PAT_O2RECEIVED'],'',1,$mewsClass); print $O2Sat; ?></td>
										    <td><?php $O2SatWeighted = $Form->textBox('O2ReceivedWeighted','','',1,$weightedCSS); print $O2SatWeighted; ?></td>
										</tr>
										<tr>
										    <td>Temperature</td>
										    <td><?php $mewsClass =array('mewsField'); $temperature = $Form->textBox('temperature',$MEWS['PAT_TEMPERATURE'],'',1,$mewsClass); print $temperature; ?></td>
										    <td><?php $temperatureWeighted = $Form->textBox('temperatureWeighted','','',1,$weightedCSS); print $temperatureWeighted; ?></td>
										</tr>
										<tr>
										    <td>Blood Pressure</td>
										    <td><?php $mewsClass =array('mewsField'); $sysBP = $Form->textBox('sysBP',$MEWS['PAT_SYSTOLIC_BP'],'',1,$mewsClass); print $sysBP; ?></td>
										    <td><?php $sysBPWeighted = $Form->textBox('sysBPWeighted','','',1,$weightedCSS); print $sysBPWeighted; ?></td>
										</tr>
										<tr>
										    <td>Heart Rate</td>
										    <td><?php $mewsClass =array('mewsField'); $HR = $Form->textBox('HR',$MEWS['PAT_HEARTRATE'],'',1,$mewsClass); print $HR; ?></td>
										    <td><?php $HRWeighted = $Form->textBox('HRWeighted','','',1,$weightedCSS); print $HRWeighted; ?></td>
										</tr>
										<tr>
									    	<td>AVPU</td>
									    	<td><?php $mewsClass =array('mewsField'); $AVPU = $Form->textBox('AVPU',$MEWS['PAT_AVPU'],'',1,$mewsClass); print $AVPU; ?></td>
										    <td><?php $AVPUWeighted = $Form->textBox('AVPUWeighted','','',1,$weightedCSS); print $AVPUWeighted; ?></td>
										</tr>
										<tr>
										    <td colspan='2'>&nbsp;</td>
										    <td><?php  $mewsClass =array('newsTotal'); $NEWS_Total = $Form->textBox('NEWSTotal','','',1,$mewsClass); print "Total: ".$NEWS_Total; ?></td>
										</tr>
								</table>
								<div id="MEWSTrig" style="color: red; font-weight: bold;"></div>
							</div>
						</td>
						<td>
							<div class="half alertbox">
								<div class="alertbox-top"></div>
								<div class="alertbox-middle"></div>
								<div class="alertbox-bottom"></div>
					    	</div>
						</td>
					</tr>
				</table>
			</div> 
	 	</div>

	</body>
</html>