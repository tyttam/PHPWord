<?php
/**
 * This file is part of PHPWord - A pure PHP library for reading and writing
 * word processing documents.
 *
 * PHPWord is free software distributed under the terms of the GNU Lesser
 * General Public License version 3 as published by the Free Software Foundation.
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code. For the full list of
 * contributors, visit https://github.com/PHPOffice/PHPWord/contributors.
 *
 * @see         https://github.com/PHPOffice/PHPWord
 * @copyright   2010-2018 PHPWord contributors
 * @license     http://www.gnu.org/licenses/lgpl.txt LGPL version 3
 */

namespace tyttam\PhpWord\Writer\Word2007\Part;

use PhpOffice\Common\XMLWriter;
use tyttam\PhpWord\Element\Chart as ChartElement;

/**
 * Word2007 chart part writer: word/charts/chartx.xml
 *
 * @since 0.12.0
 * @see  http://www.datypic.com/sc/ooxml/e-draw-chart_chartSpace.html
 */
class Chart extends AbstractPart
{
    /**
     * Chart element
     *
     * @var \tyttam\PhpWord\Element\Chart
     */
    private $element;

    /**
     * Type definition
     *
     * @var array
     */
    private $types = array(
        'pie'                    => array('type' => 'pie', 'colors' => 1),
        'doughnut'               => array('type' => 'doughnut', 'colors' => 1, 'hole' => 75, 'no3d' => true),
        'bar'                    => array('type' => 'bar', 'colors' => 0, 'axes' => true, 'bar' => 'bar', 'grouping' => 'clustered'),
        'stacked_bar'            => array('type' => 'bar', 'colors' => 0, 'axes' => true, 'bar' => 'bar', 'grouping' => 'stacked'),
        'percent_stacked_bar'    => array('type' => 'bar', 'colors' => 0, 'axes' => true, 'bar' => 'bar', 'grouping' => 'percentStacked'),
        'column'                 => array('type' => 'bar', 'colors' => 0, 'axes' => true, 'bar' => 'col', 'grouping' => 'clustered'),
        'stacked_column'         => array('type' => 'bar', 'colors' => 0, 'axes' => true, 'bar' => 'col', 'grouping' => 'stacked'),
        'percent_stacked_column' => array('type' => 'bar', 'colors' => 0, 'axes' => true, 'bar' => 'col', 'grouping' => 'percentStacked'),
        'line'                   => array('type' => 'line', 'colors' => 0, 'axes' => true),
        'area'                   => array('type' => 'area', 'colors' => 0, 'axes' => true),
        'radar'                  => array('type' => 'radar', 'colors' => 0, 'axes' => true, 'radar' => 'standard', 'no3d' => true),
        'scatter'                => array('type' => 'scatter', 'colors' => 0, 'axes' => true, 'scatter' => 'marker', 'no3d' => true),
    );

    /**
     * Chart options
     *
     * @var array
     */
    private $options = array();

    /**
     * Set chart element.
     *
     * @param \tyttam\PhpWord\Element\Chart $element
     */
    public function setElement(ChartElement $element)
    {
        $this->element = $element;
    }

    /**
     * Write part
     *
     * @return string
     */
    public function write()
    {
        $xmlWriter = $this->getXmlWriter();

        $xmlWriter->startDocument('1.0', 'UTF-8', 'yes');
        $xmlWriter->startElement('c:chartSpace');
        $xmlWriter->writeAttribute('xmlns:c', 'http://schemas.openxmlformats.org/drawingml/2006/chart');
        $xmlWriter->writeAttribute('xmlns:a', 'http://schemas.openxmlformats.org/drawingml/2006/main');
        $xmlWriter->writeAttribute('xmlns:r', 'http://schemas.openxmlformats.org/officeDocument/2006/relationships');

        $this->writeChart($xmlWriter);
        $this->writeShape($xmlWriter);

        $xmlWriter->endElement(); // c:chartSpace

        return $xmlWriter->getData();
    }

    /**
     * Write chart
     *
     * @see  http://www.datypic.com/sc/ooxml/t-draw-chart_CT_Chart.html
     * @param \PhpOffice\Common\XMLWriter $xmlWriter
     */
    private function writeChart(XMLWriter $xmlWriter)
    {
        $xmlWriter->startElement('c:chart');

        $this->writePlotArea($xmlWriter);

        $xmlWriter->endElement(); // c:chart
    }

