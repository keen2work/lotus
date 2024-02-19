<?php


namespace EMedia\Lotus\Elements;


use Illuminate\Support\HtmlString;

class EmptyBadge extends \EMedia\Lotus\Base\BaseElement
{

	protected $value;
	protected $displayTextIfEmpty;
	protected $class;

	public function render()
	{
		if (!empty($this->value)) {
			return new HtmlString($this->escape($this->value));
		}

		return new HtmlString('<span class="' . $this->escape($this->class ?? '') . '">' .
			$this->escape($this->displayTextIfEmpty ?? '') . '</span>');
	}

	/**
	 * @param mixed $displayTextIfEmpty
	 *
	 * @return EmptyBadge
	 */
	public function setDisplayTextIfEmpty($displayTextIfEmpty)
	{
		$this->displayTextIfEmpty = $displayTextIfEmpty;
		return $this;
	}

	/**
	 * @param mixed $class
	 *
	 * @return EmptyBadge
	 */
	public function setClass($class)
	{
		$this->class = $class;
		return $this;
	}

	/**
	 * @param mixed $value
	 *
	 * @return EmptyBadge
	 */
	public function setValue($value)
	{
		$this->value = $value;
		return $this;
	}

}