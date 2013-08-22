<!DOCTYPE html>
<link rel="stylesheet" href="media/css/style.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="media/css/jquery.ui.labeledslider.css">
    
<script src="media/js/jquery-1.10.0.min.js"></script>
<script src="media/js/jquery-ui.js"></script>
<script src="media/js/jquery.ui.labeledslider.js"></script>
<script language="JavaScript" type="text/javascript">
    function CloseAndRefresh() 
    {
	window.opener.location.reload();
	self.close();
    }
    
    $(document).ready(function() {
	$('#slider').labeledslider({
	    value:5,
	    min: 0,
	    max: 10,
	    step: 1,
	    tickInterval: 1,
	    slide: function( event, ui ) {
	      $( "#amount" ).val( ui.value );
	    },
	    change: function(event, ui) {
	      $('input#sliderval').val(ui.value);
	    }
	});
	$( "#amount" ).val( $( "#slider" ).labeledslider( "value" ) );
	$('input#sliderval').val($( "#slider" ).labeledslider( "value" ));
	
	function setScore(field) {
	    var fieldValue = $('#' + field + '').val();
	    var fieldDestination = $('#' + field + 'Score');
	    
	    fieldDestination.val(fieldValue);	    
	}
	
	function FLACCTotal() {
	    var face = $('#FLACC-FaceScore').val();
	    var legs = $('#FLACC-LegsScore').val();
	    var activity = $('#FLACC-ActivityScore').val();
	    var cry = $('#FLACC-CryScore').val();
	    var consolability = $('#FLACC-ConsolabilityScore').val();
	    
	    var FLACCTotal = Number(face)+Number(legs)+Number(activity)+Number(cry)+Number(consolability);
	    $('#FLACC-TotalScore').val(FLACCTotal);
	}
	
	function CRIESTotal() {
	    var crying = $('#CRIES-CryingScore').val();
	    var requiresO2 = $('#CRIES-RequiresO2Score').val();
	    var vitalSigns = $('#CRIES-VitalSignsScore').val();
	    var expression = $('#CRIES-ExpressionScore').val();
	    var sleepless = $('#CRIES-SleeplessScore').val();
	    
	    var CRIESTotal = Number(crying)+Number(requiresO2)+Number(vitalSigns)+Number(expression)+Number(sleepless);
	    $('#CRIES-TotalScore').val(CRIESTotal);
	}
	
	$('#FLACC-Face').change(function() {
	   var that = 'FLACC-Face';
	   setScore(that);
	   FLACCTotal();
	});
	
	$('#FLACC-Legs').change(function() {
	   var that = 'FLACC-Legs';
	   setScore(that);
	   FLACCTotal();
	});
	
	$('#FLACC-Activity').change(function() {
	   var that = 'FLACC-Activity';
	   setScore(that);
	   FLACCTotal();
	});
	
	$('#FLACC-Cry').change(function() {
	   var that = 'FLACC-Cry';
	   setScore(that);
	   FLACCTotal();
	});
	
	$('#FLACC-Consolability').change(function() {
	   var that = 'FLACC-Consolability';
	   setScore(that);
	   FLACCTotal();
	});
	
	$('#CRIES-Crying').change(function() {
	   var that = 'CRIES-Crying';
	   setScore(that);
	   CRIESTotal();
	});
	
	$('#CRIES-RequiresO2').change(function() {
	   var that = 'CRIES-RequiresO2';
	   setScore(that);
	   CRIESTotal();
	});
	
	$('#CRIES-VitalSigns').change(function() {
	   var that = 'CRIES-VitalSigns';
	   setScore(that);
	   CRIESTotal();
	});
	
	$('#CRIES-Expression').change(function() {
	   var that = 'CRIES-Expression';
	   setScore(that);
	   CRIESTotal();
	});
	
	$('#CRIES-Sleepless').change(function() {
	   var that = 'CRIES-Sleepless';
	   setScore(that);
	   CRIESTotal();
	});
    });
</script>
<?php
error_reporting(E_ALL ^ E_NOTICE);
include './MelaClass/functions.php';
include './MelaClass/Mela_Forms.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

$Form = new Mela_Forms('paedPainScore','','POST','paedPain_form');

$facesCSS = array('faces');

if (!$_REQUEST['row']) die("Necessary data is missing");

$row = filter_var($_REQUEST['row'], FILTER_SANITIZE_NUMBER_INT);

// Get relevant data to fill out form
$query = "SELECT otr.otr_ID, otr.actpain_FaceScore, otr.actpain_VAS, otr.actpain_FLACC_Face, otr.actpain_FLACC_Legs, otr.actpain_FLACC_Activity, otr.actpain_FLACC_Cry,
	  otr.actpain_FLACC_Consolability, otr.actpain_FLACC_Total, otr.actpain_CRIES_Crying, otr.actpain_CRIES_RequiresO2,
	  otr.actpain_CRIES_VitalSigns, otr.actpain_CRIES_Expression, otr.actpain_CRIES_Sleepless, otr.actpain_CRIES_Total
	  FROM Outreach otr
	  WHERE otr.otr_ID=$row";
try { 
    $result = odbc_exec($connect,$query); 
    if($result){ 
	$painData = odbc_fetch_array($result);
    } else { 
        throw new RuntimeException("Failed to connect."); 
    } 
} 
catch (RuntimeException $e) { 
    print("Exception caught: $e");
}
	
if ($_POST) {
    
    if (!$_POST['row']) die("No ID set for selected row.");
    $itmID = filter_var($_POST['row'], FILTER_SANITIZE_NUMBER_INT);
    
    foreach($_POST as $k => $v) {
	$formKey[$k] = $k;
	$formVal[$k] = checkValues($v);
	echo "<b>". $formKey[$k] ."</b> - ". $formVal[$k] ."<br />";
    }
        
    $query = "UPDATE Outreach SET actpain_FaceScore='".$formVal['faceScale']."', actpain_VAS='".$formVal['slider_value']."',
    actpain_FLACC_Face='".$formVal['FLACC-FaceScore']."', actpain_FLACC_Legs='".$formVal['FLACC-LegsScore']."',
    actpain_FLACC_Activity='".$formVal['FLACC-ActivityScore']."', actpain_FLACC_Cry='".$formVal['FLACC-CryScore']."',
    actpain_FLACC_Consolability='".$formVal['FLACC-ConsolabilityScore']."', actpain_FLACC_Total='".$formVal['FLACC-TotalScore']."',
    actpain_CRIES_Crying='".$formVal['CRIES-CryingScore']."', actpain_CRIES_RequiresO2='".$formVal['CRIES-RequiresO2Score']."',
    actpain_CRIES_VitalSigns='".$formVal['CRIES-VitalSignsScore']."', actpain_CRIES_Expression='".$formVal['CRIES-ExpressionScore']."',
    actpain_CRIES_Sleepless='".$formVal['CRIES-SleeplessScore']."', actpain_CRIES_Total='".$formVal['CRIES-TotalScore']."'
    WHERE otr_ID=$itmID";
    try { 
	$result = odbc_exec($connect,$query); 
	if(!$result){ 
	    throw new RuntimeException("Failed to connect."); 			 
	}
    }
    catch (RuntimeException $e) { 
	    print("Exception caught: $e");
    } echo $query;
?>
<script type="text/javascript">
    CloseAndRefresh()();
</script>

<?php
} else {
    $itmID = $Form->hiddenField('row',$painData['OTR_ID']);
    echo $itmID;
?>
<fieldset style="width:95%;">
    <legend>
        The Faces Scale
    </legend>
    <?php if ($preferences['FacesScore_Scale3'] == 'true') { ?>
    <table class="temp" cellpadding="5">
	<tr style="margin-left: auto; margin-right: auto; width: 100%;">
	    <td>
		<img src="media/images/faces/face0.png">
	    </td>
	    <td>
		<img src="media/images/faces/face4.png">	
	    </td>
	    <td>
		<img src="media/images/faces/face6.png">
	    </td>
	    <td>
		<img src="media/images/faces/face10.png">
	    </td>
	</tr>
	<tr>
	    <td>
		<?php
		    $timelinessoptions = array('0' => '<br />0<br /> No Hurt');
		    $timelinessRadio = $Form->radioBox('faceScale',$timelinessoptions,$painData['ACTPAIN_FACESCORE'],'',$facesCSS);
		    echo $timelinessRadio;
		?>
	    </td>
	    <td>
		<?php
		    $timelinessoptions2 = array('1' => '<br />1<br /> Hurts Little Bit');
		    $timelinessRadio2 = $Form->radioBox('faceScale',$timelinessoptions2,$painData['ACTPAIN_FACESCORE'],'',$facesCSS);
		    echo $timelinessRadio2;
		?>
	    </td>
	    <td>
		<?php
		    $timelinessoptions3 = array('2' => '<br />2<br /> Hurts Whole Lot');
		    $timelinessRadio3 = $Form->radioBox('faceScale',$timelinessoptions3,$painData['ACTPAIN_FACESCORE'],'',$facesCSS);
		    echo $timelinessRadio3;
		?>
	    </td>
	    <td>
		<?php
		    $timelinessoptions4 = array('3' => '<br />3<br /> Hurts Worst');
		    $timelinessRadio4 = $Form->radioBox('faceScale',$timelinessoptions4,$painData['ACTPAIN_FACESCORE'],'',$facesCSS);
		    echo $timelinessRadio4;
		?>
	    </td>
	</tr>
    </table>
    <?php } ?>
    
    <?php if ($preferences['FacesScore_Scale3'] == 'false') { ?>
    <table class="temp" cellpadding="5">
	<tr style="margin-left: auto; margin-right: auto; width: 100%;">
	    <td>
		<img src="media/images/faces/face0.png">
	    </td>
	    <td>
		<img src="media/images/faces/face2.png">
	    </td>
	    <td>
		<img src="media/images/faces/face4.png">	
	    </td>
	    <td>
		<img src="media/images/faces/face6.png">
	    </td>
	    <td>
		<img src="media/images/faces/face8.png">
	    </td>
	    <td>
		<img src="media/images/faces/face10.png">
	    </td>
	</tr>
	<tr>
	    <td>
		<?php
		    $timelinessoptions = array('0' => '<br />0<br /> No Hurt');
		    $timelinessRadio = $Form->radioBox('faceScale',$timelinessoptions,$painData['ACTPAIN_FACESCORE'],'',$facesCSS);
		    echo $timelinessRadio;
		?>
	    </td>
	    <td>
		<?php
		    $timelinessoptions2 = array('1' => '<br />2<br /> Hurts Little Bit');
		    $timelinessRadio2 = $Form->radioBox('faceScale',$timelinessoptions2,$painData['ACTPAIN_FACESCORE'],'',$facesCSS);
		    echo $timelinessRadio2;
		?>
	    </td>
	    <td>
		<?php
		    $timelinessoptions3 = array('2' => '<br />4<br /> Hurts Little More');
		    $timelinessRadio3 = $Form->radioBox('faceScale',$timelinessoptions3,$painData['ACTPAIN_FACESCORE'],'',$facesCSS);
		    echo $timelinessRadio3;
		?>
	    </td>
	    <td>
		<?php
		    $timelinessoptions4 = array('3' => '<br />6<br /> Hurts Even More');
		    $timelinessRadio4 = $Form->radioBox('faceScale',$timelinessoptions4,$painData['ACTPAIN_FACESCORE'],'',$facesCSS);
		    echo $timelinessRadio4;
		?>
	    </td>
	    <td>
		<?php
		    $timelinessoptions5 = array('4' => '<br />8<br /> Hurts Whole Lot');
		    $timelinessRadio5 = $Form->radioBox('faceScale',$timelinessoptions5,$painData['ACTPAIN_FACESCORE'],'',$facesCSS);
		    echo $timelinessRadio5;
		?>
	    </td>
	    <td>
		<?php
		    $timelinessoptions6 = array('5' => '<br />10<br /> Hurts Worst');
		    $timelinessRadio6 = $Form->radioBox('faceScale',$timelinessoptions6,$painData['ACTPAIN_FACESCORE'],'',$facesCSS);
		    echo $timelinessRadio6;
		?>
	    </td>
	</tr>
    </table>
    <?php } ?>
</fieldset>
    
    <fieldset>
	<legend>
	    Visual Analogue Scale
	</legend>
	<div id="slider"></div>
        <input type="hidden" id="sliderval" name="slider_value">
    </fieldset>
    
    <fieldset>
	<legend>
	    FLACC Score
	</legend>
	<Table class="temp">
	    <tr>
		<td>
		    Face
		</td>
		<td>
		    <?php
			$faceScore = $Form->textBox('FLACC-FaceScore',$painData['ACTPAIN_FLACC_FACE']);
			echo $faceScore;
		    ?>    
		</td>
		<td>
		    <?php
			$faceDDArray = array(0 => "No particular expression or smile",
					     1 => "Occasional grimace or frown, withdrawn, disinterested",
					     2 => "Frequent to constant frown, quivering chin, clenched jaw");
			$faceDD = $Form->dropDown('FLACC-Face',$faceDDArray,'',$patient['ACTPAIN_FLACC_FACE']);
			echo $faceDD;
		    ?>
		</td>
	    </tr>
	    <tr>
		<td>
		    Legs
		</td>
		<td>
		    <?php
			$legsScore = $Form->textBox('FLACC-LegsScore',$painData['ACTPAIN_FLACC_LEGS']);
			echo $legsScore;
		    ?>     
		</td>
		<td>
		    <?php
			$legsDDArray = array(0 => "Normal position or relaxed",
					     1 => "Uneasy, restless, tense",
					     2 => "Kicking or legs drawn up");
			$legsDD = $Form->dropDown('FLACC-Legs',$legsDDArray,'',$patient['ACTPAIN_FLACC_LEGS']);
			echo $legsDD;
		    ?>
		</td>
	    </tr>
	    <tr>
		<td>
		    Activity
		</td>
		<td>
		    <?php
			$activityScore = $Form->textBox('FLACC-ActivityScore',$painData['ACTPAIN_FLACC_ACTIVITY']);
			echo $activityScore;
		    ?>     
		</td>
		<td>
		    <?php
			$activityDDArray = array(0 => "Lying quietly, normal position, moves easily",
					     1 => "Squirming shifting back and forth, tense",
					     2 => "Arched rigid or jerking");
			$activityDD = $Form->dropDown('FLACC-Activity',$activityDDArray,'',$patient['ACTPAIN_FLACC_ACTIVITY']);
			echo $activityDD;
		    ?>
		</td>
	    </tr>
	    <tr>
		<td>
		    Cry
		</td>
		<td>
		    <?php
			$cryScore = $Form->textBox('FLACC-CryScore',$painData['ACTPAIN_FLACC_CRY']);
			echo $cryScore;
		    ?>     
		</td>
		<td>
		    <?php
			$cryDDArray = array(0 => "No cry (awake or asleep)",
					     1 => "Moans or whimpers; occasional complaint",
					     2 => "Crying steadily, screams or sobs, frequent complaints");
			$cryDD = $Form->dropDown('FLACC-Cry',$cryDDArray,'',$patient['ACTPAIN_FLACC_CRY']);
			echo $cryDD;
		    ?>
		</td>
	    </tr>
	    <tr>
		<td>
		    Consolability
		</td>
		<td>
		    <?php
			$consolabilityScore = $Form->textBox('FLACC-ConsolabilityScore',$painData['ACTPAIN_FLACC_CONSOLABILITY']);
			echo $consolabilityScore;
		    ?>     
		</td>
		<td>
		    <?php
			$consolabilityDDArray = array(0 => "Content relaxed",
					     1 => "Reassured by occasional touching, hugging, or being talked to; distractible",
					     2 => "Difficult to console or comfort");
			$consolabilityDD = $Form->dropDown('FLACC-Consolability',$consolabilityDDArray,'',$patient['ACTPAIN_FLACC_CONSOLABILITY']);
			echo $consolabilityDD;
		    ?>
		</td>
	    </tr>
	    <tr>
		<td>
		    FLACC Total
		</td>
		<td>
		    <?php
			$FLACCTotalScore = $Form->textBox('FLACC-TotalScore',$painData['ACTPAIN_FLACC_TOTAL']);
			echo $FLACCTotalScore;
		    ?>     
		</td>
		<td>
		    &nbsp;
		</td>
	    </tr>
	</Table>
    </fieldset>
    
    <fieldset>
	<legend>
	    CRIES Score
	</legend>
	<table class="temp">
	    <tr>
		<td>
		    Crying
		</td>
		<td>
		    <?php
			$cryingScore = $Form->textBox('CRIES-CryingScore',$painData['ACTPAIN_CRIES_CRYING']);
			echo $cryingScore;
		    ?>     
		</td>
		<td>
		    <?php
			$cryingDDArray = array(0 => "No",
					     1 => "High pitched",
					     2 => "Inconsolable");
			$cryingDD = $Form->dropDown('CRIES-Crying',$cryingDDArray,'',$patient['ACTPAIN_CRIES_CRYING']);
			echo $cryingDD;
		    ?>    
		</td>
	    </tr>
	    <tr>
		<td>
		    Requires O2 for sat>95
		</td>
		<td>
		    <?php
			$requiresO2Score = $Form->textBox('CRIES-RequiresO2Score',$painData['ACTPAIN_CRIES_REQUIRESO2']);
			echo $requiresO2Score;
		    ?>    
		</td>
		<td>
		    <?php
			$requiresO2DDArray = array(0 => "No",
					     1 => "< 30%",
					     2 => "> 30%");
			$requiresO2DD = $Form->dropDown('CRIES-RequiresO2',$requiresO2DDArray,'',$patient['ACTPAIN_CRIES_REQUIRESO2']);
			echo $requiresO2DD;
		    ?>
		</td>
	    </tr>
	    <tr>
		<td>
		    Increased vital signs
		</td>
		<td>
		    <?php
			$vitalSignsScore = $Form->textBox('CRIES-VitalSignsScore',$painData['ACTPAIN_CRIES_VITALSIGNS']);
			echo $vitalSignsScore;
		    ?>    
		</td>
		<td>
		    <?php
			$vitalSignsDDArray = array(0 => "HR and BP = or < preop",
					     1 => "HR and BP < 20% preop",
					     2 => "HR and BP > 20% preop");
			$vitalSignsDD = $Form->dropDown('CRIES-VitalSigns',$vitalSignsDDArray,'',$patient['ACTPAIN_CRIES_VITALSIGNS']);
			echo $vitalSignsDD;
		    ?>
		</td>
	    </tr>
	    <tr>
		<td>
		    Expression
		</td>
		<td>
		    <?php
			$expressionScore = $Form->textBox('CRIES-ExpressionScore',$painData['ACTPAIN_CRIES_EXPRESSION']);
			echo $expressionScore;
		    ?>     
		</td>
		<td>
		    <?php
			$expressionDDArray = array(0 => "None",
					     1 => "Grimace",
					     2 => "Grimace/ grunt");
			$expressionDD = $Form->dropDown('CRIES-Expression',$expressionDDArray,'',$patient['ACTPAIN_CRIES_EXPRESSION']);
			echo $expressionDD;
		    ?>
		</td>
	    </tr>
	    <tr>
		<td>
		    Sleepless
		</td>
		<td>
		    <?php
			$sleeplessScore = $Form->textBox('CRIES-SleeplessScore',$painData['ACTPAIN_CRIES_SLEEPLESS']);
			echo $sleeplessScore;
		    ?>     
		</td>
		<td>
		    <?php
			$sleeplessDDArray = array(0 => "No",
					     1 => "Wakes at frequent intervals",
					     2 => "Constantly awake");
			$sleeplessDD = $Form->dropDown('CRIES-Sleepless',$sleeplessDDArray,'',$patient['ACTPAIN_CRIES_SLEEPLESS']);
			echo $sleeplessDD;
		    ?>
		</td>
	    </tr>
	    <tr>
		<td>
		    CRIES Total
		</td>
		<td>
		    <?php
			$CRIESTotalScore = $Form->textBox('CRIES-TotalScore',$painData['ACTPAIN_CRIES_TOTAL']);
			echo $CRIESTotalScore;
		    ?>     
		</td>
		<td>
		    &nbsp;
		</td>
	    </tr>
	</table>
    </fieldset>
       
    <?php
        $painSubmit = $Form->submitButton();
        echo $painSubmit;
    ?>
<?php
}
?>