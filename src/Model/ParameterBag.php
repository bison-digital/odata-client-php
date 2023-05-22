<?php

namespace BisonDigital\Odata\Model;

class ParameterBag {
  /**
   * Parameter storage.
   */
  protected array $parameters;

  public function __construct(array $parameters = [])
  {
    $this->parameters = $parameters;
  }

  /**
   * Returns the parameters.
   *
   * @param string|null $key The name of the parameter to return or null to get them all
   */
  public function all(): array
  {
    return $this->parameters;
  }

  /**
   * Returns the parameter keys.
   */
  public function keys(): array
  {
    return array_keys($this->parameters);
  }

  /**
   * Replaces the current parameters by a new set.
   *
   * @return void
   */
  public function replace(array $parameters = []): void
  {
    $this->parameters = $parameters;
  }

  /**
   * Adds parameters.
   *
   * @return void
   */
  public function add(array $parameters = []): void
  {
    $this->parameters = array_replace($this->parameters, $parameters);
  }

  public function get(string $key, mixed $default = null): mixed
  {
    return \array_key_exists($key, $this->parameters) ? $this->parameters[$key] : $default;
  }

  /**
   * @return void
   */
  public function set(string $key, mixed $value)
  {
    $this->parameters[$key] = $value;
  }

  /**
   * Returns true if the parameter is defined.
   */
  public function has(string $key): bool
  {
    return \array_key_exists($key, $this->parameters);
  }

  /**
   * Removes a parameter.
   *
   * @return void
   */
  public function remove(string $key): void
  {
    unset($this->parameters[$key]);
  }
}