<script src="media/js/jquery-1.10.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() 
    {
        function popitup(url,windowName, data) {
                    // Data can contain additional info to get tacked on to the end of the URL
                    if (typeof data === "undefined") {
                        newwindow=window.open(url,windowName,'height=450,width=575');
                    } else {
                        var fullURL = url + data;
                        newwindow=window.open(fullURL,windowName,'height=450,width=575');
                    }			
                    if (window.focus) {newwindow.focus()}
                    return false;
        }
        
        /*
        * Make the paed pain score buttons on Pain assessment
        * open up the padPainScores.php window
        */
        $('.paedPainButton').click(function() {
           var data = $(this).data();
           var ID = "?row=" + data['id'];
           popitup('paedPainScores.php','Paedeatric Pain',ID);
        });
    });
</script>
<?php
include './MelaClass/Mela_Forms.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

$Form = new Mela_Forms('paedPainScore','','POST','paedPain_form');

$otrID = filter_var($_REQUEST['otr_ID'], FILTER_SANITIZE_NUMBER_INT);

$otr_query="SELECT actpain_FaceScore, actpain_VAS, actpain_FLACC_Total, actpain_CRIES_Total
            FROM Outreach
            WHERE otr_ID = $otrID";
try { 
    $result = odbc_exec($connect,$otr_query); 
    if($result){ 
        $paedPain = odbc_fetch_array($result);   
    } 
    else{ 
        throw new RuntimeException("Failed to connect."); 
    } 
} 
catch (RuntimeException $e) { 
    print("Exception caught: $e");
}
?>

<table class='temp PA_Table'>
    <tr>
        <?php if ($preferences['FacesScore'] == 'true') { ?>
        <td>
            <button type='button' class="paedPainButton" data-id="<?php echo $otrID; ?>">Faces Score</button>
        </td>
        <td>
            <?php
                $paedFacesScore = $Form->textBox('painass-paedFacesScore',$paedPain['ACTPAIN_FACESCORE']);
                echo $paedFacesScore;
            ?>
        </td>
        <?php } ?>
        
        <?php if ($preferences['CriesScore'] == 'true') { ?>
        <td>
            <button type='button' class="paedPainButton" data-id="<?php echo $otrID; ?>">CRIES Total</button>
        </td>
        <td>
            <?php
                $paedCRIESScore = $Form->textBox('painass-paedCRIESScore',$paedPain['ACTPAIN_CRIES_TOTAL']);
                echo $paedCRIESScore;
            ?>
        </td>
        <?php } ?>
        
        <td colspan='2'>&nbsp;</td>
    </tr>
    <tr>
        <?php if ($preferences['VasScore'] == 'true') { ?>
        <td>
            <button type='button' class="paedPainButton" data-id="<?php echo $otrID; ?>">VAS Score</button>
        </td>
        <td>
            <?php
                $paedVAS = $Form->textBox('painass-paedVAS',$paedPain['ACTPAIN_VAS']);
                echo $paedVAS;
            ?>
        </td>
        <?php } ?>
        
        <?php if ($preferences['FlaccScore'] == 'true') { ?>
        <td>
            <button type='button' class="paedPainButton" data-id="<?php echo $otrID; ?>">FLACC Total</button>
        </td>
        <td>
            <?php
                $paedFLACCScore = $Form->textBox('painass-paedFLACCScore',$paedPain['ACTPAIN_FLACC_TOTAL']);
                echo $paedFLACCScore;
            ?>
        </td>
        <?php } ?>
        
        <td colspan='2'>&nbsp;</td>
    </tr>
</table>