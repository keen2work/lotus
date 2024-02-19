<?php


namespace EMedia\Lotus\Elements\Page;


use EMedia\Lotus\Base\BaseElement;
use Illuminate\Support\HtmlString;

class SearchField extends BaseElement
{

	public function render()
	{
		$query = request('q');

		return new HtmlString('<form action=""><div class="input-group">
			<input type="text" class="form-control" name="q" placeholder="Search" value="' . $this->escape($query) . '">
			<span class="input-group-append">
				<button class="btn btn-success" type="submit">Search</button>
			</span>
		</div></form>');
	}

}