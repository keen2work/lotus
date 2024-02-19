<?php


namespace EMedia\Lotus\Elements\Page;


use EMedia\Lotus\Base\BaseElement;
use Illuminate\Support\HtmlString;

class PageHeadline extends BaseElement
{

	protected $tag = 'div';

	protected $title;

	public function withTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	public function render()
	{
		$html = '<div class="title-container">
			<div class="page-title">
				<h1>' . $this->escape($this->title) . '</h1>
			</div>
		</div>';

		return new HtmlString($html);
	}

}