<?php

namespace EMedia\Lotus\Base;

use EMedia\Lotus\Elements\EmptyBadge;
use EMedia\Lotus\Elements\Page\Breadcrumbs;
use EMedia\Lotus\Elements\EmptyStatePanel;
use EMedia\Lotus\Elements\Page\ExplainPanel;
use EMedia\Lotus\Elements\Page\Location\LocationConfig;
use EMedia\Lotus\Elements\Page\Location\LocationField;
use EMedia\Lotus\Elements\Page\PageHeadline;
use EMedia\Lotus\Elements\Page\PaginationLinks;
use EMedia\Lotus\Elements\Page\SearchField;
use EMedia\Lotus\Elements\TableHeader;
use EMedia\Lotus\Elements\Dropzone\Uploader;
use Illuminate\Contracts\Pagination\Paginator;
use Spatie\Html\Attributes;
//use Spatie\Html\Elements\A;
//use Spatie\Html\Elements\I;
use Illuminate\Http\Request;
//use Spatie\Html\Elements\Div;
//use Spatie\Html\Elements\Img;
//use Spatie\Html\Elements\File;
//use Spatie\Html\Elements\Form;
//use Spatie\Html\Elements\Span;
//use Spatie\Html\Elements\Input;
//use Spatie\Html\Elements\Label;
//use Spatie\Html\Elements\Button;
//use Spatie\Html\Elements\Legend;
//use Spatie\Html\Elements\Option;
//use Spatie\Html\Elements\Select;
//use Spatie\Html\Elements\Element;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
//use Spatie\Html\Elements\Fieldset;
//use Spatie\Html\Elements\Textarea;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Support\Htmlable;
use Spatie\Html\Elements\Element;
use Spatie\Html\Html;

class LotusHtml extends Html
{
//	use Macroable;

	/** @var \Illuminate\Http\Request */
	protected $request;

	/** @var \ArrayAccess|array */
	protected $model;

	public function __construct(Request $request)
	{
		parent::__construct($request);
	}

	/*
	|--------------------------------------------------------------------------
	| Add All Custom Elements As Functions
	|--------------------------------------------------------------------------
	*/


	/**
	 *
	 * Add the standard page Headline
	 *
	 * @param $title
	 *
	 * @return PageHeadline
	 */
	public function pageHeadline($title)
	{
		return PageHeadline::create()->withTitle($title);
	}

	/**
	 *
	 * Create the Breadcrumbs
	 *
	 * @param array $segments
	 *
	 * @return Breadcrumbs
	 */
	public function breadcrumbs(array $segments)
	{
		return Breadcrumbs::create()->segments($segments);
	}


	/**
	 *
	 * Create an Empty State panel with an optional headline and message.
	 *
	 * @param null $headline
	 * @param null $message
	 *
	 * @return EmptyStatePanel
	 */
	public function emptyStatePanel($headline = null, $message = null)
	{
		return EmptyStatePanel::create()->withHeadline($headline)->withMessage($message);
	}

	/**
	 *
	 * Create an Empty badge if the given value is empty.
	 *
	 * @param $value
	 * @param string $displayTextIfEmpty
	 * @param string $class
	 *
	 * @return EmptyBadge
	 */
	public function emptyBadge($value, $displayTextIfEmpty = 'N/A', $class = 'badge badge-pill badge-secondary')
	{
		return EmptyBadge::create()
				->setValue($value)
				->setDisplayTextIfEmpty($displayTextIfEmpty)
				->setClass($class);
	}

	/**
	 *
	 * Make the Explain Panel to display some text.
	 *
	 * @param $htmlContent
	 *
	 * @return ExplainPanel
	 */
	public function explainPanel($htmlContent)
	{
		return ExplainPanel::create()->content($htmlContent);
	}

	/**
	 *
	 * Create a Table Header from an array or a given list of values
	 *
	 * @param $columnNames
	 *
	 * @return TableHeader
	 */
	public function tableHeader($columnNames)
	{
		$args = is_array($columnNames)? $columnNames : func_get_args();

		return TableHeader::create()->columns($args);
	}

	/**
	 * @param Paginator $paginator
	 *
	 * @return mixed
	 */
	public function pageNumbers(Paginator $paginator)
	{
		return PaginationLinks::create()->withPaginator($paginator);
	}

	public function searchField()
	{
		return SearchField::create();
	}

	/**
	 * @return LocationConfig
	 */
	public function locationConfig()
	{
		return new LocationConfig();
	}

	/**
	 *
	 * Create a Google Places Autocomplete field with a map
	 *
	 * @param LocationConfig|null $locationConfig
	 *
	 * @return LocationField
	 */
	public function locationField(LocationConfig $locationConfig = null, $existingModel = null)
	{
		$locationConfig = ($locationConfig) ?? new LocationConfig();

		if ($existingModel) {
			return LocationField::create()
									->withConfig($locationConfig)
									->withEloquentModel($existingModel);
		}

		return LocationField::create()->withConfig($locationConfig);
	}

	/**
	 *
	 * Creates a Dropzone file uploader
	 *
	 * @param array $options
	 *
	 * @return Uploader
	 */
	public function uploader($options = [])
	{
		return Uploader::create()->withOptions($options);
	}

}
