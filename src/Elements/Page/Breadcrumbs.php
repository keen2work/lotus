<?php


namespace EMedia\Lotus\Elements\Page;


use EMedia\Lotus\Base\BaseElement;
use Illuminate\Support\HtmlString;

class Breadcrumbs extends BaseElement
{

	protected $tag = 'nav';

	protected $segments = [];

	public function segments(array $segments)
	{
		$this->segments = $segments;

		return $this;
	}

	public function render()
	{
		$html = html();

		$mergedHtml = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';

		for ($i = 0, $iMax = count($this->segments); $i < $iMax; $i++) {
			$segment = $this->segments[$i];

			if (empty($segment[0])) throw new \InvalidArgumentException("A breadcrumb segment is missing text.");
			$li = $html->element('li')->addClass('breadcrumb-item');
			if (isset($segment[2]) && $segment[2] === true) {
				$li = $li->addClass('active')->attribute('aria-current', 'page');
			}

			if (!empty($segment[1])) {
				$child = $html->a($segment[1], $segment[0]);
				$li = $li->addChild($child);
			} else {
				$li = $li->html($segment[0]);
			}

			$mergedHtml .= $li->toHtml();
		}

		$mergedHtml .= '</ol></nav>';

		return new HtmlString(
			$mergedHtml
		);
	}

}