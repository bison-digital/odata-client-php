<?php


namespace BisonDigital\Odata\DTO;


class OdataTable {
  protected ?string $updateKey = null;

  /**
   * OdataTable constructor.
   *
   * @param string $key
   */
  public function __construct(
    protected string $key,
  ) {
  }

  public function __toString() {
    $string =  $this->key;

    if ($this->updateKey) {
      $string = $string . sprintf('(%s)', $this->updateKey);
    }

    return $string;
  }

  public function setUpdateKey(string $key): void {
    $this->updateKey = $key;
  }

}
