<?php


namespace EMedia\Lotus\Elements\Page\Location;


use EMedia\Lotus\Base\BaseElement;
use Illuminate\Support\HtmlString;

class LocationField extends BaseElement
{

	/** @var LocationConfig $inputFieldPrefix */
	protected $locationConfig = null;
	protected $model = [];

	public function withConfig(LocationConfig $locationConfig)
	{
		$this->locationConfig = $locationConfig;

		return $this;
	}

	public function withEloquentModel($model)
	{
		$this->model = $model;

		return $this;
	}

	protected function getFieldValue($fieldName)
	{
		$returnValue = '';

		if ($this->model) {
			$returnValue = $this->model->$fieldName;
		}

		if ($this->locationConfig->$fieldName) $returnValue = $this->locationConfig->$fieldName;

		return $this->escape($returnValue);
	}

	/**
	 *
	 * Render the element
	 *
	 * @return \Illuminate\Contracts\Support\Htmlable|HtmlString
	 */
	public function render()
	{
		if (!$this->locationConfig) throw new \InvalidArgumentException('LocationConfig must be set before rendering a location field.');

		$inputFieldPrefix = $this->escape($this->locationConfig->inputFieldPrefix);
		$inputFieldCssClass = $this->escape($this->locationConfig->inputFieldCssClass);
		$fieldLabel = $this->escape($this->locationConfig->fieldLabel);
		$autoCompleteOptions = $this->locationConfig->autoCompleteOptions;
		$mapElementId = $this->escape($this->locationConfig->mapElementId);
		$searchBoxElementId = $this->escape($this->locationConfig->searchBoxElementId);
		$required = $this->locationConfig->required;
		$noScripts = $this->locationConfig->noScripts;
		$searchFieldDataAttributes = '';

		$autoCompleteOptionString = ($autoCompleteOptions) ? json_encode($autoCompleteOptions) : 'null';

		$lat = $this->getFieldValue($inputFieldPrefix . 'latitude');
		$lng = $this->getFieldValue($inputFieldPrefix . 'longitude');

		$currentLocation = 'null';
		if ($lat !== '' && $lng !== '') {
			$currentLocation = "{lat: $lat, lng: $lng}";
		}

		$htmlString = '
			<div class="form-group-location location-field-address row">';

		if ($fieldLabel) {
			$htmlString .= '<label for="" class="col-sm-2 control-label">' . $fieldLabel . '</label>';
		}

		if ($noScripts) {
			$searchFieldDataAttributes = 'data-map-element-id="' . $mapElementId . '" ' .
			'data-search-box-element-id="' . $searchBoxElementId . '" ' .
			'data-input-field-prefix="' . $inputFieldPrefix .'" ' .
			'data-auto-complete-options=\'' . $autoCompleteOptionString . '\' ' .
			'data-current-location="' . $currentLocation . '" ';
		}

		$htmlString .= '<div class="col-sm-12 mb-2">
				<input type="text" id="' . $searchBoxElementId . '" class="form-control js-autocomplete' . $inputFieldCssClass . '" name="' . $inputFieldPrefix . 'address" autocomplete="false" value="' . $this->getFieldValue($inputFieldPrefix . 'address') . '"' . ($required ? 'required' : '') . ' ' . $searchFieldDataAttributes . '>
			</div>
		</div>';

		$addressComponentsCss = '';
        if (!$this->locationConfig->showAddressComponents) {
			$addressComponentsCss = 'd-none';
		}
        	$htmlString .= '
				<div class="form-group-location location-field-address-components row ' . $addressComponentsCss . '">
					<div class="col-sm-12">
						<div class="row mb-2">
							<div class="col-6">
								<input type="text" name="' . $inputFieldPrefix . 'formatted_address" class="form-control js-autocomplete js-tooltip" data-title="Address" readonly placeholder="(Address)" value="' . $this->getFieldValue($inputFieldPrefix . 'formatted_address') . '">
							</div>
							<div class="col-3">
								<input type="text" name="' . $inputFieldPrefix . 'latitude" class="form-control js-autocomplete js-tooltip" data-title="Latitude" readonly placeholder="(Latitude)" value="' . $this->getFieldValue($inputFieldPrefix . 'latitude') . '">
							</div>
							<div class="col-3">
								<input type="text" name="' . $inputFieldPrefix . 'longitude" class="form-control js-autocomplete js-tooltip" data-title="Longitude" readonly placeholder="(Longitude)" value="' . $this->getFieldValue($inputFieldPrefix . 'longitude') . '">
							</div>
						</div>
						<div class="row mb-2">
							<div class="col">
								<input type="text" name="' . $inputFieldPrefix . 'street" class="form-control js-autocomplete js-tooltip" data-title="Street" readonly placeholder="(Street)" value="' . $this->getFieldValue($inputFieldPrefix . 'street') . '">
							</div>
							<div class="col">
								<input type="text" name="' . $inputFieldPrefix . 'street_2" class="form-control js-autocomplete js-tooltip" data-title="Street 2" readonly placeholder="(Street 2)" value="' . $this->getFieldValue($inputFieldPrefix . 'street_2') . '">
							</div>
						</div>
						<div class="row mb-2">
							<div class="col">
								<input type="text" name="' . $inputFieldPrefix . 'city" class="form-control js-autocomplete js-tooltip" data-title="City" readonly placeholder="(City)" value="' . $this->getFieldValue($inputFieldPrefix . 'city') . '">
							</div>
							<div class="col">
								<input type="text" name="' . $inputFieldPrefix . 'state" class="form-control js-autocomplete js-tooltip" data-title="State" readonly placeholder="(State)" value="' . $this->getFieldValue($inputFieldPrefix . 'state') . '">
							</div>
							<div class="col">
								<input type="text" name="' . $inputFieldPrefix . 'state_iso_code" class="form-control js-autocomplete js-tooltip" data-title="State Code" readonly placeholder="(State Code)" value="' . $this->getFieldValue($inputFieldPrefix . 'state_iso_code') . '">
							</div>
							<div class="col">
								<input type="text" name="' . $inputFieldPrefix . 'zip" class="form-control js-autocomplete js-tooltip" data-title="Post Code" readonly placeholder="(Post Code)" value="' . $this->getFieldValue($inputFieldPrefix . 'zip') . '">
							</div>
							<div class="col">
								<input type="text" name="' . $inputFieldPrefix . 'country" class="form-control js-autocomplete js-tooltip" data-title="Country" readonly placeholder="(Country)" value="' . $this->getFieldValue($inputFieldPrefix . 'country') . '">
							</div>
							<div class="col">
								<input type="text" name="' . $inputFieldPrefix . 'country_iso_code" class="form-control js-autocomplete js-tooltip" data-title="Country Code" readonly placeholder="(Country Code)" value="' . $this->getFieldValue($inputFieldPrefix . 'country_iso_code') . '">
							</div>
						</div>
					</div>
				</div>';

		if ($this->locationConfig->showMap) {
			$htmlString .= '
			<div class="form-group-location location-field-map row">
				<div class="col-sm-12">
					<div id="' . $mapElementId . '"></div>
				</div>
			</div>';
		}

		if (!$noScripts) {
			$htmlString .= '<script>
				window._location = window._location || {};
				if (!window._location.places) window._location.places = [];
				window._location.places.push({
					mapElementId: "' . $mapElementId . '",
					searchBoxElementId: "' . $searchBoxElementId . '",
					inputFieldPrefix: "' . $inputFieldPrefix .'",
					autoCompleteOptions: ' . $autoCompleteOptionString . ',
					currentLocation: ' . $currentLocation . '
				});
			</script>';
		}

		return new HtmlString($htmlString);
	}

}
