<?php

namespace AOC\Advent2024;

require_once '..\..\AbstractDay.php';

use AOC\AbstractDay;

abstract class AbstractDay2024 extends AbstractDay {

    protected function __construct(int  $day,
                                   ?int $part = null,
    ) {
        parent::__construct(2024, $day, $part);
    }

}