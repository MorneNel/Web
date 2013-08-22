<table class='temp'>
    <tr>
        <td>
            Outcome
        </td>
        <td>
            <?php
                $outcomeOutcomeDDSQL = $Mela_SQL->tbl_LoadItems('Non-Admission Outcome');
                $outcomeOutcomeDDArray = array();
                for ($i = 1; $i < (count($outcomeOutcomeDDSQL)+1); $i++) {
                    array_push($outcomeOutcomeDDArray,$outcomeOutcomeDDSQL[$i]['Long_Name']);
                }
    
                $outcomeOutcomeDD = $Form->dropDown('otc-outcome',$outcomeOutcomeDDArray,$outcomeOutcomeDDArray,$patient['NONADMOUTCOME']);
                echo $outcomeOutcomeDD;
            ?>
        </td>
    </tr>
    <tr>
        <td>
            Archive record
        </td>
        <td>
            <?php
            
            $archiveRecord = $Form->checkBox('otc-archiveRecord','otc-archiveRecord','',$patient['NON_ADM_SORTED'],'');
            echo $archiveRecord;
            ?>
        </td>
    </tr>
</table>