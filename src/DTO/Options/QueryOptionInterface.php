<?php

namespace BisonDigital\Odata\DTO\Options;

/**
 * Interface for defining oData query option parameters.
 */
interface QueryOptionInterface {

  /**
   * Gets the query option key for the generated URL.
   *
   * @return string
   *   Query string key.
   */
  public function getKey(): string;

  /**
   * Build string for options of type. Appends to existing portion of string.
   *
   * @param string $options_string
   *   Existing portion of type string to append new item to.
   *
   * @return string
   *   Complete string for option type.
   */
  public function appendTo(string $options_string): string;

  /**
   * Format query option as a string.
   *
   * @return string
   *   Query option string.
   */
  public function __toString(): string;

}
