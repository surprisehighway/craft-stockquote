<?php
/**
 * Stock Quote plugin for Craft CMS
 *
 * StockQuote_Yahoo Service
 *
 * @author    Mike Kroll
 * @copyright Copyright (c) 2017 Surprise Highway
 * @link      http://surprisehighway.com
 * @package   StockQuote
 * @since     1.0.0
 */

namespace Craft;

class StockQuote_YahooService extends BaseApplicationComponent
{
    /**
     * Fetch the quote from Yahoo and parse results.
     *
     * Yahoo Formatting codes:
     *
     *  s:  Symbol
     *  n:  Name
     *  l1: Last Trade (Price Only)
     *  d1: Last Trade Date
     *  t1: Last Trade Time
     *  c1: Change
     *  o:  Open
     *  h:  Day’s High
     *  g:  Day’s Low
     *  v:  Volume
     *  p:  Previous Close
     */
    public function getQuote($symbols)
    {   
        $url = sprintf("http://download.finance.yahoo.com/d/quotes.csv?s=%s&f=snl1d1t1c1ohgvp", $symbols);

        $response = $this->request($url);
        $rows = explode("\n", $response);
        $data = array_map('str_getcsv', $rows);

        $quotes = array();

        foreach($data as $stock) 
        {
            if(!isset($stock[1])) continue;

            $quote = new StockQuote_QuoteModel();
            $quote->symbol   = $stock[0];
            $quote->name     = $stock[1];
            $quote->last     = $stock[2];
            $quote->date     = $stock[3];
            $quote->time     = $stock[4];
            $quote->change   = $stock[5];
            $quote->open     = $stock[6];
            $quote->high     = $stock[7];
            $quote->low      = $stock[8];
            $quote->volume   = $stock[9];
            $quote->previous = $stock[10];

            $quotes[] = $quote;
        }

        return $quotes;
    }

    /**
     * Use Craft's included Guzzle vendor package for the request.
     */
    private function request($url) {
        try
        {
            $client = new \Guzzle\Http\Client($url);
            $request = $client->get($url, array(
                'Accept' => 'application/octet-stream'
            ));
            
            $response = $request->send();

            return $response->getBody(true);
        } 
        catch(\Exception $e)
        {
            Craft::log($e->getResponse(), LogLevel::Error, true);
            $response = $e->getResponse();

            return $response;
        }
    }

}