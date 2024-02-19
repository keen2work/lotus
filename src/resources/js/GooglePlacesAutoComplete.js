window._location = window._location || {};
if (!window._location.places) window._location.places = [];
if (!window._location.autoCompleteOptions) window._location.autoCompleteOptions = [];
if (!window._location.debug) window._location.debug = false;

window._location.placeToAddressObject = function (place){
	var address = {
		formatted_address: '',
		street: '',
		street_2: '',
		latitude: null,
		longitude: null,
	};

	if (place.name) address.name = place.name;
	if (place.formatted_address) address.formatted_address = place.formatted_address;
	if (place.website) address.website = place.website;
	if (place.formatted_phone_number) address.phone = place.formatted_phone_number ;
	if (place.international_phone_number) address.phone_iso = place.international_phone_number;

	if (place.geometry && place.geometry.location) {
		if (place.geometry.location.lat) address.latitude = place.geometry.location.lat();
		if (place.geometry.location.lng) address.longitude = place.geometry.location.lng();
	}

	if (place.address_components) {
		place.address_components.forEach(function (c) {
			if (!c.long_name) return;

			switch (c.types[0]) {
				case 'subpremise':
				case 'premise':
					if (address.street.length > 0) {
						address.street += ', ';
					}
					address.street += c.long_name;
					break;
				case 'street_number':
				case 'route':
					if (address.street_2.length > 0) {
						address.street_2 += ', ';
					}
					address.street_2 += c.long_name;
					break;
				case 'neighborhood':
				case 'locality':
					address.city = c.long_name;
					break;
				case 'administrative_area_level_1':     //  Note some countries don't have states
					address.state = c.long_name;
					if (c.short_name) address.state_iso_code = c.short_name;
					break;
				case 'postal_code':
					address.zip = c.long_name;
					break;
				case 'country':
					address.country = c.long_name;
					if (c.short_name) address.country_iso_code = c.short_name;
					break;
			}
		});
	}

	if (window._location.debug) console.log('Address Object', address);

	return address;
};

window._location.populateFieldsFromData = function(fieldPrefix, fieldData) {
	for (var prop in fieldData) {
		// append the address values to input fields on the page
		// you may define an optional prefix
		var element = window.document.querySelector('input.js-autocomplete[name="' + fieldPrefix + prop + '"]');
		if (element) {
			element.value = fieldData[prop];
		}
	}
};

window.initAutoComplete = function() {

	var mapDataObjects = _location.places;

	if (window._location.debug) console.log('Map Data Objects', mapDataObjects);

	for (var i = 0, len = mapDataObjects.length; i < len; i++) {
		var mapDataObject = mapDataObjects[i];

		var input = document.getElementById(mapDataObject.searchBoxElementId);
		if (!input) {
			console.error('Element with an ID `' + mapDataObject.searchBoxElementId + '` not found on page. Google Places Autocomplete disabled for this element.');
			return;
		}

		// safety check
		var searchBoxes = document.querySelectorAll('[id=' + mapDataObject.searchBoxElementId + ']');
		if (searchBoxes.length > 1) {
			console.error('More than one element with ID `' + mapDataObject.searchBoxElementId + '` found on page. Google Places Autocomplete disabled for duplicate elements. Give a unique ID for the location field.');
		}

		// prevent form submission when enter key is pressed - otherwise it will submit the form
		input.addEventListener('keydown', function (event) {
			if (event.keyCode === 13) {
				event.preventDefault();
			}
		});

		// Initiate the autocomplete box
		// Autocomplete box can be shown without a map
		// https://developers.google.com/maps/documentation/javascript/places-autocomplete
		// https://developers.google.com/maps/documentation/javascript/reference/places-widget#AutocompleteOptions
		var autoCompleteOptions = {};
		if (mapDataObject['autoCompleteOptions']) {
			autoCompleteOptions = mapDataObject.autoCompleteOptions;
		} else {
			if (!Array.isArray(_location.autoCompleteOptions)) {
				console.error('_location.autoCompleteOptions must be an array');
			}
			if (_location.autoCompleteOptions[i]) {
				autoCompleteOptions = _location.autoCompleteOptions[i];
			}
		}
		var autoComplete = new google.maps.places.Autocomplete(input, autoCompleteOptions);

		(function (autoCompleteReference, mapDataObject) {
			// listener to get the location
			autoCompleteReference.addListener('place_changed', function () {
				var place = autoCompleteReference.getPlace();

				if (window._location.debug) console.log('place_changed event fired', place);

				if (!place) return false;

				var addressData = _location.placeToAddressObject(place);
				_location.populateFieldsFromData(mapDataObject.inputFieldPrefix, addressData);
			});

			// safety check
			var mapElements = document.querySelectorAll('[id=' + mapDataObject.mapElementId + ']');
			if (mapElements.length > 1) {
				console.error('More than one element with ID `' + mapDataObject.mapElementId + '` found on page. Google Map disabled for duplicate elements. Give a unique ID for the map element.');
			}

			// set the map
			var mapElement = document.getElementById(mapDataObject.mapElementId);

			if (mapElement) {
				mapElement.style.width = '100%';
				mapElement.style.height = '200px';

				// set the default focus location
				var currentLocation = {lat: -33.8688, lng: 151.2195};
				var hasInitialLocation = false;
				if (mapDataObject.currentLocation) {
					currentLocation = mapDataObject.currentLocation;
					hasInitialLocation = true;
				}

				var map = new google.maps.Map(mapElement, {
					center: currentLocation,
					zoom: 13,
					mapTypeId: 'roadmap',
					mapTypeControl: false,
					streetViewControl: false,
					fullscreenControl: false
				});

				// Bias the SearchBox results towards current map's viewport.
				map.addListener('bounds_changed', function () {
					autoCompleteReference.setBounds(map.getBounds());
				});

				// keep track of all markers
				var markers = [];

				// show the default marker
				if (hasInitialLocation && currentLocation) {
					markers.push(new google.maps.Marker({
						map: map,
						position: currentLocation
					}));
				}

				// Listen for the event fired when the user selects a prediction and retrieve
				// more details for that place.
				autoCompleteReference.addListener('place_changed', function () {
					var place = autoCompleteReference.getPlace();
					if (!place) return false;

					// Clear out the old markers.
					markers.forEach(function (marker) {
						marker.setMap(null);
					});
					markers = [];

					// For each place, get the icon, name and location.
					var bounds = new google.maps.LatLngBounds();
					//places.forEach(function (place) {
						if (!place.geometry) {
							if (window._location.debug) console.log('Returned place contains no geometry', place);
							return;
						}
						var icon = {
							url: place.icon,
							size: new google.maps.Size(71, 71),
							origin: new google.maps.Point(0, 0),
							anchor: new google.maps.Point(17, 34),
							scaledSize: new google.maps.Size(25, 25)
						};

						// Create a marker for each place.
						markers.push(new google.maps.Marker({
							map: map,
							icon: icon,
							title: place.name,
							position: place.geometry.location
						}));

						if (place.geometry.viewport) {
							// Only geocodes have viewport.
							bounds.union(place.geometry.viewport);
						} else {
							bounds.extend(place.geometry.location);
						}
					//});
					map.fitBounds(bounds);
				});
			}

		}(autoComplete, mapDataObject));
	}

};
