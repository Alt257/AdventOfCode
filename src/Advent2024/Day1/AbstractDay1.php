<?php

namespace AOC\Advent2024\Day1;

use AOC\Advent2024\AbstractDay2024;

require_once '..\AbstractDay2024.php';

abstract class AbstractDay1 extends AbstractDay2024 {

    protected const LEFT_LIST  = 'LEFT_LIST';
    protected const RIGHT_LIST = 'RIGHT_LIST';

    public function __construct() {
        parent::__construct(1);
    }

    protected function getData(array $rawData): array {
        $leftList  = [];
        $rightList = [];

        foreach($rawData as $row) {
//            echo "<div>$row</div>";
            $row    = preg_replace('/\s+/', ' ', $row);
            $values = explode(' ', $row);
//            echo '<div>' . $values[0] . ' - ' . $values[1] . '</div>';
            $leftList[]  = intval($values[0]);
            $rightList[] = intval($values[1]);
        }

        return [
            self::LEFT_LIST  => $leftList,
            self::RIGHT_LIST => $rightList,
        ];
    }

}
