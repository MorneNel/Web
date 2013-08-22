<button type="button" id="addRespCare" data-lnkid='<?php echo $patient['LNK_ID']; ?>'>Add Resp Care</button>
<table class="temp pl_class" id="respiteCare" style="margin-top: 15px;">
    <thead>
        <tr>
            <th class="pl_header">
                <p>
                    <a href="#">
                        Date From
                    </a>
                </p>
            </th>
            <th class="pl_header">
                <p>
                    <a href="#">
                        Date To
                    </a>
                </p>
            </th>
            <th class="pl_header">
                <p>
                    <a href="#">
                        Shift
                    </a>
                </p>
            </th>
            <th class="pl_header">
                <p>
                    <a href="#">
                        Staff Name
                    </a>
                </p>
            </th>
            <th class="pl_header">
                <p>
                    <a href="#">
                        
                    </a>
                </p>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT resp.Respite_Care_ID, resp.DateFrom, resp.DateTo, resp.Shift, med.mds_Name
        FROM RespiteCare resp, MedStaff med
        WHERE resp.CareStaff=med.mds_ID AND ".$Mela_SQL->sqlHUMinMax("mds_ID")."";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
                while ($respite = odbc_fetch_array($result)) {
                    echo "<tr data-lnkid='".$patient['LNK_ID']."' data-respcareid='".$respite['RESPITE_CARE_ID']."'>
                            <td data-lnkid='".$patient['LNK_ID']."' data-respcareid='".$respite['RESPITE_CARE_ID']."'>
                                ".explode(' ', $respite['DATEFROM'])[0]."
                            </td>
                            <td data-lnkid='".$patient['LNK_ID']."' data-respcareid='".$respite['RESPITE_CARE_ID']."'>
                                ".explode(' ', $respite['DATETO'])[0]."
                            </td>
                            <td data-lnkid='".$patient['LNK_ID']."' data-respcareid='".$respite['RESPITE_CARE_ID']."'>
                                ".$respite['SHIFT']."
                            </td>
                            <td data-lnkid='".$patient['LNK_ID']."' data-respcareid='".$respite['RESPITE_CARE_ID']."'>
                                ".$respite['MDS_NAME']."
                            </td>
                            <td id='Button_cell'>
                                <button id='".$respite['RESPITE_CARE_ID']."' type='button' class='deleteRow' data-page='respiteCare'><img src='Media/img/bin.gif' alt='Delete'/></button>
                            </td>
                          </tr>";
                }
            } 
            else { 
                throw new RuntimeException("Failed to connect."); 
            } 
        } 
        catch (RuntimeException $e) { 
            print("Exception caught: $e");
        }
        ?>
    </tbody>
</table>