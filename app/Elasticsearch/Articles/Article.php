<?php declare(strict_types = 1);

namespace App\Elasticsearch;

final class Article implements \Spameri\ElasticQuery\Document\BodyInterface
{

	private int $id;

	private string $title;

	private string $content;


	public function __construct(
		int $id,
		string $title,
		string $content
	)
	{
		$this->id = $id;
		$this->title = $title;
		$this->content = $content;
	}


	public function toArray(): array
	{
		return [
			'id' => $this->id,
			'title' => $this->title,
			'content' => $this->content,
		];
	}


	public function getTitle(): string
	{
		return $this->title;
	}


	public function getContent(): string
	{
		return $this->content;
	}

}
