</table><!-- Leave this in place or it breaks the form below -->
<script type="text/javascript">
    $(document).ready(function() {            
	$(document).on('click', '#addIntervention', function() {
	    var data = $(this).data();
	    var lnk = data['lnk'];
	    var result = JSON.stringify($('form#interventionsForm :input').serializeObject());
	    console.debug(result);
	    $('form#interventionsForm').css('color','red');
	    //$('#resusInterventionsIframe').contents().find('body').html('This is a test');
	    
	    $.ajax({
	       type: "POST",
	       url: "addresusIntervention.php",
	       data: "lnk_ID=" + lnk + "&result=" + result,
	       success: function(msg){
		$('#resusInterventionsIframe').contents().find('body').html(msg);
		//$('#resusInterventionsIframe').contentWindow.location.reload(true);
	       },
	       error: function(XMLHttpRequest, textStatus, errorThrown) { 
		    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		} 
	     });
	});
	
	$(document).on('click', '.deleteintRow', function() {
	    var data = $(this).data();
	    var icdid = data['icdid'];
	    var lnk = data['lnk'];
	    
	    $.ajax({
	       type: "POST",
	       url: "DeleteintRow.php",
	       data: "lnk_ID=" + lnk + "&ICD_ID=" + icdid,
	       success: function(msg){
	       },
	       error: function(XMLHttpRequest, textStatus, errorThrown) { 
		    alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		} 
	     });
	
	    var whichtr = $(this).closest("tr");       
	    whichtr.remove();
	});
	
	$('#testButton').click(function() {
	    var fluids = $('#int-Route').val();
	    alert("Fluid is " + fluids);		
	});
    });
</script>
<fieldset>
    <button type='button' style='font-size:small;' id='addIntervention'>
        Add
    </button>
    
    <!--<button type='button' style='font-size:small;' id='testButton'>
        Test
    </button>-->
</fieldset>

<form id="interventionsForm">
    <?php
	$hiddenlnk_ID = $Form->hiddenField('hiddenIntLNKID',$lnkID);
	echo $hiddenlnk_ID;
    ?>
    <table class="temp">
	<tr>
	    <th>
		Time
	    </th>
	    <th>
		Rhythm
	    </th>
	    <th>
		Adrenaline
	    </th>
	    <th>
		DC Shock
	    </th>
	    <th>
		Type
	    </th>
	    <th>
		Drugs
	    </th>
	    <th>
		Fluids
	    </th>
	    <th>
		Route
	    </th>
	    <th>
		Cardiovascular
	    </th>
	    <th>
		Respiratory
	    </th>
	    <th>
		Neurological
	    </th>
	    <th>
		Airway
	    </th>
	</tr>
	<tr>
	    <td>
		<?php
		    $intTime = $Form->timeField('int-Time');
		    echo $intTime;
		?>
	    </td>
	    <td>
		<?php
		    $intRhythmDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Rhythm');
		    $intRhythmDDArray = array();
		    for ($i = 1; $i < (count($intRhythmDDSQL)+1); $i++) {
			array_push($intRhythmDDArray,$intRhythmDDSQL[$i]['Long_Name']);
		    }
	
		    $intRhythmDD = $Form->dropDown('int-Rhythm',$intRhythmDDArray,$intRhythmDDArray);
		    echo $intRhythmDD;
		?>
	    </td>
	    <td>
		<?php
		    $intAdrenalineDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Adrenaline');
		    $intAdrenalineDDArray = array();
		    for ($i = 1; $i < (count($intAdrenalineDDSQL)+1); $i++) {
			array_push($intAdrenalineDDArray,$intAdrenalineDDSQL[$i]['Long_Name']);
		    }
	
		    $intAdrenalineDD = $Form->dropDown('int-Adrenaline',$intAdrenalineDDArray,$intAdrenalineDDArray);
		    echo $intAdrenalineDD;
		?>
	    </td>
	    <td>
		<?php
		    $intDCShock = $Form->textBox('int-DCShock');
		    echo $intDCShock;
		?>
	    </td>
	    <td>
		<?php
		    $intDefibrillatorDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Defibrillator');
		    $intDefibrillatorDDArray = array();
		    for ($i = 1; $i < (count($intDefibrillatorDDSQL)+1); $i++) {
			array_push($intDefibrillatorDDArray,$intDefibrillatorDDSQL[$i]['Long_Name']);
		    }
	
		    $intDefibrillatorDD = $Form->dropDown('int-Defibrillator',$intDefibrillatorDDArray,$intDefibrillatorDDArray);
		    echo $intDefibrillatorDD;
		?>
	    </td>
	    <td>
		<?php
		    $intDrugsDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Drugs');
		    $intDrugsDDArray = array();
		    for ($i = 1; $i < (count($intDrugsDDSQL)+1); $i++) {
			array_push($intDrugsDDArray,$intDrugsDDSQL[$i]['Long_Name']);
		    }
	
		    $intDrugsDD = $Form->dropDown('int-Drugs',$intDrugsDDArray,$intDrugsDDArray);
		    echo $intDrugsDD;
		?>
	    </td>
	    <td>
		<?php
		    $intFluidsDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Fluids');
		    $intFluidsDDArray = array();
		    for ($i = 1; $i < (count($intFluidsDDSQL)+1); $i++) {
			array_push($intFluidsDDArray,$intFluidsDDSQL[$i]['Long_Name']);
		    }
	
		    $intFluidsDD = $Form->dropDown('int-Fluids',$intFluidsDDArray,$intFluidsDDArray);
		    echo $intFluidsDD;
		?>
	    </td>
	    <td>
		<?php
		    $intRouteDDSQL = $Mela_SQL->tbl_LoadItems('Route');
		    $intRouteDDArray = array();
		    for ($i = 1; $i < (count($intRouteDDSQL)+1); $i++) {
			array_push($intRouteDDArray,$intRouteDDSQL[$i]['Long_Name']);
		    }
	
		    $intRouteDD = $Form->dropDown('int-Route',$intRouteDDArray,$intRouteDDArray);
		    echo $intRouteDD;
		?>
	    </td>
	    <td>
		<?php
		    $intCardiovascularDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Cardiovascular');
		    $intCardiovascularDDArray = array();
		    for ($i = 1; $i < (count($intCardiovascularDDSQL)+1); $i++) {
			array_push($intCardiovascularDDArray,$intCardiovascularDDSQL[$i]['Long_Name']);
		    }
	
		    $intCardiovascularDD = $Form->dropDown('int-Cardiovascular',$intCardiovascularDDArray,$intCardiovascularDDArray);
		    echo $intCardiovascularDD;
		?>
	    </td>
	    <td>
		<?php
		    $intRespiratoryDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Respiratory');
		    $intRespiratoryDDArray = array();
		    for ($i = 1; $i < (count($intRespiratoryDDSQL)+1); $i++) {
			array_push($intRespiratoryDDArray,$intRespiratoryDDSQL[$i]['Long_Name']);
		    }
	
		    $intRespiratoryDD = $Form->dropDown('int-Respiratory',$intRespiratoryDDArray,$intRespiratoryDDArray);
		    echo $intRespiratoryDD;
		?>
	    </td>
	    <td>
		<?php
		    $intNeurologicalDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Neurological');
		    $intNeurologicalDDArray = array();
		    for ($i = 1; $i < (count($intNeurologicalDDSQL)+1); $i++) {
			array_push($intNeurologicalDDArray,$intNeurologicalDDSQL[$i]['Long_Name']);
		    }
	
		    $intNeurologicalDD = $Form->dropDown('int-Neurological',$intNeurologicalDDArray,$intNeurologicalDDArray);
		    echo $intNeurologicalDD;
		?>
	    </td>
	    <td>
		<?php
		    $intAirwayDDSQL = $Mela_SQL->tbl_LoadItems('Resuscitation Airway');
		    $intAirwayDDArray = array();
		    for ($i = 1; $i < (count($intAirwayDDSQL)+1); $i++) {
			array_push($intAirwayDDArray,$intAirwayDDSQL[$i]['Long_Name']);
		    }
	
		    $intAirwayDD = $Form->dropDown('int-Airway',$intAirwayDDArray,$intAirwayDDArray);
		    echo $intAirwayDD;
		?>		
	    </td>
	</tr>
    </table>
</form>

<iframe id='resusInterventionsIframe' name='resusInterventionsIframe' width='100%' src='resuscitationInterventionsFrame.php?lnkID=<?php echo $lnkID; ?>' frameborder='0' style='min-height:450px;'></iframe>