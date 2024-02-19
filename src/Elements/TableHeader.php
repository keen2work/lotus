<?php


namespace EMedia\Lotus\Elements;


use EMedia\Lotus\Base\BaseElement;
use Illuminate\Support\HtmlString;

class TableHeader extends BaseElement
{

	protected $tag = 'thead';

	protected $columns = [];

	public function columns($columnNames)
	{
		$columnNames = is_array($columnNames)? $columnNames : func_get_args();

		$this->columns = $columnNames;

		return $this;
	}

	public function render()
	{
		$headers = $this->columns;

		$output = '<thead><tr>';

		foreach ($headers as $header) {
			// split the CSS class, delimited by "|"
			$elements = explode('|', $header);
			if (isset($elements[1])) {
				$output .= '<th class="' . $this->escape($elements[1]) . '">' . $elements[0] . '</th>';
			} else {
				$output .= '<th>' . $header . '</th>';
			}
		}

		$output .= '</tr></thead>';

		return new HtmlString($output);
	}

}