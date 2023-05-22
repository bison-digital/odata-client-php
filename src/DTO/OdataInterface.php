<?php


namespace BisonDigital\Odata\DTO;


interface OdataInterface {
  public function bindTable(string $bind, string $table, string $value);
  public function bindTableByProperty(string $bind, string $table, string $property, $value);
}
