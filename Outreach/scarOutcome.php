<table>
    <tr>
        <td>
            Pigmentation
        </td>
        <td>
            <?php
                $pigmentationDDSQL = $Mela_SQL->tbl_LoadItems('Pigmentation');
                $pigmentationDDArray = array();
                for ($i = 1; $i < (count($pigmentationDDSQL)+1); $i++) {
                    array_push($pigmentationDDArray,$pigmentationDDSQL[$i]['Long_Name']);
                }

                $pigmentationDD = $Form->dropDown('sca-pigmentation',$pigmentationDDArray,$pigmentationDDArray,$patient['PIGMENTATION']);
                echo $pigmentationDD;
            ?>    
        </td>
    </tr>
    <tr>
        <td>
            Vascularity
        </td>
        <td>
            <?php
                $vascularityDDSQL = $Mela_SQL->tbl_LoadItems('Vascularity');
                $vascularityDDArray = array();
                for ($i = 1; $i < (count($vascularityDDSQL)+1); $i++) {
                    array_push($vascularityDDArray,$vascularityDDSQL[$i]['Long_Name']);
                }

                $vascularityDD = $Form->dropDown('sca-vascularity',$vascularityDDArray,$vascularityDDArray,$patient['VASCULARITY']);
                echo $vascularityDD;
            ?>    
        </td>
    </tr>
    <tr>
        <td>
            Pliability
        </td>
        <td>
            <?php
                $pliabilityDDSQL = $Mela_SQL->tbl_LoadItems('Pliability');
                $pliabilityDDArray = array();
                for ($i = 1; $i < (count($pliabilityDDSQL)+1); $i++) {
                    array_push($pliabilityDDArray,$pliabilityDDSQL[$i]['Long_Name']);
                }

                $pliabilityDD = $Form->dropDown('sca-pliability',$pliabilityDDArray,$pliabilityDDArray,$patient['PLIABILITY']);
                echo $pliabilityDD;
            ?>    
        </td>
    </tr>
    <tr>
        <td>
            Height
        </td>
        <td>
            <?php
                $heightDDSQL = $Mela_SQL->tbl_LoadItems('Height');
                $heightDDArray = array();
                for ($i = 1; $i < (count($heightDDSQL)+1); $i++) {
                    array_push($heightDDArray,$heightDDSQL[$i]['Long_Name']);
                }

                $heightDD = $Form->dropDown('sca-height',$heightDDArray,$heightDDArray,$patient['HEIGHT']);
                echo $heightDD;
            ?>
        </td>
    </tr>
</table>