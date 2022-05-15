<?php

namespace Language;

class AppletLanguages
{
    // List of the applets [directory => applet_id].
    private static $applets = [
        'memberapplet' => 'JSM2_MemberApplet'
    ];

    public static function generate()
    {
        echo "\nGetting applet language XMLs..\n";

		foreach (self::$applets as $appletDirectory => $applet) {

            $appletClass = new Applet($applet);
            echo " Getting > $applet ($appletDirectory) language xmls..\n";
            $languages = $appletClass->getLanguages();
            if (empty($languages)) {
				throw new \Exception('There are no available languages for the ' . $applet . ' applet.');
			} else {
				echo ' - Available languages: ' . implode(', ', $languages) . "\n";
			}

			$path = self::getCachePath();

			foreach ($languages as $language) {
                $appletClass->getLanguageFile($language, $path);
			}
			echo " < $applet ($appletDirectory) language xml cached.\n";
		}

		echo "\nApplet language XMLs generated.\n";
	
    }

    private static function getCachePath()
    {
        return Config::get('system.paths.root') . '/cache/flash';
    }
}