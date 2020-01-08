<?php
$soal = 1;
$jml_soal = 40;
for ($i=1; $i <= $jml_soal*5; $i=$i+5) {
  // code...
  echo "=soal!A".$i."<br>";
  for ($j=1; $j <= 4; $j++) {
    // code...
    $huruf = array(1 => 'A',
                  2  => 'B',
                  3  => 'C',
                  4  => 'D');

    $p = $i+$j;
    echo '="'.$huruf[$j].'. "&soal!A'.$p.'<br>';
  }
  echo '="ANSWER: "&VLOOKUP('.$soal.';kunci!B3:C102;2)';
  echo "<br><br>";
  $soal++;
}

?>
