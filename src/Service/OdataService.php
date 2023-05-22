<?php

namespace BisonDigital\Odata\Service;

use BisonDigital\Odata\DTO\Odata;
use BisonDigital\Odata\DTO\OdataInterface;
use BisonDigital\Odata\DTO\Query;
use BisonDigital\Odata\DTO\Table;
use BisonDigital\Odata\Exception\QueryException;
use BisonDigital\Odata\DTO\OdataEntityId;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\UriInterface;

class OdataService {

  /**
   * @param \Psr\Http\Client\ClientInterface $client
   * @param \Psr\Http\Message\UriInterface $uri
   */
  public function __construct(
    protected ClientInterface $client,
    protected UriInterface $uri,
  ) {
  }


  /**
   * @param \BisonDigital\Odata\DTO\Table $table
   * @param \BisonDigital\Odata\DTO\OdataInterface $data
   *
   * @return \BisonDigital\Odata\DTO\OdataEntityId
   *
   * @throws \BisonDigital\Odata\Exception\QueryException
   */
  public function insert(Table $table, OdataInterface $data): OdataEntityId {
    $resource = $this->uri->withPath(sprintf('%s/%s', rtrim($this->uri->getPath(), '/'), $table));

    try {
      $response = $this->client->sendRequest(new Request('POST', $resource, [], $data));

      $entityUrl = $response->getHeader('OData-EntityId');

      return OdataEntityId::fromUrl(reset($entityUrl));
    } catch (ClientExceptionInterface $exception) {
      throw new QueryException($exception->getMessage());
    }
  }


  /**
   * @param \BisonDigital\Odata\DTO\Table $table
   * @param \BisonDigital\Odata\DTO\OdataInterface $data
   *
   * @return \BisonDigital\Odata\DTO\OdataEntityId
   *
   * @throws \BisonDigital\Odata\Exception\QueryException
   */
  public function update(Table $table, OdataInterface $data): OdataEntityId {
    try {
      $resource = $this->uri->withPath(sprintf('%s/%s', rtrim($this->uri->getPath(), '/'), $table));

      $response = $this->client->sendRequest(new Request('PATCH', $resource, [], $data));
      $entityUrl = $response->getHeader('OData-EntityId');

      return OdataEntityId::fromUrl(reset($entityUrl));
    } catch (ClientExceptionInterface $exception) {
      throw new QueryException($exception->getMessage());
    }
  }


  /**
   * @param \BisonDigital\Odata\DTO\Table $table
   * @param \BisonDigital\Odata\DTO\Query $query
   *
   * @return \BisonDigital\Odata\DTO\Odata
   *
   * @throws \BisonDigital\Odata\Exception\QueryException
   */
  public function query(Table $table, Query $query): OdataInterface {
    try {
      $resource = $this->uri->withPath(sprintf('%s/%s', rtrim($this->uri->getPath(), '/'), $table));
      $resource = $resource->withQuery((string) $query);

      $response = $this->client->sendRequest(new Request('GET', $resource));

      $body = json_decode($response->getBody(), TRUE);

      if (array_key_exists('value', $body)) {
        $body = $body['value'] ?? [];
      }

      return new Odata($body);
    } catch (ClientExceptionInterface $exception) {
      throw new QueryException($exception->getMessage());
    }
  }

}
