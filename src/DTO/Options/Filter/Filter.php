<?php

namespace BisonDigital\Odata\DTO\Options\Filter;

/**
 * Class responsible for defining oData query filters.
 */
class Filter extends AbstractFilter {

  /**
   * Property to filtered by.
   *
   * @var string
   */
  protected $property;

  /**
   * Value to filer by.
   *
   * @var mixed
   */
  protected $value;

  /**
   * Comparison operator.
   *
   * Valid operands are: =, !=, >, <, >=, <=, contains.
   *
   * @var string
   */
  protected $operand;

  /**
   * Filter constructor.
   *
   * @param string $property
   *   Property to filter.
   * @param mixed $value
   *   Value to filter by.
   * @param string $operand
   *   Filter comparison operator.
   */
  public function __construct(string $property, $value, string $operand = '=') {
    $this->property = $property;
    $this->value = $value;
    $this->operand = $operand;
  }

  /**
   * {@inheritDoc}
   */
  public function __toString(): string {
    return $this->property . ' ' . $this->operandMap($this->operand) . ' ' . $this->value;
  }

}
