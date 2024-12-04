<?php

namespace AOC\Entity;

class SolutionRow {

    private string $input;
    private string $calculation;

    /**
     * @return string
     */
    public function getInput(): string {
        return $this->input;
    }

    /**
     * @param string $input
     *
     * @return SolutionRow
     */
    public function setInput(string $input): SolutionRow {
        $this->input = $input;
        return $this;
    }

    /**
     * @return string
     */
    public function getCalculation(): string {
        return $this->calculation;
    }

    /**
     * @param string $calculation
     *
     * @return SolutionRow
     */
    public function setCalculation(string $calculation): SolutionRow {
        $this->calculation = $calculation;
        return $this;
    }

}