<script type="text/javascript">
    function popitup(url,windowName) {
       newwindow=window.open(url,windowName,'height=450,width=575');
       if (window.focus) {newwindow.focus()}
       return false;
    }    
    
    $('tbody tr[data-href]').addClass('clickable').click( function() { 
        popitup($(this).attr('data-href'));
    });     
    
    $('#surgerySearch').tablesorter({ sortList: [0,0] });
</script>

<?php
include './MelaClass/functions.php';
include './MelaClass/Mela_Forms.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

if (!$_REQUEST['lnkid']) {
    die("No lnk ID specified");
} else {
    $LNKID = filter_var($_REQUEST['lnkid'], FILTER_SANITIZE_NUMBER_INT);
}

$rec = ucfirst(strtolower(checkValues($_REQUEST['search'])));
//get table contents

if($rec)
{
    $sql = "SELECT Oper_Code, Oper_Title, Oper_Name FROM OPER_Codes where lower(Oper_Name) LIKE lower('%$rec%') OR lower(Oper_Title) LIKE lower('%$rec$') AND".$Mela_SQL->sqlHUMinMax("Oper_ID");
}

else exit;

$update = odbc_exec($connect, $sql);

echo "<table class='tablesorter temp' id='surgerySearch' width='100%'>
<thead>
<tr>
<th>Code</th>
<th>Name</th>
</tr>
</thead>
<tbody>";
$rowCount = 0;
while ($row = odbc_fetch_array($update))

{
  echo "<tr class='each_rec' data-href='surgeryPopup.php?lnkid=".$LNKID."&code=".$row['OPER_CODE']."'>";
  echo "<td>" . $row['OPER_CODE'] . "</td>";
  echo "<td>" . $row['OPER_NAME'] . "</td>";
  echo "</tr>";
  $rowCount++;
  }
  
if ($rowCount == 0) {
    print "<tr class='each_rec'><td colspan=2>No results found</td></tr>";
}
echo "</tbody></table>";

?>