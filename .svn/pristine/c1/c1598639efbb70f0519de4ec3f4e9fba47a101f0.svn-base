<script src="media/js/jquery-1.10.0.min.js"></script>
<script src="media/js/closeEditPages.js"></script>
<?php

include './MelaClass/Mela_Forms.php';
include './MelaClass/db.php';
include './MelaClass/authInitScript.php';

$Form = new Mela_Forms('editAgents','','POST','agents_form');

if (!$_REQUEST['dlk'] || !$_REQUEST['lnk'] || !$_REQUEST['row']) die("Vital information missing");

$dlk = filter_var($_REQUEST['dlk'], FILTER_SANITIZE_NUMBER_INT);
$lnk = filter_var($_REQUEST['lnk'], FILTER_SANITIZE_NUMBER_INT);
$row = filter_var($_REQUEST['row'], FILTER_SANITIZE_NUMBER_INT);

$query = "SELECT ia.Agents_Result, itm.Description
          FROM Infection_Agents ia
          LEFT OUTER JOIN Items_agents itm ON ia.ID = itm.ID
          WHERE ia.ID=$row AND ia.agent_dlkID=$dlk AND ia.agent_lnkID=$lnk AND ia.ID=itm.ID";
    try { 
        $result = odbc_exec($connect,$query); 
        if($result){ 
               $agent = odbc_fetch_array($result);
        } 
        else{ 
        throw new RuntimeException("Failed to connect."); 
        } 
            } 
        catch (RuntimeException $e) { 
                print("Exception caught: $e");
                //exit;
        }
        
$hiddenRow = $Form->hiddenField('row',$row);
$hiddenDLK = $Form->hiddenField('dlk',$dlk);
$hiddenLNK = $Form->hiddenField('lnk',$lnk);

echo $hiddenRow;
echo $hiddenDLK;
echo $hiddenLNK;

if (!$_POST) {
    
    print "<table class='temp'>
           <tbody>
            <tr>
                <td>
                    Description
                </td>
                <td>";
                    $description = $Form->textBox('agentDescription',$agent['DESCRIPTION'],'',1);
                    print $description;
                print "</td>
            </tr>
            <tr>
                <td>
                Result
                </td>
                <td>";
                    $dose = $Form->textBox('agentResult',$agent['AGENTS_RESULT']);
                    print $dose;
                print "</td>
            </tr>
            <tr>
                <td colspan='2'>";
                $submit = $Form->submitButton('Submit');
                echo $submit;
                print "</td>
            </tr>
           </tbody>
           </table>";
} else {
    $result = (is_numeric($_POST['agentResult'])) ? filter_var($_POST['agentResult'], FILTER_SANITIZE_NUMBER_INT) : filter_var($_POST['agentResult'], FILTER_SANITIZE_STRING);
    $rowID = $_POST['row'];
    $dlkID = $_POST['dlk'];
    $lnkID = $_POST['lnk'];
    $hiddenResult = $Form->hiddenField('hiddenResult',$result);
    
    // Need to check that the record is properly locked first of all
    if ($Mela_SQL->Exec4DSQL("SQLLock_IsLocked", $lnkID) == 1) {
        $query = "UPDATE Infection_Agents SET Agents_Result='$result' WHERE ID=$rowID AND agent_dlkID=$dlkID AND agent_lnkID=$lnkID";
        try { 
            $result = odbc_exec($connect,$query); 
            if($result){ 
                ?>
                <script type="text/javascript">
                    CloseAndRefresh('row','hiddenResult','agnotes'); 
                </script>
                <?php   
            } 
            else { 
                throw new RuntimeException("Failed to connect."); 
            } 
        } 
        catch (RuntimeException $e) { 
            print("Exception caught: $e");
        }
    } else {
        echo '<div style="height:100%; width:100%;">
		<div class="failurebox" style="vertical-align: middle; text-align: center; margin-left: auto; margin-right: auto; border: 3px solid #A52A2A; background-color: #CD5C5C; color: #330000; height:50%; width:50%;">
		    <span style="vertical-align: middle; height: 100%;">
			<h2>
			    Record Locking Error
			</h2>
			The selected record was not locked and therefore data were not safe to save. 
			<br />
			<button type="button" style="font-size:small;color:red" onclick="failedRecordLock()">Please click here to return to patient listing</button>
		    </span>
		</div>
	    </div>';
    }
}