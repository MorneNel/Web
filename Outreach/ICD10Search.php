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
            console.debug(data);
            
            /*//alert(data['conval']);            
            //$('#pdi-System').empty();         
            //$('#pdi-System').load("fillDiagDropdown.php?dd=pdi-System").val(data['sysval']);
            //changeDropDown('pdi-Process','pdi-Site');
            //changeDropDown('pdi-Condition','pdi-Process');            
            $('#pdi-System').val(data['sysval']);
            $('#pdi-Site').val(data['sitval']);
            $('#pdi-Process').val(data['proval']);
            $('#pdi-Condition').val(data['conval']);            
            $('#pdi-System option[value=' + data['sysval'] + ']').text(data['sysdesc']);
            $('#pdi-Site option[value=' + data['sitval'] + ']').text(data['sitdesc']);
            $('#pdi-Process option[value=' + data['proval'] + ']').text(data['prodesc']);
            $('#pdi-Condition option[value=' + data['conval'] + ']').text(data['condesc']);*/
            
            //$('#ICD10-search-form').dialog( "close" );
            
        });
        
        $('.addICD10Row').click(function() {
		CLRow = 1;
		var data = $(this).data();
		var id = data['id'];
		var description = data['description'];
		var code = data['code'];
                var type = data['type'];
                var lnk = data['lnk'];
                
                var typeWord = (type == 1) ? 'Procedure' : 'Condition';
                var windowClass = (type == 1) ? '#ICD10-search-form-procedure' : '#ICD10-search-form-condition';
		
		$.ajax({
		   type: "POST",
		   url: "addICD10Row.php",
		   data: "lnk_ID=" + lnk + "&ICD10_ID=" + id,
		   async: false,
		   success: function(msg){
		     rowID = msg;
		     if (isNaN(rowID)) {
			alert( "Error: " + msg );
		     } else {
			CLRow = 1;
		     }
		   },
		   error: function(XMLHttpRequest, textStatus, errorThrown) {
			rowID = 'Invalid';
			alert(" Status: " + textStatus + "\n Error message: "+ errorThrown); 
		    } 
		 });		
		
		if (CLRow == 1) {
                    var tr = $(
                        '<tr><td>' + code + '</td>' 
                        + '<td>' + description + '</td>'
                        + '<td>' + typeWord + '</td>'
                        + '<td><button id="' + id + '" type="button" class="deleteICD10Row"><img src="Media/img/bin.gif" alt="Delete"/></button></td></tr>');	
                
                
                    $('.ICD10Records > tbody:last').one().append(tr);
                    $('#ICD10Results').dialog( "close" );
		    console.debug(windowClass);

		    CLRow = 0;	
		}
	});

    });
</script>
<?php

include './MelaClass/functions.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

$searchString = filter_var($_REQUEST['search'], FILTER_SANITIZE_STRING);
$formattedString = ucfirst(strtolower($searchString));

$lnk = $_REQUEST['lnk'];

if (!$_REQUEST['type'] || !is_numeric($_REQUEST['type']) || $_REQUEST['type'] > 2) die("Type is not a valid value");

$type = ($_REQUEST['type'] == 1) ? 1 : 2;

if($formattedString)
{
    $sql = "SELECT DISTINCT  ID, Description, Code
            FROM ICD10
            WHERE lower(Description) LIKE lower('%$formattedString%')
            AND Type=$type
            AND Active=True";
}

else exit;

$update = odbc_exec($connect, $sql);


echo "<br />
<table>
<tr>
<td class='selected_table'>";


  echo "<table class='ICD10Records_pop ICD10_list'>
    <thead>
        <tr>
            <th>Description</th>
            <th>Code</th>
        </tr>
    </thead>

    <tbody>";
        $rowCount = 0;
        while ($row = odbc_fetch_array($update))
        {
        echo "<tr>
                <td>
                    <span class='searchRow addICD10Row cat' data-id='".$row['ID']."' data-description='".$row['DESCRIPTION']."' data-code='".$row['CODE']."' data-type='$type' data-lnk='$lnk'>".$row['DESCRIPTION']."</span><br />
                </td>
                <td>
                    <span class='searchRow addICD10Row sel' data-id='".$row['ID']."' data-description='".$row['DESCRIPTION']."' data-code='".$row['CODE']."' data-type='$type' data-lnk='$lnk'>".$row['CODE']."</span><br />
                </td>
            </tr>";
        $rowCount++;
        }
    echo "</tbody>
</table>";


echo "</table>
</tr>
</td>";




// $rowCount = 0;
// while ($row = odbc_fetch_array($update))
// {
//   echo "<span class='searchRow addICD10Row' data-id='".$row['ID']."' data-description='".$row['DESCRIPTION']."' data-code='".$row['CODE']."' data-type='$type' data-lnk='$lnk'>".$row['ID']." - ".$row['DESCRIPTION']." - ".$row['CODE']."</span><br />";
//   $rowCount++;
// }
  
if ($rowCount == 0) {
    print "<span class='searchRow'>No results found</span>";
}

?>