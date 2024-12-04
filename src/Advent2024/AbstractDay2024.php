<?php

namespace AOC\Advent2024;

require_once '..\..\AbstractDay.php';

use AOC\AbstractDay;

abstract class AbstractDay2024 extends AbstractDay {

    protected function __construct(string $inputLabel,
                                   string $calculationLabel,
                                   int    $day,
                                   ?int   $part = null,
    ) {
        parent::__construct($inputLabel,
                            $calculationLabel,
                            2024, $day, $part,
        );
    }

}