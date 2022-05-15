<?php

namespace Language;

class Applet
{
    private $applet;

    public function __construct($applet)
    {
        $this->applet = $applet;
    }

    public function getLanguages()
    {
        try {
            $target = 'system_api';
            $mode = 'language_api';
            $getParameters = [
                'system' => 'LanguageFiles',
                'action' => 'getAppletLanguages'
            ];
            $postParameters = ['applet' => $this->applet];

			$api = new Api();
            $api->execute($target, $mode, $getParameters, $postParameters);
		}
		catch (\Exception $e) {
			throw new \Exception('Getting languages for applet (' . $this->applet . ') was unsuccessful ' . $e->getMessage());
		}

		return $api->getResponse()['data'];
    }

    public function getLanguageFile($language, $path)
    {
        $xmlContent = $this->getLanguageXml($language);

        $xmlFile    = $path . '/lang_' . $language . '.xml';
        if (strlen($xmlContent) == file_put_contents($xmlFile, $xmlContent)) {
            echo " OK saving $xmlFile was successful.\n";
        } else {
            throw new \Exception('Unable to save applet: (' . $this->applet . ') language: (' . $language . ') xml (' . $xmlFile . ')!');
        }
        
    }

    private function getLanguageXml($language)
    {
        try {
            $target = 'system_api';
            $mode = 'language_api';
            $getParameters = [
                'system' => 'LanguageFiles',
                'action' => 'getAppletLanguageFile'
            ];
            $postParameters = [
                'applet' => $this->applet,
                'language' => $language
        ];

			$api = new Api();
            $api->execute($target, $mode, $getParameters, $postParameters);
		}
		catch (\Exception $e) {
			throw new \Exception('Getting languages for applet (' . $this->applet . ') was unsuccessful ' . $e->getMessage());
		}

		return $api->getResponse()['data'];
    }
}