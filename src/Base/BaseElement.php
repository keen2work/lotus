<?php


namespace EMedia\Lotus\Base;


abstract class BaseElement extends \Spatie\Html\BaseElement
{

	protected $tag = 'div';

	protected function escape($value)
	{
		return htmlentities($value, ENT_QUOTES, 'UTF-8', false);
	}

}