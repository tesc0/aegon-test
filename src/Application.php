<?php

namespace Language;

class Application
{
    private $application;
    private $languages;

    public function __construct($application, $languages)
    {
        $this->application = $application;
        $this->languages = $languages;

        $this->getLanguageFiles();
    }

    private function getLanguageFiles()
    {
        foreach ($this->languages as $language) {
            if (Language::getFile($this->application, $language)) {
                echo " OK\n";
            }
            else {
                throw new \Exception('Unable to generate language file!');
            }            
        }
    }
}