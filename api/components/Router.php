<?php

namespace components;
class Router
{
    public function getURI(): string
    {
        if(!empty($_GET['q']))
        {
            return trim($_SERVER['REQUEST_URI'],'/');
        }
        return false;
    }
    public function run(): void
    {
        $uri = $this->getURI();
        if($uri)
        {
            $segments = explode('/', $uri);
            $fileName = array_shift($segments);
            $filerName = ucfirst($fileName);

            $actionName = 'action' . ucfirst(array_shift($segments));

            $filePath = ROOT . '/api/Objects/' . $filerName . '.php';

            if(file_exists($filePath))
            {
                include_once $filePath;
            }

            $Object = new $filerName;
            call_user_func_array(array($Object, $actionName), $segments);
        }
    }
}