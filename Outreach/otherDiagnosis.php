<?php
    $hiddenOtherDGNLNK = $Form->hiddenField('sdi-dgnLNK',$patient['LNK_DGNID']);
    echo $hiddenOtherDGNLNK;
?>
<td>

        <table>
            <tr><td colspan='100' class='linebreak_top'>Secondary reason for this episode</td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>

            <tr>
                <td>
                    <?php
                        $secondaryReasonForHospitalAdmission = $Form->textArea('sdi-secondaryDiagnosisNotes',$patient['DGN_ADMISSIONSECONDARYREASON'],50,10,'','FormText_long');
                        echo $secondaryReasonForHospitalAdmission;
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
            <tr><td colspan='100' class='linebreak_top'>Secondary reason for hospital admission</td></tr>
            <tr style='line-height:4px;'><td>&nbsp;</td></tr>
            
            <tr>
                <td colspan='2'>
                        <button type='button' style='font-size:small;' id='sdi-search-diagnosis'>Search diagnosis</button>
                        <div id='sdi-diagnosis-search-form' data-page='secondary' title='Search diagnosis'>                       

                                <div class="textBox">  
                                        Search <input type="search" value="" maxlength="500" name='sdi-searchDiag' id='sdi-searchDiag'>
                                            
                                        <!--<div class="diagnosisSearchBtn">  
                                            &nbsp;  
                                        </div>-->
                                        <div id="sdi-diagnosisResults">
                            
                                        </div>
                                </div>

                        </div>
                        
                </td>
            </tr>   
                
            <tr>
                <td class="form_labels">Type</td>
                <td>
                    <?php
                        /*$sdiType = $Form->textBox('sdi-secondaryDiagnosisType',$patient['DGN_REASON2_TYPE'],'','','FormField_long');
                        echo $sdiType;*/
                        $sdiTypeDDArray = array("Surgical","Non-surgical");
                        $sdiTypeDD = $Form->dropDown('sdi-Type',$sdiTypeDDArray,$sdiTypeDDArray,$patient['DGN_REASON2_TYPE']);
                        echo $sdiTypeDD;
                    ?>
                </td>
            </tr>
            <tr>
                <td class="form_labels">System</td>
                <td>
                    <?php
                        /*$sdiSystem = $Form->textBox('sdi-secondaryDiagnosisSystem',$patient['DGN_REASON2_SYSTEM'],'','','FormField_long');
                        echo $sdiSystem;*/
                        $sdiSystemDDArray = array();
                        $sdiSystemValueDD = array();
                        $query = "SELECT Description, Value, Sys_ID FROM System WHERE ".$Mela_SQL->sqlHUMinMax("Sys_ID")." ORDER BY Sys_ID ASC";
                        try { 
                            $result = odbc_exec($connect,$query); 
                            if($result){ 
                                    while ($systems = odbc_fetch_array($result)) {
                                        array_push($sdiSystemDDArray,$systems['DESCRIPTION']);
                                        array_push($sdiSystemValueDD,$systems['SYS_ID']);
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
                        
                        $sdiSystemDD = $Form->dropDown('sdi-System',$sdiSystemDDArray,$sdiSystemValueDD,$patient['DGN_REASON2_SYSTEM']);
                        echo $sdiSystemDD;
                    ?>
                </td>
            </tr>
            <tr>
                <td class="form_labels">Site</td>
                <td>
                    <?php
                        /*$sdiSite = $Form->textBox('sdi-secondaryDiagnosisSite',$patient['DGN_REASON2_SITE'],'','','FormField_long');
                        echo $sdiSite;*/
                        $sdiSiteDDArray = array();
                        $sdiSiteValueDD = array();
                        $query = "SELECT Site_ID, Sys_ID, Description, Value FROM Site WHERE".$Mela_SQL->sqlHUMinMax("Site_ID");
                        try { 
                            $result = odbc_exec($connect,$query); 
                            if($result){ 
                                    while ($systems = odbc_fetch_array($result)) {
                                        array_push($sdiSiteDDArray,$systems['DESCRIPTION']);
                                        array_push($sdiSiteValueDD,$systems['SITE_ID']);
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
            
                        $sdiSiteDD = $Form->dropDown('sdi-Site',$sdiSiteDDArray,$sdiSiteValueDD,$patient['DGN_REASON2_SITE']);
                        echo $sdiSiteDD;
                    ?>
                </td>
            </tr>
            <tr>
                <td class="form_labels">Process</td>
                <td>
                    <?php
                        /*$sdiProcess = $Form->textBox('sdi-secondaryDiagnosisProcess',$patient['DGN_REASON2_PROCESS'],'','','FormField_long');
                        echo $sdiProcess;*/
                        $sdiProcessDDArray = array();
                        $sdiProcessValueDD = array();
                        $query = "SELECT Site_ID, Proc_ID, Description, Value FROM Process WHERE".$Mela_SQL->sqlHUMinMax("Proc_ID");
                        try { 
                            $result = odbc_exec($connect,$query); 
                            if($result){ 
                                    while ($systems = odbc_fetch_array($result)) {
                                        array_push($sdiProcessDDArray,$systems['DESCRIPTION']);
                                        array_push($sdiProcessValueDD,$systems['PROC_ID']);
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
            
                        $sdiProcessDD = $Form->dropDown('sdi-Process',$sdiProcessDDArray,$sdiProcessValueDD,$patient['DGN_REASON2_PROCESS']);
                        echo $sdiProcessDD;
                    ?>
                </td>
            </tr>
            <tr>
                <td class="form_labels">Condition</td>
                <td>
                    <?php
                        /*$sdiCondition = $Form->textBox('sdi-secondaryDiagnosisCondition',$patient['DGN_REASON2_CONDITION'],'','','FormField_long');
                        echo $sdiCondition;*/
                        $sdiConditionDDArray = array();
                        $sdiConditionValueDD = array();
                        $query = "SELECT Proc_ID, Cond_ID, Description, Value, Code FROM Condition WHERE".$Mela_SQL->sqlHUMinMax("Cond_ID");
                        try { 
                            $result = odbc_exec($connect,$query); 
                            if($result){ 
                                    while ($systems = odbc_fetch_array($result)) {
                                        array_push($sdiConditionDDArray,$systems['DESCRIPTION']);
                                        array_push($sdiConditionValueDD,$systems['COND_ID']);
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
            
                        $sdiConditionDD = $Form->dropDown('sdi-Condition',$sdiConditionDDArray,$sdiConditionValueDD,$patient['DGN_REASON2_CONDITION']);
                        echo $sdiConditionDD;
                    ?>
                </td>
            </tr>
            <tr>
                <td class="form_labels">Code</td>
                <td>
                    <?php
                        $sdiCode = $Form->textBox('sdi-Code',$patient['DGN_REASON2_CODE'],'','','FormField_long');
                        echo $sdiCode;
                    ?>
                </td>
            </tr>
        </table>
        <?php } ?>
     
</td>