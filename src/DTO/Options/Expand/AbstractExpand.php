<?php

namespace BisonDigital\Odata\DTO\Options\Expand;

use BisonDigital\Odata\DTO\OdataQuery;

/**
 * Base class for the expand query options.
 *
 * An extend is pretty much a sub query of the main query, since the same query
 * options are available within the expand option.
 */
abstract class AbstractExpand extends OdataQuery implements ExpandInterface {

  /**
   * {@inheritDoc}
   */
  public function getKey(): string {
    return '$expand';
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
