# Stock Quote plugin for Craft CMS

Simple real-time stock quotes from the [Alpha Vantage API](https://www.alphavantage.co/documentation/).

The Alpha Vantage API is free, but you must [register to receive and API Key](https://www.alphavantage.co/support/#api-key).

## Installation

To install Stock Quote, follow these steps:

1. Download & unzip the file and place the `stockquote` directory into your `craft/plugins` directory
2.  -OR- do a `git clone https://github.com/surprisehighway/craft-stockquote.git` directly into your `craft/plugins` folder.  You can then update it with `git pull`
3.  -OR- install with Composer via `composer require surprisehighway/craft-stockquote`
4. Install plugin in the Craft Control Panel under Settings > Plugins
5. The plugin folder should be named `stockquote` for Craft to see it.  GitHub recently started appending `-master` (the branch name) to the name of the folder for zip file downloads.

Stock Quote works on Craft 2.6.x.

## Settings

1. Navigate to `Settings > Stock Quote`.
2. Enter your [Alpha Vantage API Key](https://www.alphavantage.co/support/#api-key).
3. Save the plugin settings.

## Usage

```
{% set quote = craft.stockQuote.getQuote('MSFT') %}

{% if quote|length %}
	{{ quote.symbol }}
	{{ quote.timezone }}
	{{ quote.last }}
	{{ quote.date|date('F j, Y g:i a') }}
	{{ quote.change }}
	{{ quote.open }}
	{{ quote.high }}
	{{ quote.low }}
	{{ quote.volume }}
	{{ quote.previous }}
	{{ quote.percent }}
{% endif %}
```

#### Parameters

* **Symbol**: Required.    
* **Expire**: Optional. Cache duration in seconds. Default is `1200` (20 minutes).

## Refresh interval and caching

Stock Quote uses the [Alpha Vantage Time Series Daily API](https://www.alphavantage.co/documentation/#daily). 

The results from the API are close to real-time, but the plugin caches results. You can set a cache expiration duration (in seconds) to control the rate of refresh. Default is `1200` (20 minutes).

Note that if the API is unavailable or returns an error or incomplete data the plugin will attempt to fallback to the last valid cached data.

Wrapping the plugin output in a conditional using the Twig’s length filter is recommended.

```
{% set quote = craft.stockQuote.getQuote('MSFT', 300) %}

{% if quote|length %}
	{{ quote.last }}
{% endif %}
```

Brought to you by [Surprise Highway](http://surprisehighway.com)
