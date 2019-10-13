<?php

namespace Language\Language;

use Language\Adapters\ConfigAdapter;
use Language\Adapters\NetworkAdapter;

class NormalLanguage implements Language {

    private $networkAdapter;
    private $config;

    public function __construct(ConfigAdapter $config)
    {
        $this->networkAdapter = new NetworkAdapter();
        $this->config = $config;
    }

    public function getFile($id, $language)
    {
        $languageResponse = $this->networkAdapter->makeRequest(
            'system_api',
            'language_api',
            array(
                'system' => 'LanguageFiles',
                'action' => 'getLanguageFile'
            ),
            array('language' => $language)
        );

        try {
            $this->networkAdapter->checkForApiErrorResult($languageResponse);
        }
        catch (\Exception $e) {
            throw new \Exception('Error during getting language file: (' . $id . '/' . $language . ')');
        }

        // If we got correct data we store it.
        $destination = $this->config->get('system.paths.root') . '/cache/' . $id. '/' . $language . '.php';

        if (!is_dir(dirname($destination))) {
            mkdir(dirname($destination), 0755, true);
        }

        $result = file_put_contents($destination, $languageResponse['data']);

        return (bool)$result;
    }

    public function get($id)
    {
        //
    }
}
