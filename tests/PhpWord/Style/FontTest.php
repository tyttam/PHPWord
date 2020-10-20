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

namespace tyttam\PhpWord\Style;

use tyttam\PhpWord\PhpWord;
use tyttam\PhpWord\SimpleType\Jc;
use tyttam\PhpWord\TestHelperDOCX;

/**
 * Test class for tyttam\PhpWord\Style\Font
 *
 * @runTestsInSeparateProcesses
 */
class FontTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tear down after each test
     */
    public function tearDown()
    {
        TestHelperDOCX::clear();
    }

    /**
     * Test initiation for style type and paragraph style
     */
    public function testInitiation()
    {
        $object = new Font('text', array('alignment' => Jc::BOTH));

        $this->assertEquals('text', $object->getStyleType());
        $this->assertInstanceOf('tyttam\\PhpWord\\Style\\Paragraph', $object->getParagraphStyle());
        $this->assertInternalType('array', $object->getStyleValues());
    }

    /**
     * Test setting style values with null or empty value
     */
    public function testSetStyleValueWithNullOrEmpty()
    {
        $object = new Font();

        $attributes = array(
            'name'                => null,
            'size'                => null,
            'hint'                => null,
            'color'               => null,
            'bold'                => false,
            'italic'              => false,
            'underline'           => Font::UNDERLINE_NONE,
            'superScript'         => false,
            'subScript'           => false,
            'strikethrough'       => false,
            'doubleStrikethrough' => false,
            'smallCaps'           => false,
            'allCaps'             => false,
            'rtl'                 => false,
            'fgColor'             => null,
            'bgColor'             => null,
            'scale'               => null,
            'spacing'             => null,
            'kerning'             => null,
            'lang'                => null,
            'hidden'              => false,
        );
        foreach ($attributes as $key => $default) {
            $get = is_bool($default) ? "is{$key}" : "get{$key}";
            $this->assertEquals($default, $object->$get());
            $object->setStyleValue($key, null);
            $this->assertEquals($default, $object->$get());
            $object->setStyleValue($key, '');
            $this->assertEquals($default, $object->$get());
        }
    }

    /**
     * Test setting style values with normal value
     */
    public function testSetStyleValueNormal()
    {
        $object = new Font();

        $attributes = array(
            'name'                => 'Times New Roman',
            'size'                => 9,
            'color'               => '999999',
            'hint'                => 'eastAsia',
            'bold'                => true,
            'italic'              => true,
            'underline'           => Font::UNDERLINE_HEAVY,
            'superScript'         => true,
            'subScript'           => false,
            'strikethrough'       => true,
            'doubleStrikethrough' => false,
            'smallCaps'           => true,
            'allCaps'             => false,
            'fgColor'             => Font::FGCOLOR_YELLOW,
            'bgColor'             => 'FFFF00',
            'lineHeight'          => 2,
            'scale'               => 150,
            'spacing'             => 240,
            'kerning'             => 10,
            'rtl'                 => true,
            'noProof'             => true,
            'lang'                => new Language(Language::EN_US),
            'hidden'              => true,
        );
        $object->setStyleByArray($attributes);
        foreach ($attributes as $key => $value) {
            $get = is_bool($value) ? "is{$key}" : "get{$key}";
            $this->assertEquals($value, $object->$get());
        }
    }

    /**
     * Test set line height
     */
    public function testLineHeight()
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Test style array
        $text = $section->addText('This is a test', array('line-height' => 2.0));

        $doc = TestHelperDOCX::getDocument($phpWord);
        $element = $doc->getElement('/w:document/w:body/w:p/w:pPr/w:spacing');

        $lineHeight = $element->getAttribute('w:line');
        $lineRule = $element->getAttribute('w:lineRule');

        $this->assertEquals(480, $lineHeight);
        $this->assertEquals('auto', $lineRule);

        // Test setter
        $text->getFontStyle()->setLineHeight(3.0);
        $doc = TestHelperDOCX::getDocument($phpWord);
        $element = $doc->getElement('/w:document/w:body/w:p/w:pPr/w:spacing');

        $lineHeight = $element->getAttribute('w:line');
        $lineRule = $element->getAttribute('w:lineRule');

        $this->assertEquals(720, $lineHeight);
        $this->assertEquals('auto', $lineRule);
    }

    /**
     * Test line height floatval
     */
    public function testLineHeightFloatval()
    {
        $object = new Font(null, array('alignment' => Jc::CENTER));
        $object->setLineHeight('1.5pt');
        $this->assertEquals(1.5, $object->getLineHeight());
    }

    /**
     * Test line height exception by using nonnumeric value
     *
     * @expectedException \tyttam\PhpWord\Exception\InvalidStyleException
     */
    public function testLineHeightException()
    {
        $object = new Font();
        $object->setLineHeight('a');
    }

    /**
     * Test setting the language as a string
     */
    public function testSetLangAsString()
    {
        $object = new Font();
        $object->setLang(Language::FR_BE);
        $this->assertInstanceOf('tyttam\PhpWord\Style\Language', $object->getLang());
        $this->assertEquals(Language::FR_BE, $object->getLang()->getLatin());
    }
}
