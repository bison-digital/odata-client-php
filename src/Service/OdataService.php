<?php

namespace BisonDigital\Odata\Service;

use BisonDigital\Odata\DTO\Odata;
use BisonDigital\Odata\DTO\OdataInterface;
use BisonDigital\Odata\DTO\OdataQuery;
use BisonDigital\Odata\DTO\OdataTable;
use BisonDigital\Odata\Exception\QueryException;
use BisonDigital\Odata\Model\OdataEntityId;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\UriInterface;

class OdataService {

  /**
   * OdataService constructor.
   *
   * @param \Psr\Http\Client\ClientInterface $client
   */
  public function __construct(
    protected ClientInterface $client,
  ) {
  }


  /**
   * @param \Psr\Http\Message\UriInterface $resource
   * @param \BisonDigital\Odata\DTO\OdataTable $table
   * @param \BisonDigital\Odata\DTO\OdataInterface $data
   *
   * @return \BisonDigital\Odata\Model\OdataEntityId
   *
   * @throws \BisonDigital\Odata\Exception\QueryException
   */
  public function insert(UriInterface $resource, OdataTable $table, OdataInterface $data): OdataEntityId {
//    $options = new HttpOptions(
//      [
//        'headers' => [
//          'Host' => $this->client->,
//          'Content-Type' => 'application/json',
//          'Content-Length' => strlen($body),
//        ],
//        'body' => json_encode($data)
//      ]
//    );

    $resource = $resource->withPath(sprintf('%s/%s', rtrim($resource->getPath(), '/'), $table));

    try {
      $response = $this->client->sendRequest(new Request('POST', $resource, [], $data));

      $entityUrl = $response->getHeader('OData-EntityId');

      return OdataEntityId::fromUrl(reset($entityUrl));
    } catch (ClientExceptionInterface $exception) {
      throw new QueryException($exception->getMessage());
    }
  }


  /**
   * @param \Psr\Http\Message\UriInterface $resource
   * @param \BisonDigital\Odata\DTO\OdataTable $table
   * @param \BisonDigital\Odata\DTO\OdataInterface $data
   *
   * @return \BisonDigital\Odata\Model\OdataEntityId
   *
   * @throws \BisonDigital\Odata\Exception\QueryException
   */
  public function update(UriInterface $resource, OdataTable $table, OdataInterface $data): OdataEntityId {
    try {
//      $options = new HttpOptions(
//        [
//          'headers' => [
//            'Host' => $this->resourceClient->getEndpoint(),
//            'Content-Type' => 'application/json',
//            'Content-Length' => strlen($body),
//          ],
//          'body' => json_encode($data)
//        ]
//      );

      $resource = $resource->withPath(sprintf('%s/%s', rtrim($resource->getPath(), '/'), $table));

      $response = $this->client->sendRequest(new Request('PATCH', $resource, [], $data));
      $entityUrl = $response->getHeader('OData-EntityId');

      return OdataEntityId::fromUrl(reset($entityUrl));
    } catch (ClientExceptionInterface $exception) {
      throw new QueryException($exception->getMessage());
    }
  }


  /**
   * @param \Psr\Http\Message\UriInterface $resource
   * @param \BisonDigital\Odata\DTO\OdataTable $table
   * @param \BisonDigital\Odata\DTO\OdataQuery $query
   *
   * @return \BisonDigital\Odata\DTO\Odata
   *
   * @throws \BisonDigital\Odata\Exception\QueryException
   */
  public function query(UriInterface $resource, OdataTable $table, OdataQuery $query): Odata {
    $resource = $resource->withPath(sprintf('%s/%s', rtrim($resource->getPath(), '/'), $table));
    $resource = $resource->withQuery((string) $query);

    try {
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
