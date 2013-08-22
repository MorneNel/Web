<div class="Row1">
     
     <input type="hidden" name="dmg-ID" value="<?php echo $patient['DMG_ID']; ?>">
     <input type="hidden" name="lnk_ID" value="<?php echo $patient['LNK_ID']; ?>">

     <table>

         <tr><td colspan='2' class='linebreak_top'>Patient Detail</td></tr>
         <tr style='line-height:4px;'><td>&nbsp;</td></tr>

         <tr>
             <td class="form_labels">Hospital number</td>
                 <td>
                     <?php
                     $hospNum = $Form->textBox('dmg-hospitalNumber',$patient['DMG_HOSPITALNUMBER']);
                     echo $hospNum;
                     ?>
                 </td>
         </tr>

         <?php if ($preferences['prf_NHS_Number'] == 'true') { ?>
         <tr>
             <td class="form_labels">NHS number</td>
                 <td>
                     <?php
                             $NHSNum = $Form->textBox('dmg-NHSNumber',$patient['DMG_NHSNUMBER']);
                             echo $NHSNum;
                     ?>
                 </td>
         </tr>
         <?php } ?>
         <?php if ($preferences['NHS_Verification'] == 'true') { ?>
         <tr>
             <td class="form_labels">NHS No. Verification</td>
             <td>
                 <?php
                     $NHSNoVerDDSQL = $Mela_SQL->tbl_LoadItems('NHS No. Verification');
                     $NHSNoVerDDArray = array();
                     for ($i = 1; $i < (count($NHSNoVerDDSQL)+1); $i++) {
                         array_push($NHSNoVerDDArray,$NHSNoVerDDSQL[$i]['Long_Name']);
                     }

                     $NHSNoVerDD = $Form->dropDown('dmg-NHSVerification',$NHSNoVerDDArray,$NHSNoVerDDArray,$patient['NHS_VERIFICATION']);
                     echo $NHSNoVerDD;
                 ?>
             </td>
         </tr>
         <?php } ?>
        <?php if ($appName == "AcutePain") { ?>
         <tr>
             <td class="form_labels">Hospital Admission Date</td>
                 <td>
                     <!--<input type="date" class="FormDTDate" name="adm-ICUAdmission" value="<?php echo stringToDateTime($patient['ADM_ICUADMISSION'],2); ?>">-->
                     <?php
                         $dmgHospitalAdmissionDate = $Form->dateField('dmg-hospitalAdmissionDate',stringToDateTime($patient['ADM_HOSPITALADMISSION'],2));
                         echo $dmgHospitalAdmissionDate;
                     ?>
                 </td>
         </tr>
        <?php } ?>

         <tr>
             <td class="form_labels">Name</td>
                 <td>
                     <?php
                     $firstName = $Form->textBox('dmg-firstName',$patient['DMG_FIRSTNAME']);
                     echo $firstName;
                     ?>
                 </td>
         </tr>

         <tr>
             <td class="form_labels">Middle name</td>
                 <td>
                     <?php
                     $middleName = $Form->textBox('dmg-middleName',$patient['DMG_MIDDLENAME']);
                     echo $middleName;
                     ?>
                 </td>
         </tr>

         <tr>
             <td class="form_labels">Surname</td>
                 <td>
                     <?php
                     $surname = $Form->textBox('dmg-surname',$patient['DMG_SURNAME']);
                     echo $surname;
                     ?>
                 </td>
         </tr>

         <tr>
             <td class="form_labels">Date of birth</td>
             <td>
                 <?php
                     $dmgDateOfBirth = $Form->dateField('dmg-DOB',stringToDateTime($patient['DMG_DATEOFBIRTH'],2));
                     echo $dmgDateOfBirth;
                 ?>
             </td>
         </tr>

         <tr>
             <td class="form_labels">Age</td>
             <td class="InfoField">
                <div id='dmg-demAgeYears' style='display:inline-block;'>
                    <?php echo $patient['DMG_AGEYEARS']; ?>
                </div>
                 y &nbsp;
                <div id='dmg-demAgeMonths' style='display:inline-block;'>
                    <?php echo $patient['DMG_AGEMONTHS']; ?>
                </div>
                 m &nbsp;
                <div id='dmg-demAgeDays' style='display:inline-block;'>
                    <?php echo $patient['DMG_AGEDAYS']; ?>
                </div>
                 d &nbsp;
            </td>
         </tr>

         <tr>
             <td class="form_labels">Sex</td>
             <td>
                     <?php
                         $sexDDSQL = $Mela_SQL->tbl_LoadItems('Sex');
                         $sexDDArray = array();
                         for ($i = 1; $i < (count($sexDDSQL)+1); $i++) {
                             array_push($sexDDArray,$sexDDSQL[$i]['Long_Name']);
                         }

                         $sexDD = $Form->dropDown('dmg-sex',$sexDDArray,$sexDDArray,$patient['DMG_SEX']);
                         echo $sexDD;
                     ?>
             </td>
         </tr>
        
         <?php if ($preferences['show_Ethnicity'] == 'true') { ?>
         <tr>
             <td class="form_labels">Ethnicity</td>
             <td>
                 <?php
                         $ethnicDDSQL = $Mela_SQL->tbl_LoadItems('Ethnic Group');
                         $ethnicDDArray = array();
                         for ($i = 1; $i < (count($ethnicDDSQL)+1); $i++) {
                             array_push($ethnicDDArray,$ethnicDDSQL[$i]['Long_Name']);
                         }

                         $ethnicDD = $Form->dropDown('dmg-ethnicity',$ethnicDDArray,$ethnicDDArray,$patient['DMG_ETHNIC']);
                         echo $ethnicDD;
                 ?>   
             </td>
         </tr>
         <?php } ?>

         <?php if ($preferences['show_language'] == 'true') { ?>
         <tr>
             <td class="form_labels">Language</td>
             <td>
                 <?php
                         $languageDDSQL = $Mela_SQL->tbl_LoadItems('Language');
                         $languageDDArray = array();
                         for ($i = 1; $i < (count($languageDDSQL)+1); $i++) {
                             array_push($languageDDArray,$languageDDSQL[$i]['Long_Name']);
                         }

                         $languageDD = $Form->dropDown('dmg-language',$languageDDArray,$languageDDArray,$patient['LANGUAGE']);
                         echo $languageDD;
                 ?>
             </td>
         </tr>
         <?php } ?>

         <tr>
             <td class="form_labels">Pregnant</td>
             <td>
                 <?php
                 // Turn pregnant into checked or not option
                 $pregnantChecked = ($patient['PREGNANT'] != 'false') ? "checked" : "";
                 $pregnantCheckBox = $Form->checkBox('dmg-pregnant','dmg-pregnant','',$pregnantChecked);
                 echo $pregnantCheckBox;
                 ?>
             </td>
         </tr>

         <?php if ($preferences['prf_Weight'] == 'true') { ?>
         <tr>
             <td class="form_labels">Weight</td>
                 <td>
                     <?php
                     $weight = $Form->textBoxPhysiology('dmg-weight',$patient['ADM_WEIGHT']);
                     echo $weight." kg";
                     ?>
                 </td>
         </tr>
         <?php } ?>

         <?php if ($preferences['prf_Height'] == 'true') { ?>
         <tr>
             <td class="form_labels">Height</td>
                 <td>
                     <?php
                     $height = $Form->textBoxPhysiology('dmg-height',$patient['ADM_HEIGHT']);
                     echo $height." m";
                     ?>
                 </td>
         </tr>
         <?php } ?>

         <tr>
             <td class="form_labels">Body Mass Index</td>
                 <td>
                     <?php
                     $BMI = $Form->textBox('dmg-bodyMassIndex',$patient['ADM_BODYMASSINDEX'],'',1);
                     $BMIHidden = $Form->hiddenField('dmg-BMIHidden',$patient['ADM_BODYMASSINDEX']);
                     echo $BMI;
                     echo $BMIHidden;
                     ?>
                 </td>
         </tr>

         <?php if ($preferences['prf_showNormalBP'] == 'true') { ?>
         <tr>
             <td class="form_labels">Normal BP</td>
                 <td>
                     <?php
                     $normalBP = $Form->textBox('dmg-normalBP',$patient['DMG_NORMAL_BP']);
                     echo $normalBP;
                     ?>
                 </td>
         </tr>
         <?php } ?>
         <?php if ($appName == "Outreach") { ?>
         <tr>
             <td class="form_labels">Event number</td>
                 <td>
                     <?php
                     $eventNum = $Form->textBox('dmg-eventNumber',$patient['ADM_NUMBER']);
                     echo $eventNum;
                     ?>
                 </td>
         </tr>
         
         <tr>
             <td class="form_labels">Outreach + Resus</td>
             <td>
                 <table>
                     <tr><td class="TicCell"><input type="checkbox" class="RadioTic" name="dmg-outreachResus" <?php  ?>></td></tr>
                 </table>
             </td>
         </tr>
         <?php } ?>

     </table>
 </div>

 <!--<div class="Row2" style="float:left; padding-left:50px;">-->
 <div class="Row2">
     <table>
         <?php if ($preferences['prf_ShowAddress'] == 'true' && $preferences['prf_ShowPostCode'] == 'false') { ?>
         <tr>
             <td class="form_labels">Address</td>
                 <td>
                     <?php
                     $address = $Form->textBox('dmg-address',$patient['DMG_ADDRESS']);
                     echo $address;
                     ?>
                 </td>
         </tr>
         

         <tr>
             <td class="form_labels">Town</td>
             <td>
                 <?php
                     $townDDSQL = $Mela_SQL->tbl_LoadItems('Town');
                     $townDDArray = array();
                     for ($i = 1; $i < (count($townDDSQL)+1); $i++) {
                         array_push($townDDArray,$townDDSQL[$i]['Long_Name']);
                     }

                     $townDD = $Form->dropDown('dmg-town',$townDDArray,$townDDArray,$patient['DMG_TOWN']);
                     echo $townDD;
                 ?>
             </td>
         </tr>

         <tr>
             <td class="form_labels">County</td>
             <td>
                 <?php
                     $countyDDSQL = $Mela_SQL->tbl_LoadItems('County');
                     $countyDDArray = array();
                     for ($i = 1; $i < (count($countyDDSQL)+1); $i++) {
                         array_push($countyDDArray,$countyDDSQL[$i]['Long_Name']);
                     }

                     $countyDD = $Form->dropDown('dmg-county',$countyDDArray,$countyDDArray,$patient['DMG_COUNTY']);
                     echo $countyDD;
                 ?>
             </td>
         </tr>
         <?php } ?>

         <?php if ($preferences['prf_ShowPostCode'] == 'true' || $preferences['prf_ShowAddress'] == 'true') { ?>
         <tr>
             <td class="form_labels">Postcode</td>
             <td>
                 <?php
                     $postcode = $Form->textBox('dmg-postCode',$patient['DMG_POSTCODE']);
                     echo $postcode;
                 ?>
             </td>
         </tr>
         <?php } ?>

         <tr>
             <td class="form_labels">Country</td>
             <td>
                 <?php
                     $countryDDSQL = $Mela_SQL->tbl_LoadItems('Country');
                     $countryDDArray = array();
                     for ($i = 1; $i < (count($countryDDSQL)+1); $i++) {
                         array_push($countryDDArray,$countryDDSQL[$i]['Long_Name']);
                     }

                     $countryDD = $Form->dropDown('dmg-country',$countryDDArray,$countryDDArray,$patient['DMG_COUNTRY']);
                     echo $countryDD;
                 ?>
             </td>
         </tr>


         <tr>
             <td class="form_labels">Phone</td>
             <td>
                 <?php
                     $phone = $Form->textBox('dmg-phone',$patient['DMG_PHONE']);
                     echo $phone;
                 ?>
             </td>
         </tr>

         <!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
         <!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
         <!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
         <?php if ($preferences['prf_ShowNOKDetails'] == 'true') { ?>
         <tr style='line-height:4px;'><td>&nbsp;</td></tr>
         <tr><td colspan='2' class='linebreak_top'>Next of Kin</td></tr>
         <tr style='line-height:4px;'><td>
         <?php if ($preferences['prf_ShowAddress'] == 'true' && $preferences['prf_ShowPostCode'] == 'false') { ?><button type="button" style="font-size:small;" name="NOKSame" id="NOKSame">Same as Patient</button><?php } ?></td></tr>
         
         <tr>
             <td class="form_labels">Name</td>
             <td>
                 <?php
                     $NOK = $Form->textBox('dmg-NOK',$patient['DMG_NOK']);
                     echo $NOK;
                 ?>
             </td>
         </tr>

         <tr>
             <td class="form_labels">Phone</td>
             <td>
                 <?php
                     $NOKPhone = $Form->textBox('dmg-NOKPhone',$patient['DMG_NOK_PHONE']);
                     echo $NOKPhone;
                 ?>
             </td>
         </tr>

         <tr>
             <td class="form_labels">Relation</td>
             <td>
                 <?php
                     $NOKRelationDDSQL = $Mela_SQL->tbl_LoadItems('Relation');
                     $NOKRelationDDArray = array();
                     for ($i = 1; $i < (count($NOKRelationDDSQL)+1); $i++) {
                         array_push($NOKRelationDDArray,$NOKRelationDDSQL[$i]['Long_Name']);
                     }

                     $NOKRelationDD = $Form->dropDown('dmg-NOKRelation',$NOKRelationDDArray,$NOKRelationDDArray,$patient['DMG_NOK_RELATION']);
                     echo $NOKRelationDD;
                 ?>
             </td>
         </tr>
         <?php if ($preferences['prf_ShowAddress'] == 'true' && $preferences['prf_ShowPostCode'] == 'false') { ?>
         <tr>
             <td class="form_labels">Address</td>
             <td>
                 <?php
                     $NOKAddress = $Form->textBox('dmg-NOKAddress',$patient['DMG_NOK_ADDRESS']);
                     echo $NOKAddress;
                 ?>
             </td>
         </tr>
         
         <tr>
             <td class="form_labels">Town</td>
             <td>
                 <?php
                     $NOKTownDDSQL = $Mela_SQL->tbl_LoadItems('Town');
                     $NOKTownDDArray = array();
                     for ($i = 1; $i < (count($NOKTownDDSQL)+1); $i++) {
                         array_push($NOKTownDDArray,$NOKTownDDSQL[$i]['Long_Name']);
                     }

                     $NOKTownDD = $Form->dropDown('dmg-NOKTown',$NOKTownDDArray,$NOKTownDDArray,$patient['DMG_NOK_TOWN']);
                     echo $NOKTownDD;
                 ?>   
             </td>
         </tr>
         <tr>
             <td class="form_labels">County</td>
             <td>
                 <?php
                     $NOKCountyDDSQL = $Mela_SQL->tbl_LoadItems('County');
                     $NOKCountyDDArray = array();
                     for ($i = 1; $i < (count($NOKCountyDDSQL)+1); $i++) {
                         array_push($NOKCountyDDArray,$NOKCountyDDSQL[$i]['Long_Name']);
                     }

                     $NOKCountyDD = $Form->dropDown('dmg-NOKCounty',$NOKCountyDDArray,$NOKCountyDDArray,$patient['DMG_NOK_COUNTY']);
                     echo $NOKCountyDD;
                 ?> 
             </td>
         </tr>
         <?php } ?>
         <tr>
             <td class="form_labels">Postcode</td>
             <td>
                 <?php
                     $NOKPostCode = $Form->textBox('dmg-NOKPostCode',$patient['DMG_NOK_POSTCODE']);
                     echo $NOKPostCode;
                 ?>
             </td>
         </tr>

         <tr>
             <td class="form_labels">Country</td>
             <td>
                 <?php
                     $NOKCountryDDSQL = $Mela_SQL->tbl_LoadItems('Country');
                     $NOKCountryDDArray = array();
                     for ($i = 1; $i < (count($NOKCountryDDSQL)+1); $i++) {
                         array_push($NOKCountryDDArray,$NOKCountryDDSQL[$i]['Long_Name']);
                     }

                     $NOKCountryDD = $Form->dropDown('dmg-NOKCountry',$NOKCountryDDArray,$NOKCountryDDArray,$patient['DMG_NOK_COUNTRY']);
                     echo $NOKCountryDD;
                 ?> 
             </td>
         </tr>
         <?php } ?>
         <?php if (($appName == "AcutePain") && ($auth->UsrKeys->UserGrpName == "Post Op")) { ?>
            <tr>
                <td class="form_labels">
                    Referral Date
                </td>
                <td>
                    <?php
                        $admReferralDate = $Form->dateField('adm-referralDate',stringToDateTime($patient['ADM_REFERRALDATE'],2));
                        echo $admReferralDate;
                    ?>
                </td>
            </tr>
            <tr>
                <td class="form_labels">Location</td>
                <td>
                        <?php
                                $wardsDDSQL = $Mela_SQL->tbl_LoadItems('Wards');
                                $wardsDDArray = array();
                                for ($i = 1; $i < (count($wardsDDSQL)+1); $i++) {
                                    array_push($wardsDDArray,$wardsDDSQL[$i]['Long_Name']);
                                }
        
                                $wardsDD = $Form->dropDown('adm-location',$wardsDDArray,$wardsDDArray,$patient['ADM_WARD']);
                                echo $wardsDD;                         
                        ?>        
                </td>
            </tr>
            <tr class="adm-priorSurgeryHide">
                <td class="form_labels">ASA Score</td>
                <td>
                    <?php
                    $ASAScores = array("I", "II", "III", "IV", "V", "E", "N");
                    
                    $ASAScoreDD = $Form->dropDown('adm-ASAScoreDD',$ASAScores,$ASAScores,$patient['ASASCORE']);
                    echo $ASAScoreDD;
                    
                    $ASAScoreTextArea = $Form->textArea('adm-ASAScoreTextBox','','','','','','adm-ASAScoreTextBox');
                    echo $ASAScoreTextArea;
                    ?>
                </td>
            </tr>
         <?php } ?>
         
     </table>
 </div>