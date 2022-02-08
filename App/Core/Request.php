<?
namespace App\Core;

class Request{

    protected $request;
    protected $server;
    function __construct($request, $server){
        $this->request = $request;
        $this->server = $server;
    }

    public function get($name){
        if(isset($_REQUEST[$name])){
            return $_REQUEST[$name];
        } else {
            return null;
        }
    }

    public function getUserAgent(){
        return $this->server['HTTP_USER_AGENT'];
    }

    public function getIp(){
        if (!empty($this->server['HTTP_CLIENT_IP'])) {
            $ip = $this->server['HTTP_CLIENT_IP'];
        } elseif (!empty($this->server['HTTP_X_FORWARDED_FOR'])) {
            $ip = $this->server['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $this->server['REMOTE_ADDR'];
        }

        return $ip;
    }
}