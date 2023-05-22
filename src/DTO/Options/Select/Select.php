<?php

namespace BisonDigital\Odata\DTO\Options\Select;

/**
 * Defines a property to be selected by the query.
 */
class Select extends AbstractSelect {

  /**
   * Property to select.
   *
   * @var string
   */
  protected $property;

  /**
   * Select constructor.
   *
   * @param string $property
   *   Property to select.
   */
  public function __construct(string $property) {
    $this->property = $property;
  }

  /**
   * {@inheritDoc}
   */
  public function __toString(): string {
    return $this->property;
  }

}
