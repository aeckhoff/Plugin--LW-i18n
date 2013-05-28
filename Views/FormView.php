<?php
namespace LwI18n\Views;

class FormView 
{
    private $view;
    
    public function __construct() 
    {
        $this->view = new \lw_view(dirname(__FILE__).'/Templates/Form.tpl.phtml');
    }
    
    public function render($data, $lang)
    {
        $this->view->data = $data;
        $this->view->lang = $lang;
        
        return $this->view->render();
    }
}