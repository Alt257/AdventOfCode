<?php

namespace AOC\Advent2024\Day2;

require_once 'AbstractDay2.php';

class Day2Part2 extends AbstractDay2 {

    private const  MIN_DIFF_LEVEL = 1;
    private const  MAX_DIFF_LEVEL = 3;

    private const  SECURITY_OK     = '<span style="color: green">OK</span>';
    private const  SECURITY_UNSAFE = '<span style="color: red">UNSAFE</span>';

    protected function resolve(array $data): int {
        echo $this->twig()->render('day.html.twig', [
            'test'   => 'Ahke coucou ?',
            'titles' => ['Report', 'Security'],
            'rows'   => [
                ['data' => [1, 2, 3, 4, 5], 'result' => ['OK']],
                ['data' => [1, 2, 3, 4, 5], 'result' => ['OK']],
                ['data' => [1, 2, 3, 4, 5], 'result' => ['UNSAFE']],
                ['data' => [1, 2, 3, 4, 5], 'result' => ['OK']],
                ['data' => [1, 2, 3, 4, 5], 'result' => ['MDR']],
            ],
        ]);

        return 0;
    }

}

(new Day2Part2())->run();