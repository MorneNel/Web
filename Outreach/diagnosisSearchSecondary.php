<style type="text/css">
.searchRow:hover {
    color: red;
    cursor: pointer;
}
</style>
<script language="javascript">
    $(document).ready(function(){
        $('.searchRow').click(function(){
            var data = $(this).data();
            //alert(data['conval']);
            console.debug(data);
            $('#sdi-System').empty();
            $('#sdi-System').load("fillDiagDropdown.php?dd=sdi-System");
            $('#sdi-Site').empty();
            $('#sdi-Site').load("fillDiagDropdown.php?dd=sdi-Site");
            $('#sdi-Process').empty();
            $('#sdi-Process').load("fillDiagDropdown.php?dd=sdi-Process");
            $('#sdi-Condition').empty();
            $('#sdi-Condition').load("fillDiagDropdown.php?dd=sdi-Condition", function(response) {
            
            $('#sdi-System').val(data['sysval']);
            $('#sdi-Site').val(data['sitval']);
            $('#sdi-Process').val(data['proval']);
            $('#sdi-Condition').val(data['conval']);
            
            $('#sdi-System option[value=' + data['sysval'] + ']').text(data['sysdesc']);
            $('#sdi-Site option[value=' + data['sitval'] + ']').text(data['sitdesc']);
            $('#sdi-Process option[value=' + data['proval'] + ']').text(data['prodesc']);
            $('#sdi-Condition option[value=' + data['conval'] + ']').text(data['condesc']);
            
            $.ajax({
		   type: "POST",
		   url: "getDiagnosisCode.php",
		   data: "procID=" + data['procid'] + "&description=" + data['condesc'],
		   success: function(msg){
		    $('#sdi-Code').val(msg);
		   },
		   error: function(XMLHttpRequest, textStatus, errorThrown) { 
			alert("Status: " + textStatus); alert("Error: " + errorThrown); 
		    } 
		 });
            
            $('#sdi-diagnosis-search-form').dialog( "close" );
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
    $sql = "SELECT con.Description AS CON_DESCRIPTION, con.Value AS CON_VALUE, con.Proc_ID,
            pro.Site_ID, pro.Description AS PRO_DESCRIPTION, pro.Value AS PRO_VALUE,
            sit.Sys_ID, sit.Description AS SIT_DESCRIPTION, sit.Value AS SIT_VALUE,
            sys.Sys_ID, sys.Description AS SYS_DESCRIPTION, sys.Value AS SYS_VALUE
            FROM Condition con
            LEFT OUTER JOIN Process pro ON con.Proc_ID = pro.Proc_ID
            LEFT OUTER JOIN Site sit ON pro.Site_ID = sit.Site_ID
            LEFT OUTER JOIN System sys ON sit.Sys_ID = sys.Sys_ID
            WHERE con.Description LIKE '%$formattedString%' AND ".$Mela_SQL->sqlHUMinMax("con.Cond_ID");
}

else exit;

$update = odbc_exec($connect, $sql);

$rowCount = 0;
while ($row = odbc_fetch_array($update))

{
  echo "<span class='searchRow' data-condesc='".$row['CON_DESCRIPTION']."' data-conval='".$row['CON_VALUE']."' data-procid='".$row['PROC_ID']."' data-prodesc='".$row['PRO_DESCRIPTION']."' data-proval='".$row['PRO_VALUE']."' data-sitdesc='".$row['SIT_DESCRIPTION']."' data-sitval='".$row['SIT_VALUE']."' data-sysdesc='".$row['SYS_DESCRIPTION']."' data-sysval='".$row['SYS_VALUE']."'>".$row['CON_DESCRIPTION']."</span><br />";
  $rowCount++;
  }
  
if ($rowCount == 0) {
    print "<tr class='each_rec'><td colspan=2>No results found</td></tr>";
}

?>