<?php
define("ROUTESPATH", "../config/routes.php");

class Router {
    
    private $routes;

    public function __construct() {
        $this->routes = include(ROUTESPATH);
    }

    /**
     * Returns request string
     * @return string
     */
    private function getURI() {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run() {
        $extensions = array("jpg", "jpeg", "gif", "css", "html");

        $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if (in_array($ext, $extensions)) {
            // let the server handle the request as-is
            return false;  
        }
        #1 get url
        $uri = $this->getURI();
        #2 Check this url in routes.php
        foreach ($this->routes as $uriPattern => $path) {
            # Compare uriPattern (route pattern) with uri
            #3 If there are match : define controller and action for this request
            if (preg_match("~$uriPattern~", $uri)) {

                $iternalRoute = preg_replace("~$uriPattern~", $path, $uri);
                # get controler and action names
                $segments = explode('/', $iternalRoute);

                $controllerName = ucfirst(array_shift($segments)).'Controller';

                $actionName = 'action'.ucfirst(array_shift($segments));

                $parameters = $segments;

                //echo $controllerName . "\n";
                //echo $actionName . "\n";


                $controllerFileName = "../src/Controller/" . $controllerName . ".php";

                //echo $controllerFileName . "\n";

                #4 include classContoler file
                if (file_exists($controllerFileName)) {
                    include_once($controllerFileName);
                }

                #5 Create object and call method (action)
                $controllerObject = new $controllerName;
                //$result = $controllerObject->$actionName();
                $result = call_user_func_array([$controllerObject, $actionName], $parameters);
                
                if ($result != null) {
                    //echo "param: " . var_dump($parameters) . "\n";
                    break;
                }
            }
        }
    }
}