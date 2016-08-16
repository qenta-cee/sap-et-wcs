<?php

namespace WireCardSeamlessBundle\Resources\Languages;


/**
 * The LanguageManager class is used to provide multilingual parameter names in conjunction with the de/en/.. language files.
 * @author clic
 *
 */
class LanguageManager {
	
	/**
	 * Contains the data from the language files.
	 * @var array( "language" => array( "languageKey" => "value" ) )
	 */
	private static $languageEntries;
	
	
	/**
	 * Returns the language entry corresponding to the given <i>$languageKey</i>.
	 * @param String $languageKey
	 * @return string language entry
	 */
	public static function getLanguageEntry($language, $languageKey){

		if(!isset(self::$languageEntries[$language])){
			$languageData = array();
			
			$path = dirname(__FILE__) . '/'.$language.'.inc.php';
			if (realpath($path)) {
				include($path);
			}
		  	else{
		  		include(dirname(__FILE__) . '/en.inc.php');
		  	}
			
		  	self::$languageEntries[$language] = $languageData;
		}
		
		return utf8_decode (self::$languageEntries[$language][$languageKey]);
		
	}	
	
	
}