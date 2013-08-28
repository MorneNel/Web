

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
					    	
					    	<tbody id='patlisting' class='normal'>";
					    	

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
