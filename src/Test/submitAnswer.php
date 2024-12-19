<?php

use Service\AdventOfCodeService;

require_once __DIR__ . "\..\..\bootstrap.php";

function phpRequest() {
    $aoc      = new AdventOfCodeService(2024, 3);
    $response = $aoc->submit(2024, 3, 1,
                             "183669043",
    );

//    $env = new Dotenv();
//    $env->loadEnv(__DIR__ . '\..\..\.env');
//    $response = file_get_contents('https://adventofcode.com/2024/day/3/answer',
//                                  false,
//                                  stream_context_create([
//                                                            'http' => [
//                                                                'method'  => 'POST',
//                                                                'header'  => [
//                                                                    'Cookie: session=' . $_ENV['AOC_SESSION'],
//                                                                    'Content-type: application/x-www-form-urlencoded',
//                                                                ],
//                                                                'content' => 'level=1&answer=183669043',
//                                                            ],
//                                                        ]),
//    );

    echo($response);
}

function jsRequest() {
    echo "<script type='text/javascript'>";
    echo "";
    echo "</script>";
}
