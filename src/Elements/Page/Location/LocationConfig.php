<?php


namespace EMedia\Lotus\Elements\Page\Location;


class LocationConfig
{

	protected $attributes = [];

	public function __construct()
	{
		$this->attributes['fieldLabel'] = null;
		$this->attributes['inputFieldPrefix'] = '';
		$this->attributes['inputFieldCssClass'] = '';
		$this->attributes['searchBoxElementId'] = 'js-places-autocomplete';
		$this->attributes['mapElementId'] = 'map';
		$this->attributes['showAddressComponents'] = false;
		$this->attributes['showMap'] = true;
		$this->attributes['address'] = null;
		$this->attributes['autoCompleteOptions'] = null;
		$this->attributes['required'] = false;
		$this->attributes['noScripts'] = false;
	}

	/**
	 *
	 * Set Google Places Autocomplete Options
	 *
	 * @param array $value
	 *
	 * @return $this
	 */
	public function setAutoCompleteOptions(array $options)
	{
		$this->attributes['autoCompleteOptions'] = $options;

		return $this;
	}

	public function setAddress($address)
	{
		$this->attributes['address'] = $address;

		return $this;
	}

	public function hideMap()
	{
		$this->attributes['showMap'] = false;

		return $this;
	}

	public function showMap()
	{
		$this->attributes['showMap'] = true;

		return $this;
	}

	public function showAddressComponents(bool $value = true)
	{
		$this->attributes['showAddressComponents'] = $value;

		return $this;
	}

	public function setFieldLabel($value)
	{
		$this->attributes['fieldLabel'] = $value;

		return $this;
	}

	public function setInputFieldPrefix($prefix)
	{
		$this->attributes['inputFieldPrefix'] = $prefix;

		return $this;
	}

	public function setInputFieldCssClass($class)
	{
		$this->attributes['inputFieldCssClass'] = $class;

		return $this;
	}

	public function setSearchBoxElementId($searchInputFieldId)
	{
		$this->attributes['searchBoxElementId'] = $searchInputFieldId;

		return $this;
	}

	public function required()
	{
		$this->attributes['required'] = true;

		return $this;
	}

	public function noScripts()
	{
		$this->attributes['noScripts'] = true;

		return $this;
	}

	public function setMapElementId($mapDivId)
	{
		$this->attributes['mapElementId'] = $mapDivId;

		return $this;
	}

	public function __get($propName)
	{
		if (array_key_exists($propName, $this->attributes)) {
			return $this->attributes[$propName];
		}

		return null;
	}

}
