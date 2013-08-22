<?php

include './MelaClass/Mela_Forms.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

if (!$_REQUEST['dlkpatid']) die("DLKPatID information missing");

$dlkPatID = filter_var($_REQUEST['dlkpatid'], FILTER_SANITIZE_NUMBER_INT);
$dlkID = filter_var($_REQUEST['dlkid'], FILTER_SANITIZE_NUMBER_INT);

$query = "SELECT pat_PaO2, pat_FIO2, pat_Systolic_BP, pat_Diastolic_BP,
          pat_Serum_Creatinine, pat_Platelet, pat_Serum_Bilirubin, pat_GCS  
          FROM PhyAssess_AtTime
          WHERE pat_ID=$dlkPatID";
    try { 
        $result = odbc_exec($connect,$query); 
        if($result){ 
            $phyAssess = odbc_fetch_array($result);
        } 
        else { 
            throw new RuntimeException("Failed to connect."); 
        } 
    } 
    catch (RuntimeException $e) { 
        print("Exception caught: $e");
    }
    
?>
<!DOCTYPE html>
    <html lang="en">
        <head>
            <script src="media/js/jquery-1.10.0.min.js"></script>
            <script>
                function calculateSOFA(dlk_ID) {
                    $.ajax({
                        type: "POST",
                        url: "calculateSOFA.php",
                        data: "dlkid=" + dlk_ID,
                        async: false,
                        success: function(msg){
                            var SOFAArr = msg.split('	');
                            
                            $('#sofa-vlSOFA').val(SOFAArr[0]);
                            $('#sofa-vlOXG').val(SOFAArr[1]);
                            $('#sofa-vlGCS').val(SOFAArr[2]);
                            $('#sofa-vlCAR').val(SOFAArr[3]);
                            $('#sofa-vlRENAL').val(SOFAArr[4]);
                            $('#sofa-vlPLATE').val(SOFAArr[5]);
                            $('#sofa-vlBILI').val(SOFAArr[6]);
                            //$('#sofa-pao2').val(SOFAArr[7]);
                            //$('#sofa-fio2').val(SOFAArr[8]);
                            $('#sofa-vent').val(SOFAArr[9]);
                            $('#sofa-gcs').val(SOFAArr[10]);
                            //$('#sofa-systolicBP').val(SOFAArr[11]);
                            //$('#sofa-diastolicBP').val(SOFAArr[12]);
                            $('#sofa-vrDopamine').val(SOFAArr[13]);
                            $('#sofa-vrDobutamine').val(SOFAArr[14]);
                            $('#sofa-vrEpine').val(SOFAArr[15]);
                            $('#sofa-vrNorepine').val(SOFAArr[16]);
                            //$('#sofa-creatinine').val(SOFAArr[17]);
                            //$('#sofa-platelet').val(SOFAArr[18]);
                            //$('#sofa-bilirubin').val(SOFAArr[19]);
                            //alert("Data was updated");
                            //alert(msg);
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                             rowID = 'Invalid';
                             alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
                        } 
                    }); 
                }
                
                function saveField(field, value) {
                    var dlkpatID = $('#hiddenpatDLK').val();
                    var dlk_ID = $('#hiddenDLK').val();
                    $.ajax({
                        type: "POST",
                        url: "saveSOFA.php",
                        data: "field=" + field + "&value=" + value + "&dlkpatid=" + dlkpatID,
                        async: false,
                        success: function(msg){
                            if (msg.length == 1) {
                                calculateSOFA(dlk_ID);
                            } else alert("A non-numeric value was returned, indicating a database query failure");                            
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
                        } 
                    }); 
                }
                
                $(document).ready(function() {
                    var dlk_ID = $('#hiddenDLK').val();
                    calculateSOFA(dlk_ID);
                        
                    /*$('#SOFA_form').change(function() {
                        var dlk_ID = $('#hiddenDLK').val();
                        //calculateSOFA(dlk_ID);
                        var that = $(this).attr('id');
                        alert("You clicked "+that);
                    });*/
                    $('#sofa-pao2').change(function() {
                       var value = $(this).val();
                       saveField('sofa-pao2',value); 
                    });
                    
                    $('#sofa-fio2').change(function() {
                       var value = $(this).val();
                       saveField('sofa-fio2',value); 
                    });
                    
                    $('#sofa-systolicBP').change(function() {
                       var value = $(this).val();
                       saveField('sofa-systolicBP',value); 
                    });
                    
                    $('#sofa-diastolicBP').change(function() {
                       var value = $(this).val();
                       saveField('sofa-diastolicBP',value); 
                    });
                    
                    $('#sofa-creatinine').change(function() {
                       var value = $(this).val();
                       saveField('sofa-creatinine',value); 
                    });
                    
                    $('#sofa-platelet').change(function() {
                       var value = $(this).val();
                       saveField('sofa-platelet',value); 
                    });
                    
                    $('#sofa-bilirubin').change(function() {
                        var value = $(this).val();
                        saveField('sofa-bilirubin',value); 
                    });
                    
                    $('#closePage').click(function() {
                        var SOFAScore = $('#sofa-vlSOFA').val();
                        window.opener.$('#phys-SOFAScore').val(SOFAScore);
                        self.close(); 
                    });
                });
            </script>
        </head>
        <body>
            <?php
                $Form = new Mela_Forms('SOFA','','POST','SOFA_form');
                echo $hiddenDLK = $Form->hiddenField('hiddenDLK',$dlkID);
                echo $hiddenpatDLK = $Form->hiddenField('hiddenpatDLK',$dlkPatID);
                $specialClass = array("updateMarker");
            ?>
            <table class="temp">
                <tr>
                    <td>
                        <fieldset>
                            <legend>
                                Respiratory system
                            </legend>
                            <table class="temp">
                                <tr>
                                    <td>
                                        PaO2
                                    </td>
                                    <td>
                                        <?php
                                            $PAO2 = $Form->textBoxPhysiology('sofa-pao2',$phyAssess['PAT_PAO2'],'','',$specialClass);
                                            echo $PAO2.$preferences['prf_PaO2'];
                                        ?>
                                    </td>
                                    <td>
                                        FiO2
                                    </td>
                                    <td>
                                        <?php
                                            $FIO2 = $Form->textBoxPhysiology('sofa-fio2',$phyAssess['PAT_FIO2'],'','',$specialClass);
                                            echo $FIO2;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Ventilated
                                    </td>
                                    <td>
                                        <?php
                                            $vent = $Form->textBoxPhysiology('sofa-vent',0,'',1);
                                            echo $vent;
                                        ?>
                                    </td>
                                    <td colspan='2'>
                                        &nbsp;
                                    </td>
                                </tr>
                            </table>
                        </fieldset>     
                    </td>
                    <td>
                        <?php
                            $vlOXG = $Form->textBoxPhysiology('sofa-vlOXG',0,'',1);
                            echo $vlOXG;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <fieldset>
                            <legend>
                                Neurological system
                            </legend>
                            <table class="temp">
                                <tr>
                                    <td>
                                        GCS
                                    </td>
                                    <td>
                                        <?php
                                            $GCS = $Form->textBoxPhysiology('sofa-gcs',$phyAssess['PAT_GCS'],'',1);
                                            echo $GCS;
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                    <td>
                        <?php
                            $vlGCS = $Form->textBoxPhysiology('sofa-vlGCS',0,'',1);
                            echo $vlGCS;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <fieldset>
                            <legend>
                                Cardiovascular system
                            </legend>
                            <table class="temp">
                                <tr>
                                    <td>
                                        Systolic BP
                                    </td>
                                    <td>
                                        <?php
                                            $systolicBP = $Form->textBoxPhysiology('sofa-systolicBP',$phyAssess['PAT_SYSTOLIC_BP'],'','',$specialClass);
                                            echo $systolicBP."mmHG";
                                        ?>
                                    </td>
                                    <td>
                                        Diastolic BP
                                    </td>
                                    <td>
                                        <?php
                                            $diastolicBP = $Form->textBoxPhysiology('sofa-diastolicBP',$phyAssess['PAT_DIASTOLIC_BP'],'','',$specialClass);
                                            echo $diastolicBP."mmHG";
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Dopamine
                                    </td>
                                    <td>
                                        <?php
                                            $vrDopamine = $Form->textBoxPhysiology('sofa-vrDopamine',0,'',1);
                                            echo $vrDopamine;
                                        ?>
                                    </td>
                                    <td>
                                        Dobutamine
                                    </td>
                                    <td>
                                        <?php
                                            $vrDobutamine = $Form->textBoxPhysiology('sofa-vrDobutamine',0,'',1);
                                            echo $vrDobutamine;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Epinephrine
                                    </td>
                                    <td>
                                        <?php
                                            $vrEpine = $Form->textBoxPhysiology('sofa-vrEpine',0,'',1);
                                            echo $vrEpine;
                                        ?>
                                    </td>
                                    <td>
                                        Norepinephrine
                                    </td>
                                    <td>
                                        <?php
                                            $vrNorepine = $Form->textBoxPhysiology('sofa-vrNorepine',0,'',1);
                                            echo $vrNorepine;
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                    <td>
                        <?php
                            $vlCAR = $Form->textBoxPhysiology('sofa-vlCAR',0,'',1);
                            echo $vlCAR;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <fieldset>
                            <legend>
                                Renal system
                            </legend>
                            <table class="temp">
                                <tr>
                                    <td>
                                        Creatinine
                                    </td>
                                    <td>
                                        <?php
                                            $creatinine = $Form->textBoxPhysiology('sofa-creatinine',$phyAssess['PAT_SERUM_CREATININE'],'','',$specialClass);
                                            echo $creatinine."&micro;mol / l";
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                    <td>
                        <?php
                            $vlRENAL = $Form->textBoxPhysiology('sofa-vlRENAL',0,'',1);
                            echo $vlRENAL;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <fieldset>
                            <legend>
                                Coagulation
                            </legend>
                            <table class="temp">
                                <tr>
                                    <td>
                                        Platelet count
                                    </td>
                                    <td>
                                        <?php
                                            $platelet = $Form->textBoxPhysiology('sofa-platelet',$phyAssess['PAT_PLATELET'],'','',$specialClass);
                                            echo $platelet."x10<sup>9</sup> / l";
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                    <td>
                        <?php
                            $vlPLATE = $Form->textBoxPhysiology('sofa-vlPLATE',0,'',1);
                            echo $vlPLATE;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <fieldset>
                            <legend>
                                Bilirubin
                            </legend>
                            <table class="temp">
                                <tr>
                                    <td>
                                        Bilirubin
                                    </td>
                                    <td>
                                        <?php
                                            $bilirubin = $Form->textBoxPhysiology('sofa-bilirubin',$phyAssess['PAT_SERUM_BILIRUBIN'],'','',$specialClass);
                                            echo $bilirubin."&micro;mol / l";
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </td>
                    <td>
                        <?php
                            $vlBILI = $Form->textBoxPhysiology('sofa-vlBILI',0,'',1);
                            echo $vlBILI;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        SOFA
                    </td>
                    <td>
                        <?php
                            $vlSOFA = $Form->textBoxPhysiology('sofa-vlSOFA',0,'',1);
                            echo $vlSOFA;
                        ?>
                    </td>
                </tr>
            </table>
            <button type='button' id='closePage'>Close window</button>
        </body>
    </html>