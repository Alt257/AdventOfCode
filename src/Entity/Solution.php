<?php

namespace AOC\Entity;

require_once 'SolutionRow.php';

class Solution {

    private string $name;
    private string $inputLabel;
    private string $calculationLabel;
    private array  $data = [];
    private int    $result;

    /**
     * @return array<SolutionRow>
     */
    public function getData(): array {
        return $this->data;
    }

    public function addData(string $input, string $calculation): Solution {
        $this->data[] = (new SolutionRow())->setInput($input)
                                           ->setCalculation($calculation);
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Solution
     */
    public function setName(string $name): Solution {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getInputLabel(): string {
        return $this->inputLabel;
    }

    /**
     * @param string $inputLabel
     *
     * @return Solution
     */
    public function setInputLabel(string $inputLabel): Solution {
        $this->inputLabel = $inputLabel;
        return $this;
    }

    /**
     * @return string
     */
    public function getCalculationLabel(): string {
        return $this->calculationLabel;
    }

    /**
     * @param string $calculationLabel
     *
     * @return Solution
     */
    public function setCalculationLabel(string $calculationLabel): Solution {
        $this->calculationLabel = $calculationLabel;
        return $this;
    }

    /**
     * @return int
     */
    public function getResult(): int {
        return $this->result;
    }

    /**
     * @param int $result
     *
     * @return Solution
     */
    public function setResult(int $result): Solution {
        $this->result = $result;
        return $this;
    }

}