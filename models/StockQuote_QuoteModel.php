<?php
/**
 * Stock Quote plugin for Craft CMS
 *
 * StockQuote_QuoteModel
 *
 * @author    Mike Kroll
 * @copyright Copyright (c) 2017 Surprise Highway
 * @link      http://surprisehighway.com
 * @package   StockQuote
 * @since     1.0.0
 */
 
namespace Craft;

class StockQuote_QuoteModel extends BaseModel
{
    protected function defineAttributes()
    {
        return array(
            'symbol'   => AttributeType::String,
            'name'     => AttributeType::String,
            'last'     => AttributeType::String,
            'date'     => AttributeType::String,
            'time'     => AttributeType::String,
            'change'   => AttributeType::String,
            'open'     => AttributeType::String,
            'high'     => AttributeType::String,
            'low'      => AttributeType::String,
            'volume'   => AttributeType::String,
            'previous' => AttributeType::String,
        );
    }
}