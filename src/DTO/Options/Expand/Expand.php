<?php

namespace BisonDigital\Odata\DTO\Options\Expand;

use BisonDigital\Odata\DTO\Options\QueryOptionCollection;

/**
 * Defines an expand oData query parameter.
 *
 * This is used to retrieve related entities by expanding the relationship to
 * the entity you are querying.
 */
class Expand extends AbstractExpand {

  /**
   * Machine name of the entity relationship to expand.
   *
   * Also known as the associated navigation property.
   * Microsoft.Dynamics.CRM.associatednavigationproperty.
   *
   * @var string
   *
   * @link https://docs.microsoft.com/en-us/powerapps/developer/common-data-service/webapi/query-data-web-api#retrieve-related-entities-by-expanding-navigation-properties
   */
  protected $relationship;

  /**
   * Expand constructor.
   *
   * @param string $relationship
   *   Machine name of entity relationship.
   * @param \BisonDigital\Odata\DTO\Options\QueryOptionCollection|null $query_options
   *   Expand query options.
   */
  public function __construct(string $relationship, QueryOptionCollection $query_options = NULL) {
    $this->relationship = $relationship;
    $this->queryOptions = $query_options;
  }

  /**
   * {@inheritDoc}
   */
  public function __toString(): string {
    return $this->queryOptions ? $this->relationship . '(' . (string) $this->queryOptions . ')' : $this->relationship;
  }

}
