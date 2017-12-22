<?php
/**
 * Stock Quote plugin for Craft CMS
 *
 * Simple stock quotes from the Alpha Vantage api.
 *
 * @author    Mike Kroll
 * @copyright Copyright (c) 2017 Surprise Highway
 * @link      http://surprisehighway.com
 * @package   StockQuote
 * @since     1.1.0
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
        return Craft::t('Stock quotes from the Alpha Vantage api');
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
        return '1.1.0';
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

    public function getSettingsHtml()
    {
       return craft()->templates->render('stockquote/settings', array(
           'settings' => $this->getSettings()
       ));
    }

    protected function defineSettings()
    {
        return array(
            'apiKey' => array( AttributeType::String, 'label' => 'API Key', 'default' => '', 'required' => true)
        );
    }


}