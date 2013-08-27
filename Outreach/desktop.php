

<?php

// if (!$_REQUEST['lnkID']) die("Patient ID must be specified!");

// $lnkID = filter_var($_REQUEST['lnkID'],FILTER_VALIDATE_INT);

// $query = "SELECT d.dmg_ID, d.dmg_FirstName, d.dmg_MiddleName, d.dmg_Surname, d.dmg_DateOfBirth, d.dmg_Sex, d.dmg_NHSNumber, d.dmg_HospitalNumber,
//             a.adm_Number,
//             l.lnk_ID
//             FROM Demographic d
//             LEFT OUTER JOIN LINK l ON d.dmg_ID = l.lnk_dmgID
//             LEFT OUTER JOIN Admission a ON a.adm_ID = l.lnk_admID
//             WHERE l.lnk_ID=$lnkID";
// try { 
//     $result = odbc_exec($connect,$query); 
//     if($result){ 
//         $patient = odbc_fetch_array($result);	
//     } 
//     else { 
//         throw new RuntimeException("Failed to connect."); 
//     } 
// } 
// catch (RuntimeException $e) { 
//     print("Exception caught: $e");
// }
?>

  <style>
        #Icon-wrapper{height: 120px;}
        #Dsk_Adm { width: 310px; height: 105px; padding-top: 0; margin: 5px;}
        #Dsk_Adm h3 { text-align: center; margin: 0; }

        #Dsk_Ass { width: 465px; height: 105px; padding-top: 0; margin: 5px;}
        #Dsk_Ass h3{ text-align: center; margin: 0; }

        #Dsk_Out { width: 155px; height: 105px; padding-top: 0; margin: 5px;}
        #Dsk_Out h3{ text-align: center; margin: 0; }

        .Dsk_container{float: left;}

        .Dsk_Icon{  width: 65px; 
                        height: 70px; 
                        float: left;
                        margin: 5px;
                        text-align: center;
                        border-radius: 5px;
                    }


        .Dsk_Icon a{
            font-size: 9px;
        }

        #pListing-wrapper{  height: 500px;
                            padding-bottom: 5px;
                         }
        #Icon-wrapper{  height: 115px;
                        text-align: center;
                     }


  </style>


  <script>
      $(function() {
        $( "#Dsk_Adm" ).draggable({ containment: "parent" });
        $( "#Dsk_Out" ).draggable({ containment: "parent" });
        $( "#Dsk_Ass" ).draggable({ containment: "parent" });

        $( ".Dsk_Icon" ).draggable({ containment: "parent" });
        $( ".Dsk_Icon" ).draggable({ revert: true });
      });





  </script>



<div id="pListing-wrapper">
    <p>
        Make the selected elements draggable by mouse. If you want not just drag, but drag & drop, see the jQuery UI Droppable plugin, which provides a drop target for draggables.
    </p>
</div>


 <div id="Icon-wrapper">


        <div id="Dsk_Adm" class="Dsk_container ui-widget-content">
            <h3 class="ui-widget-header">Admission</h3>
            <div class="Dsk_Icon ui-widget-content">
                <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-1">
                    <img src="media/images/icons/DVR2.bmp"><br />
                    Demographics
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-2">
                    <img src="media/images/icons/DVR2.bmp"><br />
                  Admission & Referral
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-6">
                    <img src="media/images/icons/DVR2.bmp"><br />
                    History & Co-morbidity
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="diagnosis.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-6">
                    <img src="media/images/icons/DVR2.bmp"><br />
                    Diagnosis
                </a>
            </div>
        </div>




        <div id="Dsk_Ass" class="Dsk_container ui-widget-content">
            <h3 class="ui-widget-header">Assessment</h3>
            <div class="Dsk_Icon ui-widget-content">
                <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-1">
                    <img src="media/images/icons/DVR2.bmp"><br />
                    Assess detail
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-2">
                    <img src="media/images/icons/DVR2.bmp"><br />
                    Observation
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-6">
                    <img src="media/images/icons/DVR2.bmp"><br />
                    Investigation
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="diagnosis.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-6">
                    <img src="media/images/icons/DVR2.bmp"><br />
                    Management
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="diagnosis.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-6">
                    <img src="media/images/icons/DVR2.bmp"><br />
                    Visit Outcome
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="diagnosis.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-6">
                    <img src="media/images/icons/DVR2.bmp"><br />
                    Tasks
                </a>
            </div>
        </div>


        <div id="Dsk_Out" class="Dsk_container ui-widget-content">
            <h3 class="ui-widget-header">Outcome</h3>
            <div class="Dsk_Icon ui-widget-content">
                <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-1">
                    <img src="media/images/icons/DVR2.bmp"><br />
                    Outreach Discharge
                </a>
            </div>

            <div class="Dsk_Icon ui-widget-content">
                <a href="patDmg.php?lnkID=<?php echo $patient['LNK_ID']; ?>#page-6">
                    <img src="media/images/icons/DVR2.bmp"><br />
                    Summary
                </a>
            </div>
        </div>

</div>





