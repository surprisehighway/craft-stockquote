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
 * @since     1.1.0
 */

namespace Craft;

class StockQuote_AlphaVantageService extends BaseApplicationComponent
{
    /**
     * Get the quote data from cache or refresh.
     */
    public function getQuote($symbol, $expire)
    {
        // check for symbol
        if(empty($symbol))
        {
            return false;
        }

        // check cache or refresh data
        if(craft()->fileCache->get($symbol)) 
        {
            $data = craft()->fileCache->get($symbol);
        }
        else
        {
            // update current values or fallback to stale cache
            if ($refresh = $this->fetchQuote($symbol))
            {
                $data = $refresh;
                craft()->fileCache->set($symbol, $data, $expire);
                craft()->fileCache->set($symbol.':stale', $data, 0);
            }
            else
            {
                $data = craft()->fileCache->get($symbol.':stale');
            }
        }

        // be sure we have valid data
        if (sizeof($data) < 2) 
        {
            StockQuotePlugin::log('StockQuote Error: Invalid or incomplete stock data.', LogLevel::Error, true);
            return false;
        }

        // meta
        $metaData = $data['Meta Data'];
        $lastRefresh = $metaData['3. Last Refreshed'];
        $timezone = $metaData['5. Time Zone'];

        // prices
        $timeSeries = $data['Time Series (Daily)'];
        $last = array_shift($timeSeries);
        $lastDate = new DateTime($lastRefresh);
        $lastDate->sub(new DateInterval('P1D'));
        $prevDate = $lastDate->format('Y-m-d');
        
        foreach ($timeSeries as $date => $day) 
        {
            if ($date == $prevDate) {
                $prev = $day;
                break;
            }
        }

        // assemble values and calculate change
        $open      = round($last['1. open'], 2);
        $high      = round($last['2. high'], 2);
        $low       = round($last['3. low'], 2);
        $lastClose = round($last['4. close'], 2);
        $prevClose = round($prev['4. close'], 2);
        $change    = $lastClose - $prevClose;
        $percent   = round(($change / $prevClose) * 100, 2);

        // populate data model
        $quote = new StockQuote_QuoteModel();
        $quote->symbol   = $symbol;
        $quote->timezone = $timezone;
        $quote->last     = $lastClose;
        $quote->date     = $lastRefresh;
        $quote->change   = number_format($change, 2);
        $quote->open     = $open;
        $quote->high     = $high;
        $quote->low      = $low;
        $quote->volume   = $last['5. volume'];
        $quote->previous = $prevClose;
        $quote->percent  = $percent;

        return $quote;
    }

    /**
     * Fetch the quote from Alpha Vantage parse results.
     *
     * @see https://www.alphavantage.co/documentation/#daily
     */
    public function fetchQuote($symbol)
    {   
        $plugin = craft()->plugins->getPlugin('StockQuote');
        $apiKey = $plugin->getSettings()->apiKey;

        if(empty($apiKey))
        {
            StockQuotePlugin::log('StockQuote Error: API Key setting missing.', LogLevel::Error, true);
            return false;
        } 

        $url = sprintf("https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=%s&apikey=%s", $symbol, $apiKey);

        if($response = $this->request($url))
        {
            $data = json_decode($response, true);

            if(isset($data['Error Message']))
            {
                StockQuotePlugin::log('StockQuote Error: '.$data['Error Message'], LogLevel::Error, true);
                return false;
            }

            if (sizeof($data) < 2) {
                StockQuotePlugin::log('StockQuote Error: Invalid or incomplete data.', LogLevel::Error, true);
                return false;
            }

            StockQuotePlugin::log('StockQuote: Successful request to Alpha Vantage API.', LogLevel::Info); // only logged in devMode
            return $data;
        }

        StockQuotePlugin::log('StockQuote Error: Unable to connect to Alpha Vantage API.', LogLevel::Error, true);
        return false;
    }

    /**
     * Use Craft's included Guzzle vendor package for the request.
     */
    private function request($url) {
        try
        {
            $client = new \Guzzle\Http\Client($url);
            $request = $client->get($url);
            
            $response = $request->send();

            return $response->getBody(true);
        } 
        catch(\Exception $e)
        {
            StockQuotePlugin::log($e->getResponse(), LogLevel::Error, true);
            $response = $e->getResponse();

            return $response;
        }
    }
}