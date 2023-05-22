<?php

namespace BisonDigital\Odata\DTO;

use BisonDigital\Odata\DTO\Options\Expand\Expand;
use BisonDigital\Odata\DTO\Options\Expand\ExpandInterface;
use BisonDigital\Odata\DTO\Options\Filter\Filter;
use BisonDigital\Odata\DTO\Options\Filter\FilterGroup;
use BisonDigital\Odata\DTO\Options\Filter\FilterInterface;
use BisonDigital\Odata\DTO\Options\Filter\PropertyFilter;
use BisonDigital\Odata\DTO\Options\Filter\StringFilter;
use BisonDigital\Odata\DTO\Options\OrderBy\OrderBy;
use BisonDigital\Odata\DTO\Options\QueryOptionCollection;
use BisonDigital\Odata\DTO\Options\QueryOptionInterface;
use BisonDigital\Odata\DTO\Options\Select\Select;

/**
 * Odata query builder.
 */
class Query {

  /**
   * @param \BisonDigital\Odata\DTO\Options\QueryOptionCollection $queryOptions
   */
  public function __construct(
    protected QueryOptionCollection $queryOptions = new QueryOptionCollection()
  ) {
  }

  /**
   * Add a select query option.
   *
   * @param string ...$properties
   *   Property to select.
   *
   * @return $this
   */
  public function select(string ...$properties): self {
    foreach ($properties as $property) {
      $this->addQueryOption(new Select($property));
    }

    return $this;
  }

  /**
   * Add a filter to the query.
   *
   * @param string $property
   *   Filter property.
   * @param mixed $value
   *   Filter value.
   * @param string $operand
   *   Filter operand in PHP format.
   *
   * @return $this
   */
  public function filter(string $property, $value, string $operand = '='): self {
    return $this->addQueryOption(new Filter($property, $value, $operand));
  }

  /**
   * Add a string filter to the query.
   *
   * @param string $property
   *   Filter property.
   * @param string $value
   *   Filter string value.
   * @param string $operand
   *   Filter operand in PHP format.
   *
   * @return $this
   */
  public function filterString(string $property, string $value, string $operand = '='): self {
    return $this->addQueryOption(new StringFilter($property, $value, $operand));
  }

  /**
   * Creates a new group of filters with the defined logical operator.
   *
   * @code
   *   $query = new OdataQuery();
   *   $filter_group = $query->filterGroup('or')
   *     ->filter('id', 01001)
   *     ->filterString('name', 'Bill');
   *   $query->addFilter($filter_group);
   *
   * @param string $logicalOperator
   *   Logical operator that conjoins the filters.
   *
   * @return \BisonDigital\Odata\DTO\Options\Filter\FilterGroup Filter group.
   *   Filter group.
   */
  public function filterGroup(string $logicalOperator = 'and'): FilterGroup {
    return new FilterGroup([], $logicalOperator);
  }

  /**
   * Add a property filter to the query.
   *
   * @param string $property
   *   Filter property.
   * @param string $value
   *   Filter string value.
   *
   * @return $this
   */
  public function filterProperty(string $property, string $value): self {
    return $this->addQueryOption(new PropertyFilter($property, $value));
  }

  /**
   * Add filter statement value to query.
   *
   * By default multiple filters are connected by the 'and' operator. To use a
   * different logical operator, use a filter group.
   *
   * @param \BisonDigital\Odata\DTO\Options\Filter\FilterInterface $filter
   *   Filter to add to query.
   *
   * @return $this
   */
  public function addFilter(FilterInterface $filter): self {
    return $this->addQueryOption($filter);
  }

  /**
   * Expands a relationship without any query options in the expand statement.
   *
   * @param string $relationship
   *   Relationship to be expanded.
   *
   * @return $this
   */
  public function expand(string $relationship): self {
    return $this->addQueryOption(new Expand($relationship));
  }

  /**
   * Creates a new expand to which query options can be added.
   *
   * @code
   *   $query = new OdataQuery();
   *   $expand = $query->expandStatement('address')
   *     ->select('address_line_1')
   *     ->select('address_line_2');
   *   $query->addExpand($expand);
   *
   * @param string $relationship
   *   Relationship to be expanded.
   *
   * @return \BisonDigital\Odata\DTO\Options\Expand\Expand Expand statement object.
   *   Expand statement object.
   */
  public function expandStatement(string $relationship): Expand {
    return new Expand($relationship);
  }

  /**
   * Add an expand statement to the query.
   *
   * @param \BisonDigital\Odata\DTO\Options\Expand\ExpandInterface $expand
   *   Expand.
   *
   * @return $this
   */
  public function addExpand(ExpandInterface $expand): self {
    return $this->addQueryOption($expand);
  }

  /**
   * Add a simple order by option to the query.
   *
   * @param string $property
   *   Property to order by.
   *
   * @return $this
   */
  public function orderBy(string $property): self {
    return $this->addQueryOption(new OrderBy($property));
  }

  /**
   * Magic to string method.
   */
  public function __toString(): string {
    return (string) $this->queryOptions;
  }

  /**
   * Add a query option to the query option collection.
   *
   * @param \BisonDigital\Odata\DTO\Options\QueryOptionInterface $option
   *   Query option to be added.
   *
   * @return $this
   */
  protected function addQueryOption(QueryOptionInterface $option): self {
    $this->queryOptions->addOption($option);

    return $this;
  }

}
