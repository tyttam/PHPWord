<?php
include_once 'Sample_Header.php';

// New Word document
echo date('H:i:s'), ' Create new PhpWord object', EOL;
$phpWord = new \tyttam\PhpWord\PhpWord();

// New section
$section = $phpWord->addSection();

// Add Line elements
// See Element/Line.php for all options
$section->addText('Horizontal Line (Inline style):');
$section->addLine(
    array(
        'width'       => \tyttam\PhpWord\Shared\Converter::cmToPixel(4),
        'height'      => \tyttam\PhpWord\Shared\Converter::cmToPixel(0),
        'positioning' => 'absolute',
    )
);
$section->addText('Vertical Line (Inline style):');
$section->addLine(
    array(
        'width'       => \tyttam\PhpWord\Shared\Converter::cmToPixel(0),
        'height'      => \tyttam\PhpWord\Shared\Converter::cmToPixel(1),
        'positioning' => 'absolute',
    )
);
// Two text break
$section->addTextBreak(1);

$section->addText('Positioned Line (red):');
$section->addLine(
    array(
        'width'            => \tyttam\PhpWord\Shared\Converter::cmToPixel(4),
        'height'           => \tyttam\PhpWord\Shared\Converter::cmToPixel(1),
        'positioning'      => 'absolute',
        'posHorizontalRel' => 'page',
        'posVerticalRel'   => 'page',
        'marginLeft'       => \tyttam\PhpWord\Shared\Converter::cmToPixel(10),
        'marginTop'        => \tyttam\PhpWord\Shared\Converter::cmToPixel(8),
        'wrappingStyle'    => \tyttam\PhpWord\Style\Image::WRAPPING_STYLE_SQUARE,
        'color'            => 'red',
    )
);

$section->addText('Horizontal Formatted Line');
$section->addLine(
    array(
        'width'       => \tyttam\PhpWord\Shared\Converter::cmToPixel(15),
        'height'      => \tyttam\PhpWord\Shared\Converter::cmToPixel(0),
        'positioning' => 'absolute',
        'beginArrow'  => \tyttam\PhpWord\Style\Line::ARROW_STYLE_BLOCK,
        'endArrow'    => \tyttam\PhpWord\Style\Line::ARROW_STYLE_OVAL,
        'dash'        => \tyttam\PhpWord\Style\Line::DASH_STYLE_LONG_DASH_DOT_DOT,
        'weight'      => 10,
    )
);

// Save file
echo write($phpWord, basename(__FILE__, '.php'), $writers);
if (!CLI) {
    include_once 'Sample_Footer.php';
}
