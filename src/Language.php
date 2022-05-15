<?php

namespace Language;

use Language\Api;

class Language
{
    private $application;
    private $language;

    public function __construct($application, $language) {
        $this->application = $application;
        $this->language = $language;
    }

    public function getFile()
    {
        $result = false;

		try {
            $target = 'system_api';
            $mode = 'language_api';
            $getParameters = [
                'system' => 'LanguageFiles',
                'action' => 'getLanguageFile'
            ];
            $postParameters = ['language' => $this->language];

			$api = new Api();
            $api->execute($target, $mode, $getParameters, $postParameters);
		}
		catch (\Exception $e) {
			throw new \Exception('Error during getting language file: (' . $this->application . '/' . $this->language . ')');
		}

		// If we got correct data we store it.
		$destination = $this->getCachePath() . $this->language . '.php';
		// If there is no folder yet, we'll create it.
		var_dump($destination);
		if (!is_dir(dirname($destination))) {
			mkdir(dirname($destination), 0755, true);
		}

		$result = file_put_contents($destination, $api->getResponse()['data']);

		return (bool)$result;
    }

    public function getCachePath()
    {
        return Config::get('system.paths.root') . '/cache/' . $this->application. '/';
    }
}