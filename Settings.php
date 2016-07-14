<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * LinkForIP Settings
 *
 * @copyright (c) 2016 Joubert RedRat
 * @author Joubert RedRat <eu+github@redrat.com.br>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @category Piwik_Plugins
 * @package LinkForIP
 */

namespace Piwik\Plugins\LinkForIP;

use Piwik\Piwik;
use Piwik\Settings\SystemSetting;

class Settings extends \Piwik\Plugin\Settings
{
    /**
     * @see \Piwik\Plugin\Settings::init()
     */
    protected function init()
    {
        $this->setIntroduction(Piwik::translate('LinkForIP_SettingsDescription'));

        $this->createUrlSetting();
    }

    /**
     * Create url setting
     *
     * @return void
     */
    private function createUrlSetting()
    {
        $this->urlSetting = new SystemSetting('urlSetting', Piwik::translate('LinkForIP_UrlLabel'));
        $this->urlSetting->type = static::TYPE_STRING;
        $this->urlSetting->uiControlAttributes = ['size' => 80];
        $this->urlSetting->description = Piwik::translate('LinkForIP_UrlDescription');
        $this->urlSetting->inlineHelp = Piwik::translate('LinkForIP_UrlHelp');
        $this->urlSetting->validate = function ($value, $setting) {
            if ($value) {
                if (filter_var($value, FILTER_VALIDATE_URL) === false) {
                    throw new \Exception(Piwik::translate('LinkForIP_UrlErrUrlInvalid'));
                }

                if (strpos($value, '{ip}') === false) {
                    throw new \Exception(Piwik::translate('LinkForIP_UrlErrNoJoker'));
                }
            }
        };

        $this->addSetting($this->urlSetting);
    }
}
