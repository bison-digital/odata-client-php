<?php

namespace BisonDigital\Odata\DTO\Options;

/**
 * A collection of oData query options.
 */
class QueryOptionCollection {

  /**
   * Query options, sorted by key.
   *
   * @var array
   */
  protected array $queryOptions = [];

  /**
   * QueryOptionCollection constructor.
   *
   * @param \BisonDigital\Odata\DTO\Options\QueryOptionInterface[] $query_options
   *   Query options to set.
   */
  public function __construct(array $query_options = []) {
    $this->set($query_options);
  }

  /**
   * Get query options of a key type.
   *
   * @param string $option_key
   *   Option key type to get options for.
   *
   * @return array
   *   Options of type.
   */
  public function get(string $option_key): array {
    return $this->queryOptions[$option_key] ?? [];
  }

  /**
   * Set all query options.
   *
   * @param \BisonDigital\Odata\DTO\Options\QueryOptionInterface[] $options
   *   Query options.
   */
  public function set(array $options): void {
    $this->queryOptions = [];
    foreach ($options as $option) {
      if ($option instanceof QueryOptionInterface) {
        $this->queryOptions[$option->getKey()][] = $option;
      }
    }
  }

  /**
   * Add a query option to the collection.
   *
   * @param \BisonDigital\Odata\DTO\Options\QueryOptionInterface $option
   *   Query option to add to collection.
   */
  public function addOption(QueryOptionInterface $option) {
    $this->queryOptions[$option->getKey()][] = $option;
  }

  /**
   * Get all the query options.
   *
   * @return array
   *   Query options.
   */
  public function getQueryOptions(): array {
    return $this->queryOptions;
  }

  /**
   * Query string parts as an array by parameter option key.
   *
   * @return array
   *   Query string parts.
   */
  public function toQueryParts(): array {
    $query_parts = [];

    foreach ($this->queryOptions as $key => $options) {
      $option_str = '';
      foreach ($options as $option) {
        $option_str = $option->appendTo($option_str);
      }

      $query_parts[$key] = $option_str;
    }

    return $query_parts;
  }

  /**
   * Magic to string method.
   */
  public function __toString(): string {
    $query_parts = $this->toQueryParts();
    return $query_parts ? urldecode(http_build_query($query_parts)) : '';
  }

}
