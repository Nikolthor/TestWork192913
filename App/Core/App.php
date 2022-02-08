<?
namespace App\Core;

use Throwable;

class App{
    protected $appRoot;
    protected $configs = [];
    protected $request;
    protected $session;

    protected function initConnections(){
        $connections = $this->getConfig('main')->get('connections');

        foreach ($connections as $connection) {
            Database::createConnection($connection['name'], $connection);
        }
    }

    protected function initConfigs(){
        $this->configs['main'] = new Config($this->appRoot.'/config.json');
    }

    protected function collectRequest(){
        
        $this->request = new Request($_REQUEST, $_SERVER);
    }

    protected function initSession(){
        session_start();
        $this->session = new Session($_SESSION);
    }

    public function getConfig($name): Config{
        if(isset($this->configs[$name])){
            return $this->configs[$name];
        } else {
            throw new \Exception('Config not found: '.$name);
        }
    }

    function __construct($appRoot){
        $this->appRoot = $appRoot;

        try{
            $this->initConfigs();
            $debugMode = $this->getConfig('main')->get('debug');
        } catch (Throwable $error){
            (new ResponseError(500, 'Unable to load configuration'))->send();
        }
        
        
        try{
            $this->getConfig('main')->set('appRoot', $appRoot);
            $this->initConnections();
            $this->collectRequest();
            $this->initSession();
        } catch (Throwable $error){
            if($debugMode){
                echo $error->getMessage() . "\n" . $error->getTrace();
            } else {
                (new ResponseError(500, 'Error: Something went wrong'))->send();
            }
        }
    }

    protected function appCallControllerAction($controllerClass, $action){
        if(class_exists($controllerClass)){
            if(method_exists($controllerClass, $action)){
                $controller = new $controllerClass();
                $response = $controller->$action($this->getConfig('main'), $this->request, $this->session);
                $response->send();
            } else {
                throw new \Exception('Controller action not found: ' . $action);
            }
        } else {
            throw new \Exception('Controller not found: '.$controllerClass);
        }
    }
    public function callControllerAction($controllerClass, $action){
        $debugMode = $this->getConfig('main')->get('debug');
        
        try{
            $this->appCallControllerAction($controllerClass, $action);
        } catch (Throwable $error){
            if($debugMode){
                echo $error->getMessage() . "\n" . $error->getTraceAsString();
            } else {
                (new ResponseError(500, 'Error: Something went wrong'))->send();
            }
        }
    }

    public function terminate(){
    }
}