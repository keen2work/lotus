# Lotus - Build HTML Elements

Build common HTML elements in 1 line of code.

### Version Compatibility

| Laravel Version | This Package Version |       Branch |
|----------------:|---------------------:|-------------:|
|             v10 |                  3.0 |       master |  
|              v9 |                  2.0 |          2.x |  
|              v8 |                  1.6 | version/v1.0 |  

See [CHANGE LOG](CHANGELOG.md) for change history.

### Installation Instructions

Add the repository to `composer.json`
```
"repositories": [
	{
	    "type":"vcs",
	    "url":"git@bitbucket.org:elegantmedia/lotus.git"
	}
]
```

```
composer require emedia/lotus
```

### Change Log

- v1.4 - Laravel v5 support Dropped. For Laravel v5, use v1.3

## Dropzone

Lotus has [Dropzone](https://www.dropzonejs.com/) as a dependency.

There are two options to install the package:

### 1. NPM

Run `npm install --save dropzone` to install the package.

Add the js file by requiring/importing  `dropzone` (usually in *app.js*)

```js
require('dropzone')
```

Next, we'll include the styles by importing it into a scss file that's already in the project.

**backend.scss**

```scss
// Dropzone
@import '~dropzone/src/dropzone.scss';
``` 

### 2. Standalone

Manually download the standalone files and view instruction [here](https://www.dropzonejs.com/#installation).


### Available Elements

Use these function calls directly within Blade templates.

#### Main Page Headline
```
{{ lotus()->pageHeadline('My New Page') }}
```

#### Breadcrumbs
```
{{ lotus()->breadcrumbs([
    ['Dashboard', route('dashboard')],
    ['Google', 'http://www.google.com'],
    ['Microsoft', 'http://www.microsoft.com'],
    ['Tesla', null, true]
]) }}
```
The last parameter should be `true` if it should be `active`

#### Empty State Panel
```
{{-- Default --}}
{{ lotus()->emptyStatePanel() }}

{{-- Panel with Custom Messages --}}
{{ lotus()->emptyStatePanel('Welcome to Oxygen', "Let's Build Something New!") }}
```

#### Empty Badge
```
// This will render a (N/A) badge if the given string is empty.
{{ lotus()->emptyBadge($object->title) }}

// Customise the text
{{ lotus()->emptyBadge($string, 'Not Provided') }}

// Custom class
{{ lotus()->emptyBadge($string, 'Not Provided', 'badge badge-pill badge-warning') }}
```

#### Explain Panel (Generic HTML)
```
{{ lotus()->explainPanel('<div>Show my thing here</div>') }}
```

#### Table Header

Render a table `<thead>` section

```
{{ lotus()->tableHeader('ID', 'Name', 'Age', 'Actions') }}

{{-- Pass a CSS Class --}}
{{ lotus()->tableHeader('ID', 'Name', 'Age', 'Actions|text-right') }}
```

#### Page Numbers (Pagination)

Show the page number links for a page. Accepts a `LengthAwarePaginator` object.

```
{{ lotus()->pageNumbers(Users::paginate()) }}
```

#### Search Field

Get a query string and post back to the same page with a `q` in the URL
```
{{ lotus()->searchField() }}
```

#### Google Places Autocomplete & Map

Create a Google Places Autocomplete field for address lookup. This element will also breakdown an address to components such as address, city, postcode, state, country, country code.

**[See Location Field Wiki](https://bitbucket.org/elegantmedia/lotus/wiki/Location%20Field)**

### Creating Custom Elements

Lotus is a wrapper around [Laravel HTML](https://github.com/spatie/laravel-html).

So you can do calls such as,
```
{{ lotus()->span()->text('Hello world!')->class('fa fa-eye') }}
```

### Want to Add New Elements?

Create a new branch and submit a pull request.
