<?php


namespace EMedia\Lotus\Elements\Page;


use EMedia\Lotus\Base\BaseElement;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\HtmlString;

class PaginationLinks extends BaseElement
{

	protected $paginator;

	public function withPaginator(Paginator $paginator)
	{
		$this->paginator = $paginator;

		return $this;
	}

	public function render()
	{
		/** @var Request $request */
		$request = request();

		/** @var Paginator $paginator */
		$paginator = $this->paginator;

		if (!$paginator) throw new \InvalidArgumentException("The paginator provided is invalid");

		$htmlString = $paginator->appends($request->except('page'))->links();

		return new HtmlString('<div class="mt-3 mb-3 pagination-links">' . $htmlString . '</div>');
	}

}