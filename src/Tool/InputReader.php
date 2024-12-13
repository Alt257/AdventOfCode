<?php

namespace Tool;

use Symfony\Component\Dotenv\Dotenv;

class InputReader {

    private const WEBSITE = "https://adventofcode.com";


    private string $rawData;

    public function __construct(
        private readonly int $year,
        private readonly int $day,
    ) {
        $env = new Dotenv();
        $env->loadEnv(__DIR__ . '\..\..\.env');
    }

    public function loadTask(): string {
        $url     = $this->constructTaskUrl();
        $rawData = $this->fetch($url);
        $pattern = "#<article class=\"day-desc\">.*</article>#s";
        preg_match($pattern, $rawData, $matches);

        return $matches[0];
    }


    public function loadTestInput(): array {
        $data    = $this->loadTask();
        $pattern = "#<pre><code>(.*)</code></pre>#sU";
        preg_match($pattern, $data, $matches);

        return explode("\n", trim($matches[1]));
    }

    public function loadInput(): array {
        $url     = $this->constructInputUrl();
        $rawData = $this->fetch($url);

        return explode("\n", trim($rawData));
    }

    private function fetch(string $url): false|string {
//        echo "<p>Récupération des données de : $url</p>";
        $context = $this->constructContext();
        return $rawData = file_get_contents($url,
                                            false,
                                            $context,
        );
    }

    private function constructTaskUrl(): string {
        return self::WEBSITE . "/$this->year/day/$this->day";
    }

    private function constructInputUrl(): string {
        return self::WEBSITE . "/$this->year/day/$this->day/input";
    }

    private function constructContext() {
        $session_cookie = $_ENV['AOC_SESSION'];
        return stream_context_create([
                                         "http" => [
                                             "method" => "GET",
                                             "header" => "Accept-languange: en-US,en;q=0.9\r\n" .
                                                 "Cookie: session=" . $session_cookie . "\r\n",
                                         ],
                                     ]);
    }

}