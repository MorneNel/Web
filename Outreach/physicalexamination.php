<?php
$hiddenpatDLK = $Form->hiddenField('hiddenpatDLK',$patient['DLK_PATID']);
echo $hiddenpatDLK;
if ($preferences['Show_PandP_in_PhysExam'] == 'true') { ?>
<table>
    	<tr style='line-height:4px;'><td>&nbsp;</td></tr>
    	<tr style='line-height:4px;'><td>&nbsp;</td></tr>
        <tr><td colspan='100' class='linebreak_top'>Medical</td></tr>
        <tr style='line-height:4px;'><td>&nbsp;</td></tr>

        <tr>      
	    <td width="25%">
		<div class="categoryBox">
		    <?php
			$physExDDSQL = $Mela_SQL->tbl_LoadItems('Physical Examination');
			$physExDDArray = array();
			for ($i = 1; $i < (count($physExDDSQL)+1); $i++) {
			    array_push($physExDDArray,$physExDDSQL[$i]['Long_Name']);
			}

			foreach($physExDDArray AS $row) {
				echo "<div class='tag' data-type='medical'>
				      <label class='form_labels'>
				      ".$row."
				      </label>
				      </div>";
			}
                    ?>
		</div>
	    </td>
	    <td>
		<div class="textbox">
		    <textarea class="categoryBox_text" id="medicalTextArea" name="phye-medical" rows="15" cols="500"><?php echo $patient['PAT_PHYSEXAM']; ?></textarea>
		</div>
	    </td>
        </tr>
</table>

<table>
    	<tr style='line-height:4px;'><td>&nbsp;</td></tr>
    	<tr style='line-height:4px;'><td>&nbsp;</td></tr>
        <tr><td colspan='100' class='linebreak_top'>Psychologist</td></tr>
        <tr style='line-height:4px;'><td>&nbsp;</td></tr>

        <tr>      
	    <td width="25%">
		<div class="categoryBox">
		    <?php
			$physExDDSQL = $Mela_SQL->tbl_LoadItems('Psychologist Examination');
			$physExDDArray = array();
			for ($i = 1; $i < (count($physExDDSQL)+1); $i++) {
			    array_push($physExDDArray,$physExDDSQL[$i]['Long_Name']);
			}

			foreach($physExDDArray AS $row) {
				echo "<div class='tag' data-type='psycho'>
				      <label class='form_labels'>
				      ".$row."
				      </label>
				      </div>";
			}
                    ?>
		</div>
	    </td>
	    <td>
		<div class="textbox">
		    <textarea class="categoryBox_text" id="psychoTextArea" name="phye-pyscho" rows="15" cols="500"><?php echo $patient['PAT_PSYCOEXAM']; ?></textarea>
		</div>
	    </td>
        </tr>
</table>

<table>
    	<tr style='line-height:4px;'><td>&nbsp;</td></tr>
    	<tr style='line-height:4px;'><td>&nbsp;</td></tr>
        <tr><td colspan='100' class='linebreak_top'>Physiotherapist</td></tr>
        <tr style='line-height:4px;'><td>&nbsp;</td></tr>

        <tr>      
	    <td width="25%">
		<div class="categoryBox">
		    <?php
			$physExDDSQL = $Mela_SQL->tbl_LoadItems('Physiotherapist Examination');
			$physExDDArray = array();
			for ($i = 1; $i < (count($physExDDSQL)+1); $i++) {
			    array_push($physExDDArray,$physExDDSQL[$i]['Long_Name']);
			}

			foreach($physExDDArray AS $row) {
				echo "<div class='tag' data-type='physio'>
				      <label class='form_labels'>
				      ".$row."
				      </label>
				      </div>";
			}
                    ?>
		</div>
	    </td>
	    <td>
		<div class="textbox">
		    <textarea class="categoryBox_text" id="physioTextArea" name="phye-physio" rows="15" cols="500"><?php echo $patient['PAT_PHYIOEXAM']; ?></textarea>
		</div>
	    </td>
        </tr>
</table>

<?php } else { ?>
<table>
    	<tr style='line-height:4px;'><td>&nbsp;</td></tr>
    	<tr style='line-height:4px;'><td>&nbsp;</td></tr>
        <tr><td colspan='100' class='linebreak_top'>Summary</td></tr>
        <tr style='line-height:4px;'><td>&nbsp;</td></tr>

        <tr>      
	    <td width="25%">
		<div class="categoryBox">
		    <?php
			$physExDDSQL = $Mela_SQL->tbl_LoadItems('Physical Examination');
			$physExDDArray = array();
			for ($i = 1; $i < (count($physExDDSQL)+1); $i++) {
			    array_push($physExDDArray,$physExDDSQL[$i]['Long_Name']);
			}

			foreach($physExDDArray AS $row) {
				echo "<div class='tag' data-type='medical'>
				      <label class='form_labels'>
				      ".$row."
				      </label>
				      </div>";
			}
                    ?>
		</div>
	    </td>
	    <td>
		<div class="textbox">
		    <textarea class="categoryBox_text" id="medicalTextArea" name="phye-medical" rows="15" cols="500"><?php echo $patient['PAT_PHYSEXAM']; ?></textarea>
		</div>
	    </td>
        </tr>
    </table>
<?php } ?>
