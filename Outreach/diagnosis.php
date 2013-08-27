<?php
    $hiddenDGNLNK = $Form->hiddenField('pdi-dgnLNK',$patient['LNK_DGNID']);
    echo $hiddenDGNLNK;
?>
<td>

        <table>
            <tr><td colspan='100' class='linebreak_top'>Reason for hospital admission (notes)</td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>

            <tr>
                <td>
                    <?php
                        $reasonForHospitalAdmission = $Form->textArea('pdi-primaryDiagnosisNotes',$patient['DGN_ADMISSIONPRIMARYREASON'],450,10,'','FormText_long');
                        echo $reasonForHospitalAdmission;
                    ?>
                </td>
            </tr>
        </table>


        <table>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
        </table>

        <?php if ($appName == "Outreach") { ?>
        <table>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
            <tr><td colspan='100' class='linebreak_top'>
                <?php if ($appName == "Outreach") { ?>
                    Primary Diagnosis
                <?php } elseif ($appName == "AcutePain") { ?>
                    Reason for hospital admission (notes)
                <?php } ?>
                </td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
            
            <tr>
                <td colspan='2'>
                        <button type='button' style='font-size:small;' id='search-diagnosis'>Search diagnosis</button>
                        <div id='diagnosis-search-form' data-page='primary' title='Search diagnosis'>                       
                            <form>
                            <fieldset>
                                <div class="textBox">  
                                        <input type="search" value="" maxlength="500" name='searchDiag' id='searchDiag'>
                                            
                                        <!--<div class="diagnosisSearchBtn">  
                                            &nbsp;  
                                        </div>-->
                                        <div id="firstdiagnosisResults">
                            
                                        </div>
                                </div>
                            </fieldset>
                            </form>
                            
                        </div>
                        
                </td>
            </tr>
            <tr>
                <td class="form_labels">Type</td>
                <td>
                    <?php                        
                        $pdiTypeDDArray = array("Surgical","Non-surgical");
                        $pdiTypeDD = $Form->dropDown('pdi-Type',$pdiTypeDDArray,$pdiTypeDDArray,$patient['DGN_REASON1_TYPE']);
                        echo $pdiTypeDD;
                    ?>
                </td>
            </tr>
            <tr>
                <td class="form_labels">System</td>
                <td>
                    <?php
                        $pdiSystemDDArray = array();
                        $pdiSystemValueDD = array();
                        $query = "SELECT Description, Value, Sys_ID FROM System WHERE ".$Mela_SQL->sqlHUMinMax("Sys_ID")." ORDER BY Sys_ID ASC";
                        try { 
                            $result = odbc_exec($connect,$query); 
                            if($result){ 
                                    while ($systems = odbc_fetch_array($result)) {
                                        array_push($pdiSystemDDArray,$systems['DESCRIPTION']);
                                        array_push($pdiSystemValueDD,$systems['SYS_ID']);
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
                            
                        $pdiSystemDD = $Form->dropDown('pdi-System',$pdiSystemDDArray,$pdiSystemValueDD,$patient['DGN_REASON1_SYSTEM']);
                        echo $pdiSystemDD;
                    ?>
                </td>
            </tr>
            <tr>
                <td class="form_labels">Site</td>
                <td>
                    <?php
                        $pdiSiteDDArray = array();
                        $pdiSiteValueDD = array();
                        $query = "SELECT Site_ID, Sys_ID, Description, Value FROM Site WHERE ".$Mela_SQL->sqlHUMinMax("Site_ID");
                        try { 
                            $result = odbc_exec($connect,$query); 
                            if($result){ 
                                    while ($systems = odbc_fetch_array($result)) {
                                        array_push($pdiSiteDDArray,$systems['DESCRIPTION']);
                                        array_push($pdiSiteValueDD,$systems['SITE_ID']);
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
            
                        $pdiSiteDD = $Form->dropDown('pdi-Site',$pdiSiteDDArray,$pdiSiteValueDD,$patient['DGN_REASON1_SITE']);
                        echo $pdiSiteDD;
                    ?>
                </td>
            </tr>
            <tr>
                <td class="form_labels">Process</td>
                <td>
                    <?php
                        $pdiProcessDDArray = array();
                        $pdiProcessValueDD = array();
                        $query = "SELECT Site_ID, Proc_ID, Description, Value FROM Process WHERE ".$Mela_SQL->sqlHUMinMax("Proc_ID");
                        try { 
                            $result = odbc_exec($connect,$query); 
                            if($result){ 
                                    while ($systems = odbc_fetch_array($result)) {
                                        array_push($pdiProcessDDArray,$systems['DESCRIPTION']);
                                        array_push($pdiProcessValueDD,$systems['PROC_ID']);
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
            
                        $pdiProcessDD = $Form->dropDown('pdi-Process',$pdiProcessDDArray,$pdiProcessValueDD,$patient['DGN_REASON1_PROCESS']);
                        echo $pdiProcessDD;
                    ?>
                </td>
            </tr>
            <tr>
                <td class="form_labels">Condition</td>
                <td>
                    <?php
                        $pdiConditionDDArray = array();
                        $pdiConditionValueDD = array();
                        $query = "SELECT Proc_ID, Cond_ID, Description, Value, Code FROM Condition WHERE ".$Mela_SQL->sqlHUMinMax("Cond_ID");
                        try { 
                            $result = odbc_exec($connect,$query); 
                            if($result){ 
                                    while ($systems = odbc_fetch_array($result)) {
                                        array_push($pdiConditionDDArray,$systems['DESCRIPTION']);
                                        array_push($pdiConditionValueDD,$systems['COND_ID']);
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
            
                        $pdiConditionDD = $Form->dropDown('pdi-Condition',$pdiConditionDDArray,$pdiConditionValueDD,$patient['DGN_REASON1_CONDITION']);
                        echo $pdiConditionDD;
                    ?>
                    <select style="display: none; visibility: hidden;" name="hiddenDiag"><option value="1"></option></select>
                </td>
            </tr>
            <tr>
                <td class="form_labels">Code</td>
                <td>
                    <?php
                        $pdiCode = $Form->textBox('pdi-Code',$patient['DGN_REASON1_CODE'],'','','FormField_long');
                        echo $pdiCode;
                    ?>
                </td>
            </tr>
        </table>


        <table>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
        </table>

        <?php if ($preferences['prf_ShowCustomDiagnosis'] == 'true') { ?>
        <table>
            <tr>
                <td class="form_labels">Custom Diagnosis</td>
                <td>
                    <?php
                        $customDiagnosisDDSQL = $Mela_SQL->tbl_LoadItems('Custom Diagnosis');
                        $customDiagnosisDDArray = array();
                        for ($i = 1; $i < (count($customDiagnosisDDSQL)+1); $i++) {
                            array_push($customDiagnosisDDArray,$customDiagnosisDDSQL[$i]['Long_Name']);
                        }

                        $customDiagnosisDD = $Form->dropDown('dia-customDiagnosis',$customDiagnosisDDArray,$customDiagnosisDDArray,$patient['DGN_NONICNARC_REASON']);
                        echo $customDiagnosisDD;
                    ?>
                </td>
            </tr>
        </table>
        <?php } ?>
        
        <?php } ?>
      
</td>

