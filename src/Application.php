<?php

namespace Language;

class Application
{
    private $application;
    private $languages;

    public function __construct($application, $languages)
    {
        echo "[APPLICATION: " . $application . "]\n";

        $this->application = $application;
        $this->languages = $languages;

        $this->getLanguageFiles();
    }

    private function getLanguageFiles()
    {
        foreach ($this->languages as $language) {

            echo "[LANGUAGE: " . $language . "]\n";

            $languageClass = new Language($this->application, $language);
            $result = $languageClass->getFile();
            if ($result) {
                echo " OK\n";
            }
            else {
                throw new \Exception('Unable to generate language file!');
            }            
        }
    }
}