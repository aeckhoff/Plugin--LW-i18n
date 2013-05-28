<?php
namespace LwI18n\Services;
/* * ************************************************************************
 *  Copyright notice
 *
 *  Copyright 2013 Logic Works GmbH
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *  http://www.apache.org/licenses/LICENSE-2.0
 *  
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *  
 * ************************************************************************* */

class Autoloader
{
    public function __construct()
    {
        spl_autoload_register(array($this, 'loader'));
    }
    
    private function loader($className) 
    {
        $path = dirname(__FILE__).'/..';
        $filename = str_replace('LwI18n', $path, $className);
        
        $filename = str_replace('\\', '/', $filename).'.php';
        if (is_file($filename)) {
            //echo $filename." exists<br>";
            include_once($filename);
        }
    }
}