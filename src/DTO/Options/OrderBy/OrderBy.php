<?php

namespace BisonDigital\Odata\DTO\Options\OrderBy;

/**
 * Simple oData order by query option.
 */
class OrderBy implements OrderByInterface {

  /**
   * OrderBy constructor.
   *
   * @param string $property
   *   Property to order by.
   */
  public function __construct(protected string $property) {
  }

  /**
   * {@inheritDoc}
   */
  public function getKey(): string {
    return '$orderby';
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

  /**
   * {@inheritDoc}
   */
  public function __toString(): string {
    return $this->property;
  }

}
