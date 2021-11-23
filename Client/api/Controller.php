<?
    class Controller{
        
        /**
         * @param $file string view file to require
         */
        static function view($file){
            $view_catalog = $_SERVER["DOCUMENT_ROOT"]."/public/php/view";
            if(file_exists($view_catalog.$file))
            require $view_catalog.$file;
        }
    }