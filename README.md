# Stock Quote plugin for Craft CMS

Simple real-time stock quotes from Yahoo Finance.

## Installation

To install Stock Quote, follow these steps:

1. Download & unzip the file and place the `stockquote` directory into your `craft/plugins` directory
2.  -OR- do a `git clone https://github.com/surprisehighway/craft-stockquote.git` directly into your `craft/plugins` folder.  You can then update it with `git pull`
3.  -OR- install with Composer via `composer require surprisehighway/craft-stockquote`
4. Install plugin in the Craft Control Panel under Settings > Plugins
5. The plugin folder should be named `stockquote` for Craft to see it.  GitHub recently started appending `-master` (the branch name) to the name of the folder for zip file downloads.

Stock Quote works on Craft 2.4.x and Craft 2.5.x.

## Usage

### Single Quote

```
{% set quote = craft.stockQuote.getQuote('RLGT') %}

{{ quote.symbol }}
{{ quote.name }}
{{ quote.last }}
{{ quote.date }}
{{ quote.time }}
{{ quote.change }}
{{ quote.open }}
{{ quote.high }}
{{ quote.low }}
{{ quote.volume }}
{{ quote.previous }}
```
### Multiple Symbols

```
{% set quotes = craft.stockQuote.getQuotes('GOOG,MSFT') %}

{% for quote in quotes %}
	{{ quote.symbol }}
	{{ quote.date }}
	{{ quote.time }}
	{{ quote.change }}
{% endfor %}
```

### Caching

Depending on your site traffic it might make sense to cache the results
instead of querying Yahoo on every page load.

```
{% cache using key "stockquote" for 5 mins %}

	{% set quote = craft.stockQuote.getQuote('RLGT') %}

	{{ quote.symbol }}
	{{ quote.date }}
	{{ quote.time }}
	{{ quote.change }}

{% endcache %}
```

Brought to you by [Surprise Highway](http://surprisehighway.com)
