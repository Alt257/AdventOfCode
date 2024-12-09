<?php

namespace AOC\Entity;

class Solution {

    private array $dataStyles   = [];
    private array $calculations = [];
    private int   $result;

    /**
     * @param string $name
     * @param array  $data
     */
    public function __construct(private string         $name,
                                private readonly array $data,
                                private ?string        $calculationLabel = null,
    ) {
        $this->calculationLabel ??= 'Calculation';
    }

    /**
     * @return array
     */
    public function getDataStyles(): array {
        return $this->dataStyles;
    }

    /**
     * @param array $dataStyles
     *
     * @return Solution
     */
    public function setDataStyles(array $dataStyles): Solution {
        $this->dataStyles = $dataStyles;
        return $this;
    }

    public function getDataStyle(string $column,
                                 int    $row,
                                 ?int   $index = null,
    ): string {
        if($index !== null) return $this->dataStyles[$column][$row][$index] ?? '';
        else                return $this->dataStyles[$column][$row] ?? '';
    }

    public function setDataStyle(array   $styleMap,
                                 int     $row,
                                 ?int    $index = null,
                                 ?string $column = null,
    ): self {
        $style = '';

        foreach($styleMap as $attribute => $value) {
            $style .= "$attribute: $value; ";
        }

        // @formatter:off
        if      ($column === null && $index === null)   $this->dataStyles[$row] = $style;
        else if (                    $index === null)   $this->dataStyles[$column][$row] = $style;
        else if ($column === null)                      $this->dataStyles[$row][$index] = $style;
        else                                            $this->dataStyles[$column][$row][$index] = $style;
        // @formatter:on

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCalculationLabel(): ?string {
        return $this->calculationLabel;
    }

    public function setCalculationLabel(string $calculationLabel): self {
        $this->calculationLabel = $calculationLabel;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getDataLabels(): array {
        return array_keys($this->data);
    }

    /**
     * @return array
     */
    public function getData(): array {
        return $this->data;
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
     * @param int    $row
     * @param string $calculation
     *
     * @return $this
     */
    public function setCalculation(int    $row,
                                   string $calculation,
    ): Solution {
        $this->calculations[$row] = $calculation;
        return $this;
    }

    /**
     * @param int $row
     *
     * @return string
     */
    public function getCalculation(int $row): string {
        return $this->calculations[$row] ?? '';
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