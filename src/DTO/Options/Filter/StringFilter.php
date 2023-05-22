<?php

namespace BisonDigital\Odata\DTO\Options\Filter;

/**
 * Class responsible for defining oData query filters.
 *
 * String values are wrapped in quotes.
 */
class StringFilter extends Filter {

  /**
   * {@inheritDoc}
   */
  public function __toString(): string {
    switch ($this->operand) {
      case 'contains':
        return 'contains(' . $this->property . ', \'' . $this->value . '\')';

      default:
        return $this->property . ' ' . $this->operandMap($this->operand) . ' \'' . $this->value . '\'';
    }
  }

}
