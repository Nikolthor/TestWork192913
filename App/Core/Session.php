<?

namespace App\Core;


class Session{
    protected $session;
    function __construct(&$session){
        $this->session = &$session;
    }

    public function get($name){
        if(isset($this->session[$name])){
            return $this->session[$name];
        } else {
            return null;
        }
    }

    public function set($name, $value){
        $this->session[$name] = $value;
    }

}