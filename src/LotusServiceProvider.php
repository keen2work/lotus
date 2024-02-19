<?php


namespace EMedia\Lotus;


use EMedia\Lotus\Base\LotusHtml;
use Illuminate\Support\ServiceProvider;

class LotusServiceProvider extends ServiceProvider
{

	public function register()
	{
		$this->app->singleton(LotusHtml::class);
	}

}