<?php

namespace BisonDigital\Odata\DTO;

use BisonDigital\Odata\DTO\ParameterBag;

class Odata extends ParameterBag implements OdataInterface, \JsonSerializable {

  public function bindTable(string $bind, string $table, string $value): void {
    $this->set(
      sprintf('%s@odata.bind', $bind),
      sprintf("/%s(%s)", $table, $value)
    );
  }

  public function bindTableByProperty(string $bind, string $table, string $property, $value): void {
    $this->set(
      sprintf('%s@odata.bind', $bind),
      sprintf("/%s(%s='%s')", $table, $property, $value)
    );
  }

  public function jsonSerialize(): array {
    return $this->all();
  }
}
