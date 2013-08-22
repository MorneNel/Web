<?php
error_reporting(E_ALL ^ E_NOTICE);
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

if (!$_REQUEST['lnkID']) die("Patient ID must be specified!");

$lnkID = filter_var($_REQUEST['lnkID'],FILTER_VALIDATE_INT);

$query = "SELECT d.dmg_ID, d.dmg_FirstName, d.dmg_MiddleName, d.dmg_Surname, d.dmg_DateOfBirth, d.dmg_Sex, d.dmg_NHSNumber, d.dmg_HospitalNumber,
            a.adm_Number,
            l.lnk_ID
            FROM Demographic d
            LEFT OUTER JOIN LINK l ON d.dmg_ID = l.lnk_dmgID
            LEFT OUTER JOIN Admission a ON a.adm_ID = l.lnk_admID
            WHERE l.lnk_ID=$lnkID";
try { 
    $result = odbc_exec($connect,$query); 
    if($result){ 
        $patient = odbc_fetch_array($result);	
    } 
    else { 
        throw new RuntimeException("Failed to connect."); 
    } 
} 
catch (RuntimeException $e) { 
    print("Exception caught: $e");
}
?>




<!-- <!DOCTYPE html>
<html lang="en">
    <head>
        <link type="text/css" rel="stylesheet" href="media/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="media/css/desktop.css">
        <title>Patient Desktop</title>
    </head>
    <body> -->




     <!--    <div class="patientPanel">
            <ul class="patientDemographics">
                <li><?php echo $patient['DMG_FIRSTNAME']." ".$patient['DMG_MIDDLENAME']." ".$patient['DMG_SURNAME']; ?>
                <li><?php echo $patient['DMG_SEX']; ?>
                <li>DOB: <?php echo $patient['DMG_DATEOFBIRTH']; ?>
                <li>NHS: <?php echo $patient['DMG_NHSNUMBER']; ?>
                <li>Hospital: <?php echo $patient['DMG_HOSPITALNUMBER']; ?>
                <li>Admission: <?php echo $patient['ADM_NUMBER']; ?>
            </ul>
        </div>
        <div class="leftbar">
            <ul class="leftPanel"> 
                <li>Log out
                <li>Save
                <li>Cancel
            </ul>
        </div>
        <div class="mainPanel">
            <div class="box">
                <h3>
                    Admission
                </h3> 
                <div class="icon_container">
                    <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-1">
                        <img src="media/images/icons/DVR2.bmp"><Br />
                        Demographics
                    </a>
                </div>
                <div class="icon_container">
                    <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-2">
                        <img src="media/images/icons/DVR2.bmp"><Br />
                        Admission & Referral
                    </a>
                </div>
                <div class="icon_container">
                    <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-6">
                        <img src="media/images/icons/DVR2.bmp"><Br />
                        Co-morbidity
                    </a>
                </div>
            </div>
            
            <div class="box">
                <h3>
                    Assessments
                </h3>
                <div class="icon_container">
                    <img src="media/images/icons/DVR2.bmp"><Br />
                        Assessment Detail
                </div>
                <div class="icon_container">
                    <img src="media/images/icons/DVR2.bmp"><Br />
                        Physical Examination
                </div>
                <div class="icon_container">
                    <img src="media/images/icons/DVR2.bmp"><Br />
                        Physiology
                </div>
            </div>
            
            <div class="box">
                <h3>
                    Assessments
                </h3>
                <div class="icon_container">
                    <img src="media/images/icons/DVR2.bmp"><Br />
                        Assessment Detail
                </div>
                <div class="icon_container">
                    <img src="media/images/icons/DVR2.bmp"><Br />
                        Physical Examination
                </div>
                <div class="icon_container">
                    <img src="media/images/icons/DVR2.bmp"><Br />
                        Physiology
                </div>
            </div>
            
            <div style="clear:both;"></div>
            
            <div class="box">
                <h3>
                    Title3
                </h3>
                <div class="icon_container">
                    <img src="media/images/icons/DVR2.bmp"><Br />
                        Text
                </div>
                <div class="icon_container">
                    <img src="media/images/icons/DVR2.bmp"><Br />
                        Text2
                </div>
                <div class="icon_container">
                    <img src="media/images/icons/DVR2.bmp"><Br />
                        Text3
                </div>
                <div class="icon_container">
                    <img src="media/images/icons/DVR2.bmp"><Br />
                        Text4
                </div>
                <div class="icon_container">
                    <img src="media/images/icons/DVR2.bmp"><Br />
                        Text5
                </div>
                <div class="icon_container">
                    <img src="media/images/icons/DVR2.bmp"><Br />
                        Text6
                </div>
                <div class="icon_container">
                    <img src="media/images/icons/DVR2.bmp"><Br />
                        Text7
                </div>
                <div class="icon_container">
                    <img src="media/images/icons/DVR2.bmp"><Br />
                        Text8
                </div>
                <div class="icon_container">
                    <img src="media/images/icons/DVR2.bmp"><Br />
                        Text9
                </div>
            </div>
        </div> -->







<!--     </body>
</html> -->

