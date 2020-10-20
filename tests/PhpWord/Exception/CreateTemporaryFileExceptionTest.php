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

namespace tyttam\PhpWord\Exception;

/**
 * @covers \tyttam\PhpWord\Exception\CreateTemporaryFileException
 * @coversDefaultClass \tyttam\PhpWord\Exception\CreateTemporaryFileException
 */
class CreateTemporaryFileExceptionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * CreateTemporaryFileException can be thrown.
     *
     * @covers            ::__construct()
     * @expectedException \tyttam\PhpWord\Exception\CreateTemporaryFileException
     * @test
     */
    public function testCreateTemporaryFileExceptionCanBeThrown()
    {
        throw new CreateTemporaryFileException();
    }
}
