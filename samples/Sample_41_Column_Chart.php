<?php
include_once 'Sample_Header.php';

use tyttam\PhpWord\Shared\Converter;

// New Word document
echo date('H:i:s'), ' Create new PhpWord object', EOL;
$phpWord = new \tyttam\PhpWord\PhpWord();

$section = $phpWord->addSection();
$section->addTitle('2D charts', 1);

$categories = array('A', 'B', 'C', 'D', 'E');
$series1 = array(1, 3, 2, 4, 7, 12, 4, 22, 1234567, 8);
$series2 = array(3, 1, 7, 2 ,31, 2, 13, 0, 3, 9);
$showGridLines = false;
$showAxisLabels = true;
$labels = array('май', 'июнь', 'июль', 'июль', 'июль', 'июль', 'июль', 'июль', 'июль', 'июль');


$section->addTitle(ucfirst('column'), 2);
$chart = $section->addChart('column', $labels, $series1, array('showAxisLabels' => false,
  'dataLabelOptions' => array('showVal' => true, 'showCatName' => false)));
$chart->getStyle()->setWidth(Converter::inchToEmu(5))->setHeight(Converter::inchToEmu(2));
$chart->getStyle()->setShowAxisLabels($showAxisLabels);
$chart->getStyle()->setShowAxisY(false);
$chart->getStyle()->setSpacingOverlapColumns(0);
$chart->getStyle()->setDisplayAxisLines(false);
$chart->addSeries($series2, $series2);

$section->addTextBreak();


// Save file
echo write($phpWord, basename(__FILE__, '.php'), $writers);
if (!CLI) {
  include_once 'Sample_Footer.php';
}
