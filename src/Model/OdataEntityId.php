<?php

namespace BisonDigital\Odata\Model;

class OdataEntityId {

  /**
   * OdataEntityId constructor.
   */
  public function __construct(
    protected ?string $entityId
  ) {
  }

  public static function fromUrl(?string $entityUrl): OdataEntityId {
    $urlParts = parse_url($entityUrl);
    $pathParts = explode('/', $urlParts['path']);
    preg_match('#\((.*?)\)#',end($pathParts), $matches);
    $entityId = end($matches);

    return new static($entityId);
  }

  public function __toString() {
    return $this->entityId;
  }

}
