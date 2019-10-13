<?php

namespace Language\Language;

use Language\Adapters\ConfigAdapter;
use Language\Adapters\NetworkAdapter;

class AppletLanguage implements Language {

    private $networkAdapter;
    private $config;

    public function __construct(ConfigAdapter $config)
    {
        $this->networkAdapter = new NetworkAdapter();
        $this->config = $config;
    }

    public function get($id)
    {
        $result = $this->networkAdapter->makeRequest(
            'system_api',
            'language_api',
            array(
                'system' => 'LanguageFiles',
                'action' => 'getAppletLanguages'
            ),
            array('applet' => $id)
        );

        try {
            $this->networkAdapter->checkForApiErrorResult($result);
        }
        catch (\Exception $e) {
            throw new \Exception('Getting languages for applet (' . $id . ') was unsuccessful ' . $e->getMessage());
        }

        return $result['data'];
    }

    public function getFile($id, $language)
    {
        $result = $this->networkAdapter->makeRequest(
            'system_api',
            'language_api',
            array(
                'system' => 'LanguageFiles',
                'action' => 'getAppletLanguageFile'
            ),
            array(
                'applet' => $id,
                'language' => $language
            )
        );

        try {
            $this->networkAdapter->checkForApiErrorResult($result);
        }
        catch (\Exception $e) {
            throw new \Exception('Getting language xml for applet: (' . $id . ') on language: (' . $language . ') was unsuccessful: '
                . $e->getMessage());
        }

        return $result['data'];
    }
}
