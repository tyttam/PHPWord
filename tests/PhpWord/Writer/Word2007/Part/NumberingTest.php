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

use tyttam\PhpWord\PhpWord;
use tyttam\PhpWord\SimpleType\Jc;
use tyttam\PhpWord\SimpleType\NumberFormat;
use tyttam\PhpWord\TestHelperDOCX;

/**
 * Test class for tyttam\PhpWord\Writer\Word2007\Part\Numbering
 *
 * @coversDefaultClass \tyttam\PhpWord\Writer\Word2007\Part\Numbering
 * @runTestsInSeparateProcesses
 * @since 0.10.0
 */
class NumberingTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Executed before each method of the class
     */
    public function tearDown()
    {
        TestHelperDOCX::clear();
    }

    /**
     * Write footnotes
     */
    public function testWriteNumbering()
    {
        $xmlFile = 'word/numbering.xml';

        $phpWord = new PhpWord();
        $phpWord->addNumberingStyle(
            'numStyle',
            array(
                'type'   => 'multilevel',
                'levels' => array(
                    array(
                        'start'     => 1,
                        'format'    => NumberFormat::DECIMAL,
                        'restart'   => 1,
                        'suffix'    => 'space',
                        'text'      => '%1.',
                        'alignment' => Jc::START,
                        'left'      => 360,
                        'hanging'   => 360,
                        'tabPos'    => 360,
                        'font'      => 'Arial',
                        'hint'      => 'default',
                    ),
                ),
            )
        );

        $doc = TestHelperDOCX::getDocument($phpWord, 'Word2007');

        $this->assertTrue($doc->elementExists('/w:numbering/w:abstractNum', $xmlFile));
    }
}
