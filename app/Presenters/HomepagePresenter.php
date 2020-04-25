<?php declare(strict_types=1);

namespace App\Presenters;

use Nette;

final class HomepagePresenter extends Nette\Application\UI\Presenter
{

	/**
	 * @var \App\Elasticsearch\Facade
	 */
	private \App\Elasticsearch\Facade $articleFacade;

	/**
	 * @var \App\Cache
	 */
	private \App\Cache $cache;


	public function __construct(
		\App\Cache $cache,
		\App\Elasticsearch\Facade $articleFacade
	)
	{
		parent::__construct();
		$this->articleFacade = $articleFacade;
		$this->cache = $cache;
	}


	public function actionDefault()
	{
		$articles = $this->cache->load()->load('articles');

		if ( ! $articles) {
			$articles = $this->articleFacade->getAll();
		}

		$this->getTemplate()->add('articles', $articles);
	}

}
