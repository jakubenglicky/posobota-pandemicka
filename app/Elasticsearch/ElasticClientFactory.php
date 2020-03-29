<?php declare(strict_types = 1);

namespace App\Elasticsearch;

final class ElasticClientFactory
{

	private const INDEX_PREFIX = 'posobota_';

	private array $hosts;


	public function __construct(array $hosts)
	{
		$this->hosts = $hosts;
	}


	public function load()
	{
		$builder = \Elasticsearch\ClientBuilder::create();
		$builder->setHosts($this->hosts);

		return $builder->build();
	}


	public function indexName(string $type): string
	{
		$index = self::INDEX_PREFIX;
		$index .= $type;
		$index = \Nette\Utils\Strings::lower($index);

		return $index;
	}

}
