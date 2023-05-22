<?php

namespace BisonDigital\Odata\DTO\Options\Filter;

/**
 * Base class for oData filter query options.
 */
abstract class AbstractFilter implements FilterInterface {

  /**
   * {@inheritDoc}
   */
  public function getKey(): string {
    return '$filter';
  }

  /**
   * {@inheritDoc}
   */
  public function appendTo(string $options_string): string {
    if (!$options_string) {
      return (string) $this;
    }

    return $options_string . ' and ' . (string) $this;

  }

  /**
   * Map php operators to oData.
   *
   * @param string $operand
   *   A php operator.
   *
   * @return string
   *   The equivalent oData operator.
   */
  protected function operandMap(string $operand): string {
    $map = [
      '=' => 'eq',
      '!=' => 'ne',
      '>' => 'gt',
      '>=' => 'ge',
      '<' => 'lt',
      '<=' => 'le',
      'contains' => 'contains',
    ];

    return $map[$operand];
  }

}
