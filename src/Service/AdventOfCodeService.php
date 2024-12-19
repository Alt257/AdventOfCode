<?php

namespace Service;

use Symfony\Component\Dotenv\Dotenv;

class AdventOfCodeService {

    public const WEBSITE = "https://adventofcode.com";


    private string $rawData;

    public function __construct() {
        $env = new Dotenv();
        $env->loadEnv(__DIR__ . '\..\..\.env');
    }

    public function loadTask(int $year,
                             int $day,
    ): string {
        $url     = $this->constructTaskUrl($year, $day);
        $rawData = $this->fetch($url);
        $pattern = "#<article class=\"day-desc\">.*</article>#s";
        preg_match($pattern, $rawData, $matches);

        return $matches[0];
    }

    public function loadTestInput(int $year,
                                  int $day,
    ): array {
        $data    = $this->loadTask($year, $day);
        $pattern = "#<pre><code>(.*)</code></pre>#sU";
        preg_match($pattern, $data, $matches);

        return explode("\n", trim($matches[1]));
    }

    public function loadInput(int $year,
                              int $day,
    ): array {
        $url     = $this->constructInputUrl($year, $day);
        $rawData = $this->fetch($url);

        return explode("\n", trim($rawData));
    }

    /**
     * @param int    $level
     * @param string $answer
     *
     * @return false|string
     */
    public function submit(int    $year,
                           int    $day,
                           int    $level,
                           string $answer,
    ): false|string {
        return file_get_contents($this->constructAnswerUrl($year, $day),
                                 false,
                                 $this->constructAnswerContext($level, $answer),
        );
    }

    private function constructTaskUrl(int $year,
                                      int $day,
    ): string {
        return $this->constructURLStart($year, $day);
    }

    private function constructInputUrl(int $year,
                                       int $day,
    ): string {
        return $this->constructURLStart($year, $day) . "/input";
    }

    private function constructAnswerUrl(int $year,
                                        int $day,
    ): string {
        return $this->constructURLStart($year, $day) . "/answer";
    }

    private function constructURLStart(int $year,
                                       int $day,
    ): string {
        return self::WEBSITE . "/$year/day/$day";
    }

    private function fetch(string $url): false|string {
//        echo "<p>Récupération des données de : $url</p>";
        $context = $this->constructFetchContext('GET');
        return $rawData = file_get_contents($url,
                                            false,
                                            $context,
        );
    }

    /**
     * @param string $method
     * @param array  $content
     *
     * @return resource
     */
    private function constructFetchContext() {
        return stream_context_create([
                                         'http' => [
                                             'method' => 'GET',
                                             'header' => 'Cookie: session=' . $_ENV['AOC_SESSION'] . '\r\n',
                                         ],
                                     ],
        );
    }

    private function constructAnswerContext(int    $level,
                                            string $answer,
    ) {
        return stream_context_create([
                                         'http' => [
                                             'method'  => 'POST',
                                             'header'  => [
                                                 'Cookie: session=' . $_ENV['AOC_SESSION'],
                                                 'Content-type: application/x-www-form-urlencoded',
                                             ],
                                             'content' => "level=$level&answer=$answer",
                                         ],
                                     ],
        );
    }

}