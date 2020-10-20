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

namespace tyttam\PhpWord\Element;

use tyttam\PhpWord\Style\Font;
use tyttam\PhpWord\Style\Paragraph;

/**
 * Test class for tyttam\PhpWord\Element\TextBreak
 *
 * @coversDefaultClass \tyttam\PhpWord\Element\TextBreak
 * @runTestsInSeparateProcesses
 */
class TextBreakTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Construct with empty value
     */
    public function testConstruct()
    {
        $object = new TextBreak();
        $this->assertNull($object->getFontStyle());
        $this->assertNull($object->getParagraphStyle());
    }

    /**
     * Construct with style object
     */
    public function testConstructWithStyleObject()
    {
        $fStyle = new Font();
        $pStyle = new Paragraph();
        $object = new TextBreak($fStyle, $pStyle);
        $this->assertEquals($fStyle, $object->getFontStyle());
        $this->assertEquals($pStyle, $object->getParagraphStyle());
    }

    /**
     * Construct with style array
     */
    public function testConstructWithStyleArray()
    {
        $fStyle = array('size' => 12);
        $pStyle = array('spacing' => 240);
        $object = new TextBreak($fStyle, $pStyle);
        $this->assertInstanceOf('tyttam\\PhpWord\\Style\\Font', $object->getFontStyle());
        $this->assertInstanceOf('tyttam\\PhpWord\\Style\\Paragraph', $object->getParagraphStyle());
    }

    /**
     * Construct with style name
     */
    public function testConstructWithStyleName()
    {
        $fStyle = 'fStyle';
        $pStyle = 'pStyle';
        $object = new TextBreak($fStyle, $pStyle);
        $this->assertEquals($fStyle, $object->getFontStyle());
        $this->assertEquals($pStyle, $object->getParagraphStyle());
    }
}
