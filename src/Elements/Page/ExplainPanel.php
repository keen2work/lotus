<?php


namespace EMedia\Lotus\Elements\Page;


use EMedia\Lotus\Base\BaseElement;
use Illuminate\Support\HtmlString;

class ExplainPanel extends BaseElement
{

	protected $content;

	public function content($htmlContent)
	{
		$this->content = $htmlContent;

		return $this;
	}

	public function render()
	{
		$html = '<div class="shadow-none p-3 mb-3 bg-light rounded">' .
				$this->escapeKeepLinks($this->content) .
				'</div>';

		return new HtmlString($html);
	}

	protected function escapeKeepLinks($html)
	{
		return strip_tags($html, '<a>');
	}

}