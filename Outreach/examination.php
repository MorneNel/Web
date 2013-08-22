<table class='temp'>
    <tr>
        <td>
            Weight
        </td>
        <td>
            <?php
                    $weight = $Form->textBox('exam-Weight',$patient['PAT_WEIGHT']);
                    echo $weight . "Kg";
            ?>
        </td>
    </tr>
</table>

<table class='temp'>
    <tr>
        <td>
            Medical
        </td>
        <td>
            <?php
                    $medical = $Form->textArea('exam-Medical',$patient['PAT_PHYSEXAM']);
                    echo $medical;
            ?>    
        </td>
    </tr>
    <tr>
        <td>
            Psychologist
        </td>
        <td>
            <?php
                    $psychologist = $Form->textArea('exam-Psychologist',$patient['PAT_PSYCOEXAM']);
                    echo $psychologist;
            ?>
        </td>
    </tr>
    <tr>
        <td>
            Physiotherapist
        </td>
        <td>
            <?php
                    $physio = $Form->textArea('exam-Physiotherapist',$patient['PAT_PHYIOEXAM']);
                    echo $physio;
            ?>
        </td>
    </tr>
</table>