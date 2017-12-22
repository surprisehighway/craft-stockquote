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
    public function getQuote($symbol = null, $expire = 1200)
    {
        return craft()->stockQuote_alphaVantage->getQuote($symbol, $expire);
    }
}