<!DOCTYPE html>
    <html lang="eng">
<?php
error_reporting(E_ALL ^ E_NOTICE);

include './MelaClass/functions.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

?>
<head>
<link type="text/css" rel="stylesheet" href="media/css/normalize.css"/>  
<link type="text/css" rel="stylesheet" href="media/css/jquery-ui.css"/>
<link type="text/css" rel="stylesheet" href="media/css/style.css"/>		
<link type="text/css" rel="stylesheet" href="media/css/jquery css.css"/>		
<link type="text/css" rel="stylesheet" href="media/css/styleTabs.css">
<link type="text/css" rel="stylesheet" href="media/css/PatListing.css"/>
<link type="text/css" rel="stylesheet" href="media/css/jPages.css"/>
<link type="text/css" rel="stylesheet" href="media/css/jquery-impromptu.css"/>
<script src="media/js/jquery-1.10.0.min.js"></script>
<script src="media/js/jPages.min.js"></script>
<script src="media/js/jquery-ui-1.10.3.min.js"></script>
<script src="media/js/jquery-impromptu.js"></script>


<script type="text/javascript">
    $(document).ready(function(){
	jQuery.expr[':'].contains = function(a,i,m){
	       return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase())>=0;
	   };
     
	$('tbody tr[data-href]').addClass('clickable').click( function() { 
	    var data = $(this).data();
	    var href = data['href'];
	    var lnkid = data['lnkid'];
	    var user = $('#userID').val();
	    $.ajax({
		type: "POST",
		url: "SQLPatLockCheck.php",
		data: "lnkID=" + lnkid + "&user=" + user,
		async: false,
		success: function(msg){
		    if (msg.length > 0) {
		     $.prompt(msg);
		    } else {
		    window.location = href;
		    }
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
		    rowID = 'Invalid';
		    alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
		} 
	    });
	    
	});
     
	$('input[name="search"]').focus(function(){
		    $("div.holder").jPages("destroy");
		    $("div.holder").jPages({
			    containerID : "patlisting",
			    previous : "previous",
			    next : "next",
			    perPage : 10,
			    delay : 20
		    });
	});
	 
	$('input[name="search"]').keyup(function(){ 
		    
	    var searchterm = $(this).val();
	    
	    if(searchterm.length > 2) {
		    var match = $('tr.data-row:contains("' + searchterm + '")');
		    var nomatch = $('tr.data-row:not(:contains("' + searchterm + '"))');
		    //match.children().addClass('selected-cell');
		    match.addClass('selected');
		    nomatch.css("display", "none");
	    } else {
		    $('tr.data-row').css("display", "");
		    $('tr.data-row').removeClass('selected');
		    //$('tr.data-row td').removeClass('selected-cell');
	    }
	    
	    if (searchterm.length === 0) {
		$("div.holder").jPages("destroy");
		$("div.holder").jPages({
			    containerID : "patlisting",
			    previous : "previous",
			    next : "next",
			    perPage : 10,
			    delay : 20
		    });
	    }
			    
	});
     
	$(function() {
	   var hospNum = $( "#hospNum" ),
	     allFields = $( [] ).add( hospNum ),
	     tips = $( ".validateTips" );
	
	   function updateTips( t ) {
	     tips
	       .text( t )
	       .addClass( "ui-state-highlight" );
	     setTimeout(function() {
	       tips.removeClass( "ui-state-highlight", 1500 );
	     }, 500 );
	   }
	
	   function checkLength( o, n, min, max ) {
	     if ( o.val().length > max || o.val().length < min ) {
	       o.addClass( "ui-state-error" );
	       updateTips( "Length of " + n + " must be between " +
		 min + " and " + max + "." );
	       return false;
	     } else {
	       return true;
	     }
	   }
	
	   $( "#dialog-form" ).dialog({
	     autoOpen: false,
	     height: 120,
	     width: 280,
	     modal: true,
	     buttons: {
	       "Add new patient": function() {
		 var bValid = true;
		 //allFields.removeClass( "ui-state-error" );
	
		 bValid = bValid && checkLength( hospNum, "Hospital Number", 1, 16 );
	
		 if ( bValid ) {
		   $.ajax({
		       type: "POST",
		       url: "addPatient.php",
		       data: "hospNum="+ hospNum.val(),
		       async: false,
		       success: function(msg){
			   var bits = msg.split('	');
			   if (bits[1].length > 0) {
			    $.prompt(bits[1]);
			   } else {
			    //$.prompt("Everything's fine");
			    var user = $('#userID').val();
			    $.ajax({
				type: "POST",
				url: "SQLPatLockCheck.php",
				data: "lnkID=" + bits[0] + "&user=" + user,
				async: false,
				success: function(msg){
				    window.location.assign("patDmg.php?lnkID="+bits[0]);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
				    rowID = 'Invalid';
				    alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
				} 
			    });
			   
			   }
		       },
		       error: function(XMLHttpRequest, textStatus, errorThrown) {
			    rowID = 'Invalid';
			    alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
			} 
		     });
		   $( this ).dialog( "close" );
		 }
	       },
	       Cancel: function() {
		 $( this ).dialog( "close" );
	       }
	     },
	     close: function() {
	       //allFields.val( "" ).removeClass( "ui-state-error" );
	     }
	   });
	
	   $( "#create-user" )
	     .button()
	     .click(function() {
	       $( "#dialog-form" ).dialog( "open" );
	     });


	   $( "#sign-out" )
	     .button()
	     .click(function() {
	       window.location = "MelaClass/logoutAction.php"
	     });





	});
     
    });
</script>
<script type="text/javascript">
    $(function(){
	$("div.holder").jPages({
	    containerID : "patlisting",
	    previous : "previous",
	    next : "next",
	    perPage : 10,
	    delay : 20
	});
     });
</script>
<title>
    <?php echo $preferences['prf_HospitalName']; ?>
</title>
</head>
<?php
// This supposedly speeds up rendering time - see http://developer.yahoo.com/performance/rules.html#etags
flush();
?>
<body>
<?php

// print "<a href=MelaClass/logoutAction.php>Click here to logout</a>";
print "<input type='hidden' id='userID' value='".$auth->UsrKeys->UserID."'>";
/*
 * Determines which columns to display based on the rows present in
 * PatientListing_Index. At first I tried to programmatically build
 * the SQL query but there are some awkward dependencies between
 * certain tables that made in more complicated than necessary.
 *
 * Instead, simply select all possible fields and choose which ones to hide/
 * show based on the PatientListing_Index results
 */

// This array maps ColumnName from PatientListing_Index to the field as it is identified from a 4D SQL query
$dbColumns = array('Referral Number' => 'ADM_NUMBER',
		 'NHS Number' => 'DMG_NHSNUMBER',  
		 'First Name' => 'DMG_FIRSTNAME',
		 'Surname' => 'DMG_SURNAME',
		 'Hospital Number' => 'DMG_HOSPITALNUMBER',
		 'Location' => 'LNK_WARD',
		 'Referral Date' => 'ADM_BKD_DATE',
		 'Age' => 'DMG_AGEYEARS',
		 'Referral Time' => 'TIME_OF_CALL',
		 'Next Assessment date' => 'LNK_NEXTASSDATE',
		 'Next Assessment time' => 'LNK_NEXTASSTIME',
		 'Discharge Date' => 'OTC_OTRDISCHARGEDATE',
		 'Days Post Operation (A)' => 'DAYSPASTOPTILLDISCH',
		 'First Operation' => 'FIRST_OPERATION',
		 'First Modality' => 'FIRST_MODALITY',
		 'Location Bay' => 'ADM_LOCATION_BAY',
		 'Location Bed' => 'ADM_LOCATION_BED',
		 'Diagnosis' => 'FIRST_ICD10',
		 'Current Modality' => 'CURRENT_MODALITY',
		 'Attended' => 'LAST_CHRATTENDED',
		 'Research tag' => 'ADM_RESEARCHTAG',
		 'Current Medications' => 'CURRENTMEDICATIONS',
		 'Days Post Operation (O)' => 'DAYSPOSTOPASSESSMENT',
		 'Hospital Admission Date' => 'ADM_HOSPITALADMISSION',
		 'Hospital' => 'HOSP',
		 'Current Adverse Event' => 'CURRENTCRITINC');

$patListingColumns = array();
$sql = "SELECT * FROM PatientListing_Index WHERE".$Mela_SQL->sqlHUMinMax("ID"); 
try { 
    $selectResult = odbc_exec($connect,$sql); 
	if($selectResult){ 
		while ($patientListing = odbc_fetch_array($selectResult)) {
		    $patListingData = array('Order' => $patientListing['ColumnIndex'],'Name' => $patientListing['ColumnName'],'Field' => $patientListing['ColumnField'], 'ID' => $patientListing['ID']);
                    $patListingColumns[$patientListing['ColumnIndex']] = $patListingData;
		    
		    if ($patientListing['ID']) {
			$columns[$patientListing['ID']] = 1;
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
	asort($patListingColumns);





	print "<div class='container clearfix'>
		<div class='form'>

		<table class='list_head'>
			<tr>
				<td>
					Patient Listing
				</td>
			</tr>
		</table>


		<table class='list_nav'>
			<tr>
				<td>
					<button type='button' style='font-size:small;' id='sign-out'>Logout</button>
					<button type='button' style='font-size:small;' id='create-user'>Add new patient</button>
			    </td>
			    <td class='search_cell'>
					Search: <input type='text' name='search'>
				</td>
			</tr>
		</table>




		<div id='dialog-form' title='Add new patient'>
		<p class='validateTips'>All form fields are required.</p>
	       
		    <form>
		    <fieldset>
			<label for='hospNum'>Hospital Number</label>
			<input type='text' name='hospNum' id='hospNum' class='text ui-widget-content ui-corner-all hospNo-form' />
		    </fieldset>
		    </form>
		</div>


		
		<div class='div_Listing_Content'>
		<table class='Listing_Content'>
			<tr>
				<td>

			<div class='listing_div'>
					    <table class='patientselect'>
						    <thead>
								<tr class='header'>";
								    for ($i = 1; $i < count($patListingColumns); $i++) {
										if ($columns[$patListingColumns[$i]['ID']] == 1) {
											print "<th class='header_cell'>".$patListingColumns[$i]['Name']."</th>";	
										}
								    }
								print "</tr>
						    </thead>
					    	
					    	<tbody id='patlisting'>";
					    	

						$sql = "SELECT dmg.dmg_ID,
							dmg.dmg_FirstName,
							dmg.dmg_Surname,
							dmg.dmg_AgeYears,
							dmg.dmg_NHSNumber,
							dmg.dmg_HospitalNumber,
							dmg.Patient_In_Unit,
							lnk.lnk_ID,
							lnk.first_Modality,
							lnk.first_Operation,
							lnk.current_Modality,
							lnk.lnk_NextAssDate,
							lnk.lnk_NextAssTime,
							lnk.CurrentMedications,
							lnk.DaysPastOpTillDisch,
							lnk.Last_ChrAttended,
							lnk.DaysPostOpAssessment,
							lnk.CurrentCritInc,
							lnk.First_ICD10,
							adm.AdmStatus,
							adm.adm_Ward,
							adm.adm_ReferralDate,
							adm.adm_Location_bay,
							adm.adm_Location_bed,
							adm.adm_HospitalAdmission,
							adm_ResearchTag,
							adm.Hosp,
							adm.adm_Number,
							dgn.dgn_Reason1_Condition,
							otc.otc_HospDischargeDate,
							otc.otc_DeathDate,
							otc.otc_OTRDischargeDate,
							orc.Time_Of_Call
						FROM Demographic dmg
								LEFT OUTER JOIN LINK lnk ON dmg.dmg_ID = lnk.lnk_dmgID
								Right OUTER JOIN Admission adm ON adm.adm_ID = lnk.lnk_admID
								LEFT OUTER JOIN Diagnosis dgn ON dgn.dgn_ID = lnk.lnk_dgnID
								Right OUTER JOIN Outcome otc ON otc.otc_ID = lnk.lnk_otcID
								LEFT OUTER JOIN OR_Call orc ON orc.cal_ID = adm.adm_calID
						WHERE adm.AdmStatus = 'Admitted'
						AND (otc.otc_HospDischargeDate < '01/01/0001 00:00:00')
						AND (otc.otc_DeathDate < '01/01/0001 00:00:00')
						AND (otc.otc_OTRDischargeDate < '01/01/0001 00:00:00')
						AND".$Mela_SQL->sqlHUMinMax("lnk.lnk_ID").
						"ORDER BY adm.adm_Number DESC";

					$n = 1;
					try { 
					    $selectResult = odbc_exec($connect,$sql); 
						if($selectResult){ 
							while ($listingFields = odbc_fetch_array($selectResult)) {
								if ($n % 2 == 0) {
									$oddEven = 'even';
									$n++;
								} else {
									$oddEven = 'odd';
									$n++;
								}
							    print "<tr class='select data-row ".$oddEven."' data-href='patDmg.php?lnkID=".$listingFields['LNK_ID']."' data-lnkid='".$listingFields['LNK_ID']."'>";
								    for ($i = 1; $i < count($patListingColumns); $i++) {
									if ($columns[$patListingColumns[$i]['ID']] == 1) {
									    // Some fields need some extra formatting for time purposes
									    switch ($patListingColumns[$i]['Name']) {
										case "Next Assessment date":
										case "Discharge Date":
										case "Hospital Admission Date":
										    //print "<td class='listing_cell'>".convert4DTime($listingFields[$dbColumns[$patListingColumns[$i]['Name']]])."</td>";
										    $splitColumnDates = explode(' ', $listingFields[$dbColumns[$patListingColumns[$i]['Name']]]);
										    print "<td class='listing_cell'><div class='plCell'>".$splitColumnDates[0]."</div></td>";
										break;
										
										case "Next Assessment time":
										case "Referral Time":
											print "<td class='listing_cell'><div class='plCell'>".convert4DTime($listingFields[$dbColumns[$patListingColumns[$i]['Name']]])."</div></td>";	
										break;
									    
										case "Location":
										    print "<td class='listing_cell'><div class='plCell'>".$listingFields['ADM_WARD']."</div></td>";
										break;
									    
										default:
										    print "<td class='listing_cell'><div class='plCell'>".$listingFields[$dbColumns[$patListingColumns[$i]['Name']]]."</div></td>";
										break;
									    }
									}
								    }			    
							    print "</tr>".PHP_EOL;
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
					    print "</tbody>
					    </table>
				    </div>

				</td>
			</tr>
			<tr class='holder_row'>
				<td class='page_cell'>
			 		<div class='holder'></div>
			 	</td>
			</tr>
		</table>
		</div>
		</div>
    </div>";
?>
</body>
    </html>