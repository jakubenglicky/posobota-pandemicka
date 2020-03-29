<?php declare(strict_types = 1);

namespace App\Elasticsearch;

final class MessagePublisher
{

	/** 
	 * @var \Gamee\RabbitMQ\Producer\Producer 
	 */
	private \Gamee\RabbitMQ\Producer\Producer $producer;


	public function __construct(\Gamee\RabbitMQ\Client $client)
	{
		$this->producer = $client->getProducer('elasticUpdate');
	}


	public function publish(string $type, int $id)
	{
		$data = [
			'type' => $type,
			'id' => $id,
		];

		$this->producer->publish(
			\json_encode($data)
		);
	}

}
