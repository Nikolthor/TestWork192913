<?

spl_autoload_register(function ($className) {
    $classPath = str_replace('\\', '/', $className);
    $classFile = __DIR__.'/'.$classPath.'.php';

    if(is_file($classFile)){
        require_once(__DIR__.'/'.$classPath.'.php');
    } else {
        throw new \Exception('Unable to autoload class: '.$className);
    }
    
});