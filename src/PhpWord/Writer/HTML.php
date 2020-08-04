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

namespace tyttam\PhpWord\Writer;

use tyttam\PhpWord\PhpWord;

/**
 * HTML writer
 *
 * Not supported: PreserveText, PageBreak, Object
 * @since 0.10.0
 */
class HTML extends AbstractWriter implements WriterInterface
{
    /**
     * Is the current writer creating PDF?
     *
     * @var bool
     */
    protected $isPdf = false;

    /**
     * Footnotes and endnotes collection
     *
     * @var array
     */
    protected $notes = array();

    /**
     * Create new instance
     */
    public function __construct(PhpWord $phpWord = null)
    {
        $this->setPhpWord($phpWord);

        $this->parts = array('Head', 'Body');
        foreach ($this->parts as $partName) {
            $partClass = 'tyttam\\PhpWord\\Writer\\HTML\\Part\\' . $partName;
            if (class_exists($partClass)) {
                /** @var \tyttam\PhpWord\Writer\HTML\Part\AbstractPart $part Type hint */
                $part = new $partClass();
                $part->setParentWriter($this);
                $this->writerParts[strtolower($partName)] = $part;
            }
        }
    }

    /**
     * Save PhpWord to file.
     *
     * @param string $filename
     *
     * @throws \tyttam\PhpWord\Exception\Exception
     */
    public function save($filename = null)
    {
        $this->writeFile($this->openFile($filename), $this->getContent());
    }

    /**
     * Get content
     *
     * @return string
     * @since 0.11.0
     */
    public function getContent()
    {
        $content = '';

        $content .= '<!DOCTYPE html>' . PHP_EOL;
        $content .= '<!-- Generated by PHPWord -->' . PHP_EOL;
        $content .= '<html>' . PHP_EOL;
        $content .= $this->getWriterPart('Head')->write();
        $content .= $this->getWriterPart('Body')->write();
        $content .= '</html>' . PHP_EOL;

        return $content;
    }

    /**
     * Get is PDF
     *
     * @return bool
     */
    public function isPdf()
    {
        return $this->isPdf;
    }

    /**
     * Get notes
     *
     * @return array
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Add note.
     *
     * @param int $noteId
     * @param string $noteMark
     */
    public function addNote($noteId, $noteMark)
    {
        $this->notes[$noteId] = $noteMark;
    }

    /**
     * Write document
     *
     * @deprecated 0.11.0
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function writeDocument()
    {
        return $this->getContent();
    }
}
