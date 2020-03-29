<?php declare(strict_types=1);

namespace App\Presenters;

use Nette;

final class NewPresenter extends Nette\Application\UI\Presenter
{

	/**
	 * @var \App\Model\ArticleModel\ArticleModel
	 */
	private \App\Model\ArticleModel\ArticleModel $articleModel;

	/**
	 * @var \App\Elasticsearch\MessagePublisher
	 */
	private \App\Elasticsearch\MessagePublisher $messagePublisher;


	public function __construct(
		\App\Model\ArticleModel\ArticleModel $articleModel,
		\App\Elasticsearch\MessagePublisher $messagePublisher
	)
	{
		parent::__construct();
		$this->articleModel = $articleModel;
		$this->messagePublisher = $messagePublisher;
	}


	public function createComponentArticleForm(): Nette\Application\UI\Form
	{
		$form = new Nette\Application\UI\Form();

		$form->addText('title', 'Název článku');
		$form->addTextArea('content', 'Obsah');

		$form->addSubmit('save', 'Uložit');

		$form->onSuccess[] = function (Nette\Application\UI\Form $form) {
			$articleId = $this->articleModel->save($form->getValues(TRUE));

			$this->messagePublisher->publish('article', $articleId);

			$this->flashMessage('Článek byl přidán');
			$this->redirect('Homepage:');
		};

		return $form;
	}

}
