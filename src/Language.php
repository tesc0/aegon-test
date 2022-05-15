<?php

namespace Language;

use Language\Api;

class Language
{
    public static function getFile($application, $language)
    {
        $result = false;

		try {
            $target = 'system_api';
            $mode = 'language_api';
            $getParameters = [
                'system' => 'LanguageFiles',
                'action' => 'getLanguageFile'
            ];
            $postParameters = ['language' => $language];

			$api = new Api();
            $api->execute($target, $mode, $getParameters, $postParameters);
		}
		catch (\Exception $e) {
			throw new \Exception('Error during getting language file: (' . $application . '/' . $language . ')');
		}

		// If we got correct data we store it.
		$destination = self::getLanguageCachePath($application) . $language . '.php';
		// If there is no folder yet, we'll create it.
		var_dump($destination);
		if (!is_dir(dirname($destination))) {
			mkdir(dirname($destination), 0755, true);
		}

		$result = file_put_contents($destination, $languageResponse['data']);

		return (bool)$result;
    }
}