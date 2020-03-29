<?php declare(strict_types = 1);

namespace App\Elasticsearch;

final class ElasticUpdateCommand extends \Symfony\Component\Console\Command\Command
{

	/**
	 * @var \App\Model\ArticleModel\ArticleModel
	 */
	private \App\Model\ArticleModel\ArticleModel $articleModel;

	/**
	 * @var \App\Elasticsearch\MessagePublisher
	 */
	private \App\Elasticsearch\MessagePublisher $publisher;


	public function __construct(
		\App\Model\ArticleModel\ArticleModel $articleModel,
		\App\Elasticsearch\MessagePublisher $publisher
	)
	{
		parent::__construct();
		$this->articleModel = $articleModel;
		$this->publisher = $publisher;
	}


	public function configure(): void
	{
		$this->setName('es:fill-queue');
		$this->setDescription('Fill RabbitMQ Queue for update ES');
		$this->addArgument('type', \Symfony\Component\Console\Input\InputArgument::REQUIRED);
	}


	public function execute(\Symfony\Component\Console\Input\InputInterface $input,
	                        \Symfony\Component\Console\Output\OutputInterface $output
	): ?int
	{
		$type = $input->getArgument('type');

		$output->writeln('Starting...');

		switch ($type) {
			case 'articles':
				$data = $this->articleModel->getArticles();
				break;
			default:
				$data = [];
				$output->writeln('Unknown type');
				return 1;
		}

		foreach ($data as $item) {
			$this->publisher->publish($type, $item->id);
		}

		$output->writeln('Finish!');

		return 0;
	}

}
