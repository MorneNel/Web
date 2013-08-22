<?php

?>

<h2>History of chronic pain prior to admission</h2>

<table class="temp">
    <thead>
        <tr>
            <th>
                Description
            </th>
            <th>
                Score
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT Descr, ScoreVal FROM PASC WHERE LnkID=".$patient['LNK_ID']." AND GrpType=1";
            try { 
                $result = odbc_exec($connect,$sql); 
                    if($result){ 
                            while ($chronicPain = odbc_fetch_array($result)) {
                                print "<tr><td>".$chronicPain['DESCR']."</td><td>".$chronicPain['SCOREVAL']."</td></tr>";
                            }
                        }
                    else{ 
                    throw new RuntimeException("Failed to connect."); 
                    } 
                        } 
                    catch (RuntimeException $e) { 
                            print("Exception caught: $e");
                            //exit;
                    }
        ?>
    </tbody>
</table>

<h2>Pre-admission analgesis medications</h2>

<table class="temp">
    <thead>
        <tr>
            <th>
                Description
            </th>
            <th>
                Score
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT Descr, ScoreVal FROM PASC WHERE LnkID=".$patient['LNK_ID']." AND GrpType=2";
            try { 
                $result = odbc_exec($connect,$sql); 
                    if($result){ 
                            while ($chronicPain = odbc_fetch_array($result)) {
                                print "<tr><td>".$chronicPain['DESCR']."</td><td>".$chronicPain['SCOREVAL']."</td></tr>";
                            }
                        }
                    else{ 
                    throw new RuntimeException("Failed to connect."); 
                    } 
                        } 
                    catch (RuntimeException $e) { 
                            print("Exception caught: $e");
                            //exit;
                    }
        ?>
    </tbody>
</table>

<h2>History of inpatient admission because of pain</h2>

<table class="temp">
    <thead>
        <tr>
            <th>
                Description
            </th>
            <th>
                Score
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT Descr, ScoreVal FROM PASC WHERE LnkID=".$patient['LNK_ID']." AND GrpType=3";
            try { 
                $result = odbc_exec($connect,$sql); 
                    if($result){ 
                            while ($chronicPain = odbc_fetch_array($result)) {
                                print "<tr><td>".$chronicPain['DESCR']."</td><td>".$chronicPain['SCOREVAL']."</td></tr>";
                            }
                        }
                    else{ 
                    throw new RuntimeException("Failed to connect."); 
                    } 
                        } 
                    catch (RuntimeException $e) { 
                            print("Exception caught: $e");
                            //exit;
                    }
        ?>
    </tbody>
</table>