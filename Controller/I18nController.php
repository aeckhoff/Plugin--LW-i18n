<?php
/**
 * The LwI18n plugin is created to save different language packeges for
 * plugins and allowes customisations of the texts.
 * This controller returns only a prepared set a prepared formular for the
 * plugin backend. To Save the changes is it necessary to add the save
 * function in the specific plugin. E.g. into the backend_save function.
 * 
 * @author Michael Mandt <michael.mandt@logic-works.de>
 * @package lw_i18n
 */
namespace LwI18n\Controller;

class I18nController extends \lw_object
{
    protected $db;
    private $commandHandler;
    private $queryHandler;
    private $view;
    private $response;
    private $request;

    /**
     * The constructor also need an instance of the lw_registry and getEntry("request").
     * @param object $db
     * @param object $response
     */
    public function __construct($db, $response) 
    {
        $this->db = $db;
        $this->commandHandler = new \LwI18n\Model\commandHandler($db);
        $this->queryHandler = new \LwI18n\Model\queryHandler($db);
        $this->view = new \LwI18n\Views\FormView();
        $this->response = $response;
        
        $reg = \lw_registry::getInstance();
        $this->request = $reg->getEntry("request");
    }
    
    /**
     * The consitence of the keys will be validated and missing entries added.
     * The language formular will be set with the specific saved informations for
     * the param pluginame and lang.
     * @param string $pluginname
     * @param string $lang
     * @param array $dataByPlugin
     */
    public function execute($pluginname,$lang, $dataByPlugin)
    {
        $this->checkConsistentsAndAddMissingEntries($dataByPlugin);
        
        if(is_array($pluginname)) {
            foreach($pluginname as $plugin) {
                $data[$plugin] = $this->queryHandler->getAllEntriesForCategoryAndLang($plugin, $lang);
            }
            $this->response->setOutputByKey("i18n_".$lang, $this->view->render($data,$lang));
        } else {
            $data[$pluginname] = $this->queryHandler->getAllEntriesForCategoryAndLang($pluginname, $lang);
            $this->response->setOutputByKey("i18n_".$lang, $this->view->render($data,$lang));
        }
    }
    
    /**
     * Missing entries will be added.
     * @param array $dataByPlugin
     * @return boolean
     */
    public function checkConsistentsAndAddMissingEntries($dataByPlugin)
    {
        $qH = new \LwI18n\Model\queryHandler($this->db);
        $cH = new \LwI18n\Model\commandHandler($this->db);
        $this->db->tableExists("lw_i18n");
            
        foreach($dataByPlugin as $lang => $pluginData) {
            foreach($pluginData as $pluginname => $keyText) {
                foreach($keyText as $key => $text) {
                    $result = $qH->getEntryByCategoryAndLangAndKey($pluginname, $lang, $key);
                    
                    if(empty($result)) {
                        $cH->add($pluginname, $lang, $key, $text);
                    }
                }
            }
        }
        
        return true;
    }
            
}