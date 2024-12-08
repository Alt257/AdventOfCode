<?php

namespace AOC\Advent2024\Day1;

use AOC\Advent2024\AbstractDay2024;

require_once '..\AbstractDay2024.php';

abstract class AbstractDay1 extends AbstractDay2024 {

    protected const LEFT_LIST  = 'Left List';
    protected const RIGHT_LIST = 'Right List';

    protected function __construct(?int $part) {
        parent::__construct(1, $part, 'Distance');
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
