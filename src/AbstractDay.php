<?php

namespace AOC;

require_once 'Tool\InputReader.php';
require_once __DIR__ . '\..\bootstrap.php';

use Tool\InputReader;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractDay {

    protected function __construct(private readonly int $year,
                                   private readonly int $day,
    ) {}

    public function run(): void {

        $reader      = new InputReader($this->year, $this->day);
        $rawData     = $reader->loadInput();
        $rawTestData = $reader->loadTestInput();

//        var_dump($rawTestData);
//        echo "<div>" . $reader->loadTask() . "</div>";

        $testData = $this->getData($rawTestData);
        $data     = $this->getData($rawData);
//        var_dump($testData);

        $testAnswer = $this->resolve($testData);
        $this->printResult($testAnswer, true);

        $answer = $this->resolve($data);
        $this->printResult($answer);
    }

    protected function printResult(string $answer, bool $istest = false) {
        $message = 'Réponse' . ($istest ? ' pour les données de test' : '') . ' : ';
        echo "<div style='margin-bottom: 2em;'><strong>Réponse : $answer</strong></div>";
    }


    protected abstract function resolve(array $data): int;

    protected abstract function getData(array $rawData): array;

    protected function twig(): Environment {
        // Specify our Twig templates location
        $loader = new FilesystemLoader(__DIR__ . '\..\templates');

        // Instantiate our Twig
        return new Environment($loader);
    }

}