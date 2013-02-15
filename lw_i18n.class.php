<?php
/**
 * This class isn't needed for the functionality of this plugin, because
 * other plugins which wants to use thw lw_i18n plugin instance the 
 * I18nController. This class is for testing to generate an frontend output.
 * 
 * @author Michael Mandt <michael.mandt@logic-works.de>
 * @package lw_i18n
 */

class lw_i18n extends lw_plugin
{
    protected $db;
    
    
    public function __construct() 
    {
        parent::__construct();
        include_once(dirname(__FILE__).'/Services/Autoloader.php');
        $autoloader = new \LwI18n\Services\Autoloader();
    }
    
    public function buildPageOutput()
    {
        $response = \LwI18n\Services\Response::getInstance();
        $controller = new \LwI18n\Controller\I18nController($this->db, $response);
        $controller->execute("lw_i18n","de");
        
        return $response->getOutputByKey("i18n");
    }
    
    function deleteEntry()
    {
        return true;
    }
}