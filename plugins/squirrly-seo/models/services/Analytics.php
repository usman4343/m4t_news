<?php

class SQ_Models_Services_Analytics extends SQ_Models_Abstract_Seo {


    public function __construct() {
        parent::__construct();
        if ($this->_post->sq->doseo) {
            if (!SQ_Classes_Tools::getOption('sq_auto_amp')) {
                add_filter('sq_google_analytics', array($this, 'generateGoogleAnalytics'));
                add_filter('sq_google_analytics', array($this, 'packGoogleAnalytics'), 99);
            } else {
                add_filter('sq_google_analytics', array($this, 'generateGoogleAnalyticsAMP'));
                add_filter('sq_google_analytics_amp', array($this, 'packGoogleAnalyticsAMP'));
            }
        } else {
            add_filter('sq_google_analytics', array($this, 'returnFalse'));
            add_filter('sq_google_analytics_footer', array($this, 'returnFalse'));
        }
    }

    public function generateGoogleAnalytics($track = '') {
        $codes = json_decode(json_encode(SQ_Classes_Tools::getOption('codes')));

        if (isset($codes->google_analytics) && $codes->google_analytics <> '') {
            $track = $codes->google_analytics;
        }

        return $track;
    }

    public function packGoogleAnalytics($track = '') {
        if ($track <> '') {
            return sprintf("<script async src='https://www.google-analytics.com/analytics.js'></script><script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga'); ga('create', '%s', 'auto');ga('send', 'pageview');</script>", $track);
        }

        return false;
    }

    /*************************** FOR AMP VERSION**********************************/

    public function generateGoogleAnalyticsAMP() {
        $codes = json_decode(json_encode(SQ_Classes_Tools::getOption('codes')));

        if (isset($codes->google_analytics) && $codes->google_analytics <> '') {
            return '<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>';
        }

        return false;
    }

    /**
     * Return the AMP Analytics
     * @return string
     */
    public function packGoogleAnalyticsAMP() {
        $codes = json_decode(json_encode(SQ_Classes_Tools::getOption('codes')));

        if (isset($codes->google_analytics) && $codes->google_analytics <> '') {
            return sprintf('<amp-analytics type="googleanalytics"><script type="application/json">{"vars": {"account": "%s"},"triggers": {"trackPageview": {"on": "visible","request": "pageview"}}}</script></amp-analytics>', $codes->google_analytics);
        }

    }
}