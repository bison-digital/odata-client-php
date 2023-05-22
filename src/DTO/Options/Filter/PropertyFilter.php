<?php

namespace BisonDigital\Odata\DTO\Options\Filter;

/**
 * Class responsible for defining oData query filters.
 */
class PropertyFilter extends AbstractFilter {

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
   * Filter constructor.
   *
   * @param string $property
   *   Property to filter.
   * @param mixed $value
   *   Value to filter by.
   */
  public function __construct(string $property, $value) {
    $this->property = $property;
    $this->value = $value;
  }

  /**
   * {@inheritDoc}
   */
  public function __toString(): string {
    return sprintf(
      "Microsoft.Dynamics.CRM.On(PropertyName='%s',PropertyValue='%s')",
      $this->property,
      $this->value
    );
  }

}
