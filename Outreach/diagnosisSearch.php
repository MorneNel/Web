<style type="text/css">
.searchRow:hover {
/*    color: red;
    cursor: pointer;*/
}
</style>
<script language="javascript">
    $(document).ready(function(){
        $('.searchRow').click(function(){
            var data = $(this).data();
            //alert(data['conval']);
            console.debug(data);
            $('#pdi-System').empty();
            $('#pdi-System').load("fillDiagDropdown.php?dd=pdi-System");
            $('#pdi-Site').empty();
            $('#pdi-Site').load("fillDiagDropdown.php?dd=pdi-Site");
            $('#pdi-Process').empty();
            $('#pdi-Process').load("fillDiagDropdown.php?dd=pdi-Process");
            $('#pdi-Condition').empty();
            $('#pdi-Condition').load("fillDiagDropdown.php?dd=pdi-Condition", function(response) {
            
            $('#pdi-System').val(data['sysid']);
            $('#pdi-Site').val(data['sitid']);
            $('#pdi-Process').val(data['proid']);
            $('#pdi-Condition').val(data['condid']);
            
            $('#pdi-System option[value=' + data['sysid'] + ']').text(data['sysdesc']);
            $('#pdi-Site option[value=' + data['sitid'] + ']').text(data['sitdesc']);
            $('#pdi-Process option[value=' + data['proid'] + ']').text(data['prodesc']);
            $('#pdi-Condition option[value=' + data['condid'] + ']').text(data['condesc']);
            
            console.debug(data['sysid']);
            console.debug(data['sitid']);
            console.debug(data['proid']);
            console.debug(data['condid']);
            
            $.ajax({
		   type: "POST",
		   url: "getDiagnosisCode.php",
		   data: "procID=" + data['condid'] + "&description=" + data['condesc'],
		   success: function(msg){
		    $('#pdi-Code').val(msg);
		   },
		   error: function(XMLHttpRequest, textStatus, errorThrown) { 
			alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		    } 
		 });
            
            $('#diagnosis-search-form').dialog( "close" );
            });
            
        });
    });
</script>
<?php

$searchString = filter_var($_REQUEST['search'], FILTER_SANITIZE_STRING);

include './MelaClass/functions.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

$formattedString = ucfirst(strtolower($searchString));

if($formattedString)
{
    $sql = "SELECT con.Description AS CON_DESCRIPTION, con.Value AS COND_VALUE, con.Cond_ID,
            pro.Site_ID, pro.Proc_ID, pro.Description AS PRO_DESCRIPTION, pro.Value AS PRO_VALUE,
            sit.Sys_ID, sit.Site_ID, sit.Description AS SIT_DESCRIPTION, sit.Value AS SIT_VALUE,
            sys.Sys_ID, sys.Description AS SYS_DESCRIPTION, sys.Value AS SYS_VALUE
            FROM Condition con
            LEFT OUTER JOIN Process pro ON con.Proc_ID = pro.Proc_ID
            LEFT OUTER JOIN Site sit ON pro.Site_ID = sit.Site_ID
            LEFT OUTER JOIN System sys ON sit.Sys_ID = sys.Sys_ID
            WHERE con.Description LIKE '%$formattedString%' AND ".$Mela_SQL->sqlHUMinMax("con.Cond_ID");
}

else exit;

$update = odbc_exec($connect, $sql);

print      "<table class='CO_Table'>
                <tr class='CO_TableRow'>
                    <td class='selected_table_diag'>
                        <table class='MOTable temp SelTable' id='tasks'>
                            <thead>
                                <tr>
                                    <th>Diagnosis</th>
                                </tr>
                            </thead>
                            <tbody>";

$rowCount = 0;
while ($row = odbc_fetch_array($update))

{
  // echo "<span class='searchRow' data-condesc='".$row['CON_DESCRIPTION']."' data-conval='".$row['COND_VALUE']."' data-condid='".$row['COND_ID']."' data-prodesc='".$row['PRO_DESCRIPTION']."' data-proval='".$row['PRO_VALUE']."' data-proID='".$row['PROC_ID']."', data-sitdesc='".$row['SIT_DESCRIPTION']."' data-sitval='".$row['SIT_VALUE']."' data-sitID='".$row['SITE_ID']."', data-sysdesc='".$row['SYS_DESCRIPTION']."' data-sysval='".$row['SYS_VALUE']."' data-sysID='".$row['SYS_ID']."'>".$row['CON_DESCRIPTION']."</span><br />";
  
print      "        <tr>
                        <td class='searchRow' data-condesc='".$row['CON_DESCRIPTION']."' data-conval='".$row['COND_VALUE']."' data-condid='".$row['COND_ID']."' data-prodesc='".$row['PRO_DESCRIPTION']."' data-proval='".$row['PRO_VALUE']."' data-proID='".$row['PROC_ID']."', data-sitdesc='".$row['SIT_DESCRIPTION']."' data-sitval='".$row['SIT_VALUE']."' data-sitID='".$row['SITE_ID']."', data-sysdesc='".$row['SYS_DESCRIPTION']."' data-sysval='".$row['SYS_VALUE']."' data-sysID='".$row['SYS_ID']."'>".$row['CON_DESCRIPTION']."</td>
                    </tr>";

  $rowCount++;
  }
  


if ($rowCount == 0) {
    print "<tr class='each_rec'><td colspan=2>No results found</td></tr>";
}

print      "                </tbody>
                        </table>
                    </td>
                </tr>
            </table>";


?>