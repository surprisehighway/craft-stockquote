<?php
/**
 * Stock Quote plugin for Craft CMS
 *
 * Simple real-time stock quotes from Yahoo Finance.
 *
 * @author    Mike Kroll
 * @copyright Copyright (c) 2017 Surprise Highway
 * @link      http://surprisehighway.com
 * @package   StockQuote
 * @since     1.0.0
 */

namespace Craft;

class StockQuotePlugin extends BasePlugin
{
    public function init()
    {
        parent::init();
    }

    public function getName()
    {
         return Craft::t('Stock Quote');
    }

    public function getDescription()
    {
        return Craft::t('Stock quotes from Yahoo');
    }

    public function getDocumentationUrl()
    {
        return 'https://github.com/surprisehighway/craft-stockquote/blob/master/README.md';
    }

    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/surprisehighway/craft-stockquote/master/releases.json';
    }

    public function getVersion()
    {
        return '1.0.0';
    }

    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    public function getDeveloper()
    {
        return 'Surprise Highway';
    }

    public function getDeveloperUrl()
    {
        return 'http://surprisehighway.com';
    }

    public function hasCpSection()
    {
        return false;
    }
}