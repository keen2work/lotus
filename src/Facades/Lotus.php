<?php


namespace EMedia\Lotus\Facades;


use EMedia\Lotus\Base\LotusHtml;

class Lotus
{

	protected static function getFacadeAccessor()
	{
		return LotusHtml::class;
	}

}