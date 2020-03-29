<?php declare(strict_types = 1);

namespace App\Elasticsearch;

final class Facade
{

	/**
	 * @var ElasticClientFactory
	 */
	private ElasticClientFactory $elasticClientFactory;

	/**
	 * @var \Elasticsearch\Client $client
	 */
	private \Elasticsearch\Client $client;


	public function __construct(\App\Elasticsearch\ElasticClientFactory $elasticClientFactory)
	{
		$this->client = $elasticClientFactory->load();
		$this->elasticClientFactory = $elasticClientFactory;
	}


	public function getAll()
	{
		$query = new \Spameri\ElasticQuery\ElasticQuery();

		$document = new \Spameri\ElasticQuery\Document(
			$this->elasticClientFactory->indexName('article'),
			new \Spameri\ElasticQuery\Document\Body\Plain($query->toArray())
		);

		$esResult = $this->client->search($document->toArray());

		$data = $esResult['hits']['hits'] ?? [];

		$articles = [];
		foreach ($data as $item)  {
			$source = $item['_source'];

			$articles[] = new Article(
				$source['id'],
				$source['title'],
				$source['content']
			);
		}

		return $articles;
	}

}
