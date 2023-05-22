<?php

namespace BisonDigital\Odata\DTO\Options\Filter;

/**
 * Defines a group of filters that will be represented in the query as a group.
 */
class FilterGroup extends AbstractFilter {

  /**
   * Filters in group.
   *
   * @var \BisonDigital\Odata\DTO\Options\Filter\FilterInterface[]
   */
  protected $filters;

  /**
   * Operator that connects the filters.
   *
   * Should be a valid logical operator: and, or, not.
   *
   * @var string
   */
  protected $logicalOperator;

  /**
   * FilterGroup constructor.
   *
   * @param \BisonDigital\Odata\DTO\Options\Filter\FilterInterface[] $filters
   *   Filters in group.
   * @param string $logical_operator
   *   Operator that connects filters.
   */
  public function __construct(array $filters, string $logical_operator = 'and') {
    $this->filters = $filters;
    $this->logicalOperator = strtolower($logical_operator);
  }

  /**
   * Adds a filter to the filter group.
   *
   * @param \BisonDigital\Odata\DTO\Options\Filter\FilterInterface $filter
   *   Filter to add to group.
   *
   * @return $this
   */
  public function addFilter(FilterInterface $filter): self {
    $this->filters[] = $filter;
    return $this;
  }

  /**
   * Add a simple filter to group.
   *
   * @param string $property
   *   Property to filter by.
   * @param mixed $value
   *   Value to filter by.
   * @param string $operand
   *   Filter operand in PHP format.
   *
   * @return $this
   */
  public function filter(string $property, $value, string $operand = '='): self {
    return $this->addFilter(new Filter($property, $value, $operand));
  }

  /**
   * Add a string filter to group.
   *
   * @param string $property
   *   Property to filter by.
   * @param string $value
   *   Value to filter by.
   * @param string $operand
   *   Filter operand in PHP format.
   *
   * @return $this
   */
  public function filterString(string $property, string $value, string $operand = '='): self {
    return $this->addFilter(new StringFilter($property, $value, $operand));
  }

  /**
   * {@inheritDoc}
   */
  public function __toString(): string {
    $group_string = '';
    foreach ($this->filters as $filter) {
      $filter_string = (string) $filter;
      if (empty($group_string)) {
        $group_string = $filter_string;
        continue;
      }

      $group_string .= ' ' . $this->logicalOperator . ' ' . $filter_string;
    }

    return '(' . $group_string . ')';
  }

}
