<?php
/**
 * Stock Quote plugin for Craft CMS
 *
 * Stock Quote Variable
 *
 * @author    Mike Kroll
 * @copyright Copyright (c) 2017 Surprise Highway
 * @link      http://surprisehighway.com
 * @package   StockQuote
 * @since     1.0.0
 */

namespace Craft;

class StockQuoteVariable
{
    /**
     * Fetch a single quote.
     *
     * {{ craft.stockQuote.getQuote('GOOG') }}
     */
    public function getQuote($symbol = null)
    {
        return craft()->stockQuote_yahoo->getQuote($symbol)[0];
    }

    /**
     * Fetch an array of quotes for multiple symbols.
     *
     * {{ craft.stockQuote.getQuote('GOOG,MSFT') }}
     */
    public function getQuotes($symbols = null)
    {
        return craft()->stockQuote_yahoo->getQuote($symbols);
    }
}