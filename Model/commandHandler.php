<?php
/**
 * The commandHandler save changes which were done to the language texts and
 * add new entries.
 * 
 * @author Michael Mandt <michael.mandt@logic-works.de>
 * @package lw_i18n
 */
namespace LwI18n\Model;

class commandHandler
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
     * Creates the lw_i18n table.
     * @return bool
     */
    public function createTable()
    {
        $this->db->setStatement("CREATE TABLE IF NOT EXISTS lw_i18n (
                                      id int(11) NOT NULL,
                                      category varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                                      language varchar(2) COLLATE utf8_unicode_ci NOT NULL,
                                      lw_key varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                                      text varchar(255) COLLATE utf8_unicode_ci NOT NULL
                                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
        
        return $this->db->pdbquery();
    }
    
    /**
     * Add a new entry with specific informations.
     * @param string $category (pluginname)
     * @param string $lang
     * @param string $key
     * @param string $text
     * @return bool
     */
    public function add($category, $lang, $key, $text)
    {
        #die(htmlentities($text."  > << <>>"));
        $this->db->setStatement("INSERT INTO t:lw_i18n (category, language, lw_key, text) VALUES (:category, :language, :key, :text) ");
        $this->db->bindParameter("category", "s", $category);
        $this->db->bindParameter("language", "s", $lang);
        $this->db->bindParameter("key", "s", $key);
        $this->db->bindParameter("text", "s", $text);
        
        return $this->db->pdbquery();
    }
    
    /**
     * The "output" text of an specific entry will be updated.
     * @param string $category (pluginname)
     * @param string $lang
     * @param string $key
     * @param string $text
     * @return bool
     */
    public function save($category, $lang, $key, $text)
    {
        $this->db->setStatement("UPDATE t:lw_i18n SET text = :text WHERE category = :category AND language = :language AND lw_key = :key ");
        $this->db->bindParameter("category", "s", $category);
        $this->db->bindParameter("language", "s", $lang);
        $this->db->bindParameter("key", "s", $key);
        $this->db->bindParameter("text", "s", htmlentities($text));
        
        return $this->db->pdbquery();
    }    
}