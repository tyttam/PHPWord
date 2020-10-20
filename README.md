# ![PHPWord](https://rawgit.com/PHPOffice/PHPWord/develop/docs/images/phpword.svg "PHPWord")
## Installation

PHPWord is installed via [Composer](https://getcomposer.org/).
To [add a dependency](https://getcomposer.org/doc/04-schema.md#package-links) to PHPWord in your project, either

Run the following to use the latest stable version
```sh
    composer require tyttam/phpword
```
or if you want the latest master version
```sh
    composer require tyttam/phpword:dev-master
```

You can of course also manually edit your composer.json file
```json
{
    "require": {
       "tyttam/phpword": "v0.16.*"
    }
}
```
##New methods
```php
// Display lines on axes
private $displayAxisLines = true;
public function getDisplayAxisLines(): bool
function setDisplayAxisLines(bool $display = true): \tyttam\PhpWord\Style\Chart
==================================================
//spacing between columns
private $spacingOverlapColumns = 100;
public function setSpacingOverlapColumns(int $spacingOverlapColumns = 100): \tyttam\PhpWord\Style\Chart
public function getSpacingOverlapColumns(): int
==================================================
private $showAxisX = true;
// Responsible for showing the axis x
public function setShowAxisX(bool $show = true): \tyttam\PhpWord\Style\Chart
public function showAxisY(): bool
==================================================
private $showAxisY = true;
// Responsible for showing the axis y
public function setShowAxisY(bool $show = true): \tyttam\PhpWord\Style\Chart
public function showAxisY(): bool

==================================================
// ONLY PIE CHARTS
==================================================

/**
* Set the valueLabelPosition setting
* "none"    - skips writing labels
* "nextTo"  - sets labels next to the value
* "low"     - sets labels are below the graph
* "high"    - sets labels above the graph
*/
public function setValueLabelPosition($labelPosition): Chart
==================================================
private $dataLabelPosition = 'outEnd';
/**
* Set the data label position
* "bestFit"     - Best Fit
* "ctr"	        - Center
* "inEnd"	- Inside End
* "outEnd"	- Outside End
*/
public function setDataLabelPosition(mixed $datLabelPosition): Chart
// Get the data label position
public function getDataLabelPosition(): string
==================================================
private $showSeparatorsInLabel = false;
public function setShowSeparatorsInLabel(bool $show): Chart
public function showSeparatorsInLabel(): bool

==================================================
// END ONLY PIE CHARTS
==================================================
```
