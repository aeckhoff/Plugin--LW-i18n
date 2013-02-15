<?php
/**
 * The queryHandler get informations from the database.
 * 
 * @author Michael Mandt <michael.mandt@logic-works.de>
 * @package lw_i18n
 */
namespace LwI18n\Model;

class queryHandler 
{
    private $db;
    
    /**
     * An instance of lw_db is required.
     * @param object $db
     */
    public function __construct($db) 
    {
        $this->db = $db;
    }
    
    /**
     * All entries which are saved for a speific plugin and language will be returned.
     * @param string $category
     * @param string $lang
     * @return array
     */
    public function getAllEntriesForCategoryAndLang($category, $lang)
    {
        $this->db->setStatement("SELECT * FROM t:lw_i18n WHERE category = :category AND language = :language ORDER BY lw_key ");
        $this->db->bindParameter("category", "s", $category);
        $this->db->bindParameter("language", "s", $lang);
        
        return $this->db->pselect();
    }
    
    /**
     * An entry for a specific plugin and language and key will be returned.
     * @param string $category
     * @param string $lang
     * @param string $key
     * @return array
     */
    public function getEntryByCategoryAndLangAndKey($category, $lang, $key)
    {
        $this->db->setStatement("SELECT * FROM t:lw_i18n WHERE category = :category AND language = :language AND lw_key = :key ");
        $this->db->bindParameter("category", "s", $category);
        $this->db->bindParameter("language", "s", $lang);
        $this->db->bindParameter("key", "s", $key);
        
        return $this->db->pselect1();
    }
}