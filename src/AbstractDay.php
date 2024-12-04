<?php

namespace AOC;

require_once 'Tool\InputReader.php';
require_once __DIR__ . '\..\bootstrap.php';
require_once __DIR__ . '\Entity\Solution.php';

use AOC\Entity\Solution;
use Exception;
use Tool\InputReader;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

abstract class AbstractDay {

    private static ?Environment $twigEnvironement = null;

    protected function __construct(private readonly int  $year,
                                   private readonly int  $day,
                                   private readonly ?int $part = null,
    ) {}

    /**
     * @return Environment
     */
    private static function twig(): Environment {

        if(self::$twigEnvironement === null) {
            // Specify our Twig templates location
            $loader = new FilesystemLoader(__DIR__ . '\..\templates');
            // Instantiate our Twig
            self::$twigEnvironement = new Environment($loader);
        }
        return self::$twigEnvironement;
    }

    /**
     * @return void
     */
    public function run(): void {

        $reader      = new InputReader($this->year, $this->day);
        $rawData     = $reader->loadInput();
        $rawTestData = $reader->loadTestInput();

//        var_dump($rawTestData);
//        echo "<div>" . $reader->loadTask() . "</div>";

        $testData = $this->getData($rawTestData);
        $data     = $this->getData($rawData);
//        var_dump($testData);

        $testSolution = $this->resolve($testData);
//        $this->printResult($testAnswer, true);

        $solution = $this->resolve($data);
//        $this->printResult($answer);
        try {
            $this->render(['testSolution' => $testSolution,
                           'solution'     => $solution,
                          ]);
        }
        catch(Exception $e) {
            echo '<div style="color: red; font-weight: bold; font-size: xx-large;">Erreur dans le toasteur !</div>' . $e->getMessage();
        }
    }

//    protected function printResult(string $answer, bool $istest = false) {
//        $message = 'Réponse' . ($istest ? ' pour les données de test' : '') . ' : ';
//        echo "<div style='margin-bottom: 2em;'><strong>Réponse : $answer</strong></div>";
//    }

    protected abstract function resolve(array $data): Solution;

    protected abstract function getData(array $rawData): array;

    protected function style(string $text,
                             array  $styleAttributes = [],
    ): string {
        $spanStyle = '';

        foreach($styleAttributes as $attribute => $value) {
            $spanStyle .= "$attribute: $value; ";
        }

        return "<span Style='$spanStyle'>$text</span>";
    }

    /**
     * @param array $data
     *
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    private function render(array $data = []): void {
        $data['title'] = "Advent Of Code $this->year - Day $this->day" . ($this->part === null ? '' : " - Part $this->part");
        echo self::twig()->render('day.html.twig', $data);
    }

}