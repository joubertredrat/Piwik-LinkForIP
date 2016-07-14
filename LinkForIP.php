<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * LinkForIP Main class, responsible for add url on IP
 *
 * @copyright (c) 2016 Joubert RedRat
 * @author Joubert RedRat <eu+github@redrat.com.br>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @category Piwik_Plugins
 * @package LinkForIP
 */

namespace Piwik\Plugins\LinkForIP;

class LinkForIP extends \Piwik\Plugin
{
    /**
     * Url base for build
     *
     * @var string
     */
    private static $urlbase;

    /**
     * Register event observers
     *
     * @return array
     */
    public function registerEvents()
    {
        return [
            'Live.getAllVisitorDetails' => 'addUrlIp'
        ];
    }

    /**
     * Add url link on IP
     *
     * @param array $visitor
     * @param array $details
     * @return void
     */
    public function addUrlIp(&$visitor, $details)
    {
        $this->loadSettings();

        if (self::$urlbase) {
            $url = str_replace('{ip}', $visitor['visitIp'], self::$urlbase);
            $visitor['visitIp'] = '<a href="'.$url.'" target="_blank">'.$visitor['visitIp'].'</a>';
            file_put_contents('eu.log', time().PHP_EOL, FILE_APPEND);
        }
    }

    /**
     * Load setting only one time.
     *
     * @return void
     */
    private function loadSettings()
    {
        if (!self::$urlbase) {
            $Settings = new Settings('LinkForIP');
            self::$urlbase = $Settings->urlSetting->getValue();
        }
    }
}