    /**
     * Write plot area.
     *
     * @see  http://www.datypic.com/sc/ooxml/t-draw-chart_CT_PlotArea.html
     * @see  http://www.datypic.com/sc/ooxml/t-draw-chart_CT_PieChart.html
     * @see  http://www.datypic.com/sc/ooxml/t-draw-chart_CT_DoughnutChart.html
     * @see  http://www.datypic.com/sc/ooxml/t-draw-chart_CT_BarChart.html
     * @see  http://www.datypic.com/sc/ooxml/t-draw-chart_CT_LineChart.html
     * @see  http://www.datypic.com/sc/ooxml/t-draw-chart_CT_AreaChart.html
     * @see  http://www.datypic.com/sc/ooxml/t-draw-chart_CT_RadarChart.html
     * @see  http://www.datypic.com/sc/ooxml/t-draw-chart_CT_ScatterChart.html
     * @param \PhpOffice\Common\XMLWriter $xmlWriter
     */
    private function writePlotArea(XMLWriter $xmlWriter)
    {
        $type = $this->element->getType();
        $style = $this->element->getStyle();
        $this->options = $this->types[$type];

        $title = $style->getTitle();
        $showLegend = $style->isShowLegend();

        //Chart title
        if ($title) {
            $xmlWriter->startElement('c:title');
            $xmlWriter->startElement('c:tx');
            $xmlWriter->startElement('c:rich');
            $xmlWriter->writeRaw('
                <a:bodyPr/>
                <a:lstStyle/>
                <a:p>
                <a:pPr>
                <a:defRPr/></a:pPr><a:r><a:rPr/><a:t>' . $title . '</a:t></a:r>
                <a:endParaRPr/>
                </a:p>');
            $xmlWriter->endElement(); // c:rich
            $xmlWriter->endElement(); // c:tx
            $xmlWriter->endElement(); // c:title
        } else {
            $xmlWriter->writeElementBlock('c:autoTitleDeleted', 'val', 1);
        }

        //Chart legend
        if ($showLegend) {
            $xmlWriter->startElement('c:legend');
            $xmlWriter->writeElementBlock('c:legendPos', 'val', 'r');
            $xmlWriter->writeElementBlock('c:overlay', 'val', $style->getLegendPosition());
            $xmlWriter->endElement();
        }

        $xmlWriter->startElement('c:plotArea');
        $xmlWriter->writeElement('c:layout');

        // Chart
        $chartType = $this->options['type'];
        $chartType .= $style->is3d() && !isset($this->options['no3d']) ? '3D' : '';
        $chartType .= 'Chart';
        $xmlWriter->startElement("c:{$chartType}");

        $xmlWriter->writeElementBlock('c:varyColors', 'val', $this->options['colors']);
        if ($type == 'area') {
            $xmlWriter->writeElementBlock('c:grouping', 'val', 'standard');
        }
        if (isset($this->options['hole'])) {
            $xmlWriter->writeElementBlock('c:holeSize', 'val', $this->options['hole']);
        }
        if (isset($this->options['bar'])) {
            $xmlWriter->writeElementBlock('c:barDir', 'val', $this->options['bar']); // bar|col
            $xmlWriter->writeElementBlock('c:grouping', 'val', $this->options['grouping']); // 3d; standard = percentStacked
        }
        if (isset($this->options['radar'])) {
            $xmlWriter->writeElementBlock('c:radarStyle', 'val', $this->options['radar']);
        }
        if (isset($this->options['scatter'])) {
            $xmlWriter->writeElementBlock('c:scatterStyle', 'val', $this->options['scatter']);
        }

        // Series
        $this->writeSeries($xmlWriter, isset($this->options['scatter']));

        $xmlWriter->writeElementBlock('c:overlap', 'val', '100');

        // Axes
        if (isset($this->options['axes'])) {
            $xmlWriter->writeElementBlock('c:axId', 'val', 1);
            $xmlWriter->writeElementBlock('c:axId', 'val', 2);
        }

        $xmlWriter->endElement(); // chart type

        // Axes
        if (isset($this->options['axes'])) {
            $this->writeAxis($xmlWriter, 'cat');
            $this->writeAxis($xmlWriter, 'val');
        }

        $xmlWriter->endElement(); // c:plotArea
    }

    /**
     * Write series.
     *
     * @param \PhpOffice\Common\XMLWriter $xmlWriter
     * @param bool $scatter
     */
    private function writeSeries(XMLWriter $xmlWriter, $scatter = false)
    {
        $series = $this->element->getSeries();
        $style = $this->element->getStyle();
        $colors = $style->getColors();

        $index = 0;
        foreach ($series as $seriesItem) {
            $categories = $seriesItem['categories'];
            $values = $seriesItem['values'];

            $xmlWriter->startElement('c:ser');

            $xmlWriter->writeElementBlock('c:idx', 'val', $index);
            $xmlWriter->writeElementBlock('c:order', 'val', $index);

            if (!is_null($seriesItem['name']) && $seriesItem['name'] != '') {
                $xmlWriter->startElement('c:tx');
                $xmlWriter->startElement('c:strRef');
                $xmlWriter->startElement('c:strCache');
                $xmlWriter->writeElementBlock('c:ptCount', 'val', 1);
                $xmlWriter->startElement('c:pt');
                $xmlWriter->writeAttribute('idx', 0);
                $xmlWriter->startElement('c:v');
                $xmlWriter->writeRaw($seriesItem['name']);
                $xmlWriter->endElement(); // c:v
                $xmlWriter->endElement(); // c:pt
                $xmlWriter->endElement(); // c:strCache
                $xmlWriter->endElement(); // c:strRef
                $xmlWriter->endElement(); // c:tx
            }

            // The c:dLbls was added to make word charts look more like the reports in SurveyGizmo
            // This section needs to be made configurable before a pull request is made
            $xmlWriter->startElement('c:dLbls');

            foreach ($style->getDataLabelOptions() as $option => $val) {
                $xmlWriter->writeElementBlock("c:{$option}", 'val', (int) $val);
            }

            if ($this->element->getType() == 'pie') {
              $xmlWriter->writeElementBlock("c:dLblPos", 'val', $style->getDataLabelPosition());
              if (!$style->showSeparatorsInLabel()) {
                $xmlWriter->writeElementBlock("c:separator", 'val', ' ');
              }
            }

            $xmlWriter->endElement(); // c:dLbls

            if (isset($this->options['scatter'])) {
                $this->writeShape($xmlWriter);
            }

            if ($scatter === true) {
                $this->writeSeriesItem($xmlWriter, 'xVal', $categories);
                $this->writeSeriesItem($xmlWriter, 'yVal', $values);
            } else {
                $this->writeSeriesItem($xmlWriter, 'cat', $categories);
                $this->writeSeriesItem($xmlWriter, 'val', $values);

                // setting the chart colors was taken from https://github.com/PHPOffice/PHPWord/issues/494
                if (is_array($colors) && count($colors)) {
                    // This is a workaround to make each series in a stack chart use a different color
                    if ($this->options['type'] == 'bar' && stristr($this->options['grouping'], 'stacked')) {
                        array_shift($colors);
                    }
                    $colorIndex = 0;
                    foreach ($colors as $color) {
                        $xmlWriter->startElement('c:dPt');
                        $xmlWriter->writeElementBlock('c:idx', 'val', $colorIndex);
                        $xmlWriter->startElement('c:spPr');
                        $xmlWriter->startElement('a:solidFill');
                        $xmlWriter->writeElementBlock('a:srgbClr', 'val', $color);
                        $xmlWriter->endElement(); // a:solidFill
                        $xmlWriter->endElement(); // c:spPr
                        $xmlWriter->endElement(); // c:dPt
                        $colorIndex++;
                    }
                }
            }

            $xmlWriter->endElement(); // c:ser
            $index++;
        }
    }

    /**
     * Write series items.
     *
     * @param \PhpOffice\Common\XMLWriter $xmlWriter
     * @param string $type
     * @param array $values
     */
    private function writeSeriesItem(XMLWriter $xmlWriter, $type, $values)
    {
        $types = array(
            'cat'  => array('c:cat', 'c:strLit'),
            'val'  => array('c:val', 'c:numLit'),
            'xVal' => array('c:xVal', 'c:strLit'),
            'yVal' => array('c:yVal', 'c:numLit'),
        );
        list($itemType, $itemLit) = $types[$type];

        $xmlWriter->startElement($itemType);
        $xmlWriter->startElement($itemLit);
        $xmlWriter->writeElementBlock('c:ptCount', 'val', count($values));

        $index = 0;
        foreach ($values as $value) {
            $xmlWriter->startElement('c:pt');
            $xmlWriter->writeAttribute('idx', $index);
            if (\tyttam\PhpWord\Settings::isOutputEscapingEnabled()) {
                $xmlWriter->writeElement('c:v', $value);
            } else {
                $xmlWriter->startElement('c:v');
                $xmlWriter->writeRaw($value);
                $xmlWriter->endElement(); // c:v
            }
            $xmlWriter->endElement(); // c:pt
            $index++;
        }

        $xmlWriter->endElement(); // $itemLit
        $xmlWriter->endElement(); // $itemType
    }

    /**
     * Write axis
     *
     * @see  http://www.datypic.com/sc/ooxml/t-draw-chart_CT_CatAx.html
     * @param \PhpOffice\Common\XMLWriter $xmlWriter
     * @param string $type
     */
    private function writeAxis(XMLWriter $xmlWriter, $type)
    {
        $style = $this->element->getStyle();
        $types = array(
            'cat' => array('c:catAx', 1, 'b', 2),
            'val' => array('c:valAx', 2, 'l', 1),
        );
        list($axisType, $axisId, $axisPos, $axisCross) = $types[$type];

        $xmlWriter->startElement($axisType);

        $xmlWriter->writeElementBlock('c:axId', 'val', $axisId);
        $xmlWriter->writeElementBlock('c:axPos', 'val', $axisPos);

        $categoryAxisTitle = $style->getCategoryAxisTitle();
        $valueAxisTitle = $style->getValueAxisTitle();

        if ($axisType == 'c:catAx') {
            if (!is_null($categoryAxisTitle)) {
                $this->writeAxisTitle($xmlWriter, $categoryAxisTitle);
            }
        } elseif ($axisType == 'c:valAx') {
            if (!is_null($valueAxisTitle)) {
                $this->writeAxisTitle($xmlWriter, $valueAxisTitle);
            }
        }

        $xmlWriter->writeElementBlock('c:crossAx', 'val', $axisCross);
        $xmlWriter->writeElementBlock('c:auto', 'val', 1);

        if (isset($this->options['axes'])) {
            $xmlWriter->writeElementBlock('c:delete', 'val', 0);
            $xmlWriter->writeElementBlock('c:majorTickMark', 'val', $style->getMajorTickPosition());
            $xmlWriter->writeElementBlock('c:minorTickMark', 'val', 'none');
            if ($style->showAxisLabels()) {
                if ($axisType == 'c:catAx') {
                    $xmlWriter->writeElementBlock('c:tickLblPos', 'val', $style->getCategoryLabelPosition());
                } else {
                    $xmlWriter->writeElementBlock('c:tickLblPos', 'val', $style->getValueLabelPosition());
                }
            } else {
                $xmlWriter->writeElementBlock('c:tickLblPos', 'val', 'none');
            }
            $xmlWriter->writeElementBlock('c:crosses', 'val', 'autoZero');
        }
        if (isset($this->options['radar']) || ($type == 'cat' && $style->showGridX()) || ($type == 'val' && $style->showGridY())) {
            $xmlWriter->writeElement('c:majorGridlines');
        }

        $xmlWriter->startElement('c:scaling');
        $xmlWriter->writeElementBlock('c:orientation', 'val', 'minMax');
        $xmlWriter->endElement(); // c:scaling

        $this->writeShape($xmlWriter, true);

        $xmlWriter->endElement(); // $axisType
    }

    /**
     * Write shape
     *
     * @see  http://www.datypic.com/sc/ooxml/t-a_CT_ShapeProperties.html
     * @param \PhpOffice\Common\XMLWriter $xmlWriter
     * @param bool $line
     */
    private function writeShape(XMLWriter $xmlWriter, $line = false)
    {
        $xmlWriter->startElement('c:spPr');
        $xmlWriter->startElement('a:ln');
        if ($line === true) {
            $xmlWriter->writeElement('a:solidFill');
        } else {
            $xmlWriter->writeElement('a:noFill');
        }
        $xmlWriter->endElement(); // a:ln
        $xmlWriter->endElement(); // c:spPr
    }

    private function writeAxisTitle(XMLWriter $xmlWriter, $title)
    {
        $xmlWriter->startElement('c:title'); //start c:title
        $xmlWriter->startElement('c:tx'); //start c:tx
        $xmlWriter->startElement('c:rich'); // start c:rich
        $xmlWriter->writeElement('a:bodyPr');
        $xmlWriter->writeElement('a:lstStyle');
        $xmlWriter->startElement('a:p');
        $xmlWriter->startElement('a:pPr');
        $xmlWriter->writeElement('a:defRPr');
        $xmlWriter->endElement(); // end a:pPr
        $xmlWriter->startElement('a:r');
        $xmlWriter->writeElementBlock('a:rPr', 'lang', 'en-US');

        $xmlWriter->startElement('a:t');
        $xmlWriter->writeRaw($title);
        $xmlWriter->endElement(); //end a:t

        $xmlWriter->endElement(); // end a:r
        $xmlWriter->endElement(); //end a:p
        $xmlWriter->endElement(); //end c:rich
        $xmlWriter->endElement(); // end c:tx
        $xmlWriter->writeElementBlock('c:overlay', 'val', '0');
        $xmlWriter->endElement(); // end c:title
    }
}
