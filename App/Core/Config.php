<?

namespace App\Core;

class Config{
    protected $configArray = [];
    function __construct($path){
        if(is_file($path)){
            $configData = file_get_contents($path);
            $configArray = json_decode($configData, true);
            if($configArray !== false){
                $this->configArray = $configArray;
            }
        } else {
            throw new \Exception('Config file not found: '.$path);
        }
    }

    public function get($path){
        $preparedPath = trim($path, "\t\n\r\0\x0B\/");
        $parts = explode('/', $preparedPath);
        $current = $this->configArray;

        foreach ($parts as $part) {
            if(isset($current[$part])){
                $current = $current[$part];
            } else {
                return null;
            }
        }

        return $current;
    }

    public function set($key, $value){
        $this->configArray[$key] = $value;
    }

}