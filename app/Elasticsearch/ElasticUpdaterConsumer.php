<?php declare(strict_types = 1);

namespace App\Elasticsearch;

final class ElasticUpdaterConsumer implements \Gamee\RabbitMQ\Consumer\IConsumer
{

	/**
	 * @var \App\Model\ArticleModel\ArticleModel
	 */
	private \App\Model\ArticleModel\ArticleModel $articleModel;

	/**
	 * @var \App\Elasticsearch\IndexData
	 */
	private \App\Elasticsearch\IndexData $indexData;


	public function __construct(
		\App\Model\ArticleModel\ArticleModel $articleModel,
		\App\Elasticsearch\IndexData $indexData
	)
	{
		$this->articleModel = $articleModel;
		$this->indexData = $indexData;
	}


	public function consume(\Bunny\Message $message): int
	{
		$data = $message->content;
		$data = \json_decode($data);

		$id = $data->id;

		$article = $this->articleModel->getById($id);

		$body = new Article(
			$article['id'],
			$article['title'],
			$article['content']
		);

		$this->indexData->index($body);


		return \Gamee\RabbitMQ\Consumer\IConsumer::MESSAGE_ACK;
	}

}
