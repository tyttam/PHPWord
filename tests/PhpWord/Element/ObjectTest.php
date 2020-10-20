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

/**
 * Test class for tyttam\PhpWord\Element\OLEObject
 *
 * @coversDefaultClass \tyttam\PhpWord\Element\OLEObject
 * @runTestsInSeparateProcesses
 */
class ObjectTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Create new instance with supported files, 4 character extention
     */
    public function testConstructWithSupportedFiles()
    {
        $src = __DIR__ . '/../_files/documents/reader.docx';
        $oObject = new OLEObject($src);

        $this->assertInstanceOf('tyttam\\PhpWord\\Element\\OLEObject', $oObject);
        $this->assertInstanceOf('tyttam\\PhpWord\\Style\\Image', $oObject->getStyle());
        $this->assertEquals($src, $oObject->getSource());
    }

    /**
     * Create new instance with supported files
     */
    public function testConstructWithSupportedFilesLong()
    {
        $src = __DIR__ . '/../_files/documents/sheet.xls';
        $oObject = new OLEObject($src);

        $this->assertInstanceOf('tyttam\\PhpWord\\Element\\OLEObject', $oObject);
        $this->assertInstanceOf('tyttam\\PhpWord\\Style\\Image', $oObject->getStyle());
        $this->assertEquals($src, $oObject->getSource());
    }

    /**
     * Create new instance with non-supported files
     *
     * @expectedException \tyttam\PhpWord\Exception\InvalidObjectException
     */
    public function testConstructWithNotSupportedFiles()
    {
        $src = __DIR__ . '/../_files/xsl/passthrough.xsl';
        $oObject = new OLEObject($src);
        $oObject->getSource();
    }

    /**
     * Create with style
     */
    public function testConstructWithSupportedFilesAndStyle()
    {
        $src = __DIR__ . '/../_files/documents/sheet.xls';
        $oObject = new OLEObject($src, array('width' => '230px'));

        $this->assertInstanceOf('tyttam\\PhpWord\\Element\\OLEObject', $oObject);
        $this->assertInstanceOf('tyttam\\PhpWord\\Style\\Image', $oObject->getStyle());
        $this->assertEquals($src, $oObject->getSource());
    }

    /**
     * Set/get relation Id
     */
    public function testRelationId()
    {
        $src = __DIR__ . '/../_files/documents/sheet.xls';
        $oObject = new OLEObject($src);

        $iVal = rand(1, 1000);
        $oObject->setRelationId($iVal);
        $this->assertEquals($iVal, $oObject->getRelationId());
    }

    /**
     * Set/get image relation Id
     */
    public function testImageRelationId()
    {
        $src = __DIR__ . '/../_files/documents/sheet.xls';
        $oObject = new OLEObject($src);

        $iVal = rand(1, 1000);
        $oObject->setImageRelationId($iVal);
        $this->assertEquals($iVal, $oObject->getImageRelationId());
    }
}
