<?php declare(strict_types = 1);

namespace App;

class Cache
{

	private \Nette\Caching\Cache $cache;


	public function __construct(
		\Nette\Caching\Storage $storage
	)
	{
		$this->cache = new \Nette\Caching\Cache($storage);
	}


	public function load(): \Nette\Caching\Cache
	{
		return $this->cache;
	}

}
