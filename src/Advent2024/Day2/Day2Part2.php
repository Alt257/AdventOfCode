<?php

namespace AOC\Advent2024\Day2;

use AOC\Entity\Solution;

require_once 'AbstractDay2.php';
require_once '..\..\Entity\Solution.php';

class Day2Part2 extends AbstractDay2 {

    function __construct() {
        parent::__construct(2);
    }

    /**
     * @param array $data
     *
     * @return \AOC\Entity\Solution
     */
    protected function resolve(array $data): \AOC\Entity\Solution {
        $solution = (new Solution())->setInputLabel('')
                                    ->setCalculationLabel('');

        
        return $solution;
    }

}

(new Day2Part2())->run();