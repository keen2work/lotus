<?php


namespace EMedia\Lotus\Elements;

use EMedia\Lotus\Base\BaseElement;
use Illuminate\Support\HtmlString;

class EmptyStatePanel extends BaseElement
{

	protected $headline;

	protected $message;

	public function withHeadline($headline)
	{
		$this->headline = $headline;

		return $this;
	}

	public function withMessage($message)
	{
		$this->message = $message;

		return $this;
	}

	public function render()
	{
		$headline = $this->headline ?? 'Nothing to see here!';
		$message  = $this->message ?? "This section is empty because we don't have any data to show.";

		return new HtmlString(
			'<div class="card border-success">
  <div class="card-header">
    ' . $this->escape($headline) . '
  </div>
  <div class="card-body">
    <p class="card-text">' . $this->escape($message) . '</p>
  </div>
</div>'
		);
	}

}