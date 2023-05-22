<?php

namespace BisonDigital\Odata\DTO\Options\Select;

/**
 * Base class for oData select options.
 */
abstract class AbstractSelect implements SelectInterface {

  /**
   * {@inheritDoc}
   */
  public function getKey(): string {
    return '$select';
  }

  /**
   * {@inheritDoc}
   */
  public function appendTo(string $options_string): string {
    if (!$options_string) {
      return (string) $this;
    }

    return $options_string . ',' . (string) $this;
  }

}
