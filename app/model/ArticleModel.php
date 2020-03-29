<?php declare(strict_types = 1);

namespace App\Model\ArticleModel;

final class ArticleModel
{

	/**
	 * @var \Nette\Database\Connection
	 */
	private \Nette\Database\Connection $connection;


	public function __construct(\Nette\Database\Connection $connection)
	{
		$this->connection = $connection;
	}


	public function getArticles(): array
	{
		return $this->connection->fetchAll('SELECT * FROM articles');
	}


	public function getById(int $id): ?\Nette\Database\IRow
	{
		return $this->connection->fetch('SELECT * FROM articles WHERE id = ?', $id);
	}


	public function save(array $data): int
	{
		$data['created_at'] = new \DateTime();
		$this->connection->query('INSERT INTO articles (title, content) VALUES (?, ?)', $data['title'], $data['content']);

		return (int) $this->connection->getInsertId();
	}

}
