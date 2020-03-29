<?php declare(strict_types = 1);

namespace App\Elasticsearch;

final class IndexData
{

	/**
	 * @var ElasticClientFactory
	 */
	private ElasticClientFactory $clientFactory;

	/**
	 * @var \Elasticsearch\Client
	 */
	private $client;



	public function __construct(\App\Elasticsearch\ElasticClientFactory $clientFactory)
	{
		$this->client = $clientFactory->load();
		$this->clientFactory = $clientFactory;
	}


	public function index(\Spameri\ElasticQuery\Document\BodyInterface $body): void
	{
		$document = new \Spameri\ElasticQuery\Document(
			$this->clientFactory->indexName((new \ReflectionClass($body))->getShortName()),
			$body
		);

		$this->client->index($document->toArray());
	}

}
