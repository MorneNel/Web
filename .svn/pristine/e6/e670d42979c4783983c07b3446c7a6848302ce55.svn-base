<?php 
$ASAScore = array("I" => "A normal healthy patient",
                  "II" => "A patient with mild systemic disease",
                  "III" => "A patient with severe systemic disease",
                  "IV" => "A patient with severe systemic disease that is a constant threat to life",
                  "V" => "A moribund patient who is not expected to survive without surgery",
                  "E" => "Emergency surgery",
                  "N" => "Not documented");

if ($_REQUEST['score']) {
    echo $ASAScore[$_REQUEST['score']];
} else echo "No";
