<?php

require_once 'Tool\InputReader.php';
require_once __DIR__ . '\..\bootstrap.php';
require_once __DIR__ . '\Entity\Solution.php';

use Entity\Solution;
use Tool\InputReader;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

abstract class AbstractDay {

    private static ?Environment $twigEnvironement = null;

    /**
     * @Template array<Solution>
     */
    protected array $solutions;

    protected function __construct(private readonly int     $year,
                                   private readonly int     $day,
                                   private readonly ?int    $part = null,
                                   private readonly ?string $calculationLabel = null,
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
        $rawTestData = $reader->loadTestInput();
        $rawData     = $reader->loadInput();

        $this->addSolution('Test data', $rawTestData);
        $this->addSolution('Input', $rawData);

        foreach($this->solutions as $solution) {
            $result = $this->resolve($solution, $solution->getData());
            $solution->setResult($result);
        }

        try {
            $this->render(['solutions' => $this->solutions]);
        }
        catch(Exception $e) {
            echo '<div style="color: red; font-weight: bold; font-size: xx-large;">Erreur dans le toasteur !</div>' . $e->getMessage();
        }
    }

    protected function addSolution(string $solutionName,
                                   array  $rawData,
    ): Solution {
        $data              = $this->getData($rawData);
        $solution          = new Solution($solutionName, $data, $this->calculationLabel);
        $this->solutions[] = $solution;
        return $solution;
    }

//    protected function printResult(string $answer, bool $istest = false) {
//        $message = 'Réponse' . ($istest ? ' pour les données de test' : '') . ' : ';
//        echo "<div style='margin-bottom: 2em;'><strong>Réponse : $answer</strong></div>";
//    }

    protected abstract function resolve(Solution $solution,
                                        array    $data,
    ): int;

    protected abstract function getData(array $rawData): array;

    /** Returns a htlm dom element representing the formated text
     *
     * @param array $content associative array with
     *                       mandatory key 'text' => string
     *                       and optional key 'css' => array<string, string> of css attribute => value
     *
     * @return string
     */
    protected function style(array $content): string {
        $text            = $content['text'];
        $styleAttributes = $content['css'] ?? [];

        $spanStyle = '';

        foreach($styleAttributes as $attribute => $value) {
            $spanStyle .= "$attribute: $value; ";
        }

        return "<span Style='$spanStyle'>$text</span>";
    }

    protected function col(string  $text,
                           ?string $width = null,
                           ?int    $columnNum = null,
    ): string {
        return $this->style([
                                'text' => $text,
                                'css'  => [
                                    'grid-column'  => $columnNum ?? 'auto',
                                    'grid-row'     => 1,
                                    'column-width' => $width ?? 'fit-content',
                                ],
                            ],
        );
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
        $data['year']  = $this->year;
        $data['day']   = $this->day;
        $data['part']  = $this->part;
        echo self::twig()->render('day.html.twig', $data);
    }

}