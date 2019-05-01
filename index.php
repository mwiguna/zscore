<?php

/* zScore Normalizer Algorithm
 * Lincensed to M. Wiguna Saputra
 * Copyright (c) 2019
 * https://github.com/mwiguna
 */

  function zScore($data){

    // Mean

    $interval_value = max($data) / (count($data) / 2);

    $end_interval = 0;
    $n = 0;
    $sigma_fx = 0;

    while($end_interval <= max($data)){
      $begin_interval = $end_interval;
      $end_interval = ($begin_interval + (($begin_interval == 0) ? $interval_value : ($interval_value - 1)));
      $x = $end_interval / 2;

      $f = 0;
      foreach($data as $val){
        if($val >= $begin_interval && $val <= $end_interval) $f++;
      }

      $n += $f;
      $sigma_fx += ($f * $x);

      $end_interval += 1;
    }

    $mean = $sigma_fx / $n;

    // STD dev

    $sigma_x  = 0;
    $sigma_x2 = 0;
    foreach ($data as $val) {
      $val = $val / 1000;
      $sigma_x  += $val;
      $sigma_x2 += ($val*$val);
    }

    $std = sqrt( ($n * $sigma_x2 - ($sigma_x * $sigma_x)) / $n * ($n-1) ) * 1000;

    // Z Score

    $results = [];
    foreach ($data as $val) {
      $Y_ = ($val - $mean) / $std;
      $results []= number_format((float) $Y_, 2, '.', '');
    }

    return $results;
  }

?>



<!-- Interface -->



<!DOCTYPE html>
<html>
  <head>
    <style>
      table { border: 1px solid; border-collapse: collapse; width: 60%; }
      td    { border: 1px solid; padding: 5px; text-align: center; }
    </style>
  </head>
  <body>
    <?php
      $tahun = array(2010, 2011, 2012);
      $_2010 = array(2261759, 1831286, 3443027, 1574364, 84016, 127712, 460482, 1680);
      $_2011 = array(2334827, 2046561, 2995434, 1790629, 136430, 39622, 509463, 173158);
      $_2012 = array(2343782, 1942589, 2724983, 1800264, 113458, 42067, 508654, 16381);
      $datas  = array($_2010, $_2011, $_2012);
    ?>

    <h3>Normal Data</h3>

    <table>

      <?php $i = 0; foreach ($datas as $data): ?>
        <tr>
          <td><?= $tahun[$i] ?></td>
          <?php foreach ($data as $val): ?>
              <td style=""><?= $val ?></td>
          <?php endforeach ?>
        </tr>
      <?php $i++; endforeach; ?>

    </table>

    <!-- Z Score -->

    <h3>Normalized Data with Z Score Algorithm</h3>

    <table>

      <?php $i = 0; foreach ($datas as $data): ?>
        <tr>
          <td><?= $tahun[$i] ?></td>
          <?php foreach (zScore($data) as $val): ?>
              <td><?= $val ?></td>
          <?php endforeach ?>
        </tr>
      <?php $i++; endforeach; ?>

    </table>

  </body>
</html>
