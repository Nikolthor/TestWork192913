<?
namespace App\Core;

class Request{

    protected $request;
    protected $server;
    protected $session;
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
        if(isset($this->server['HTTP_USER_AGENT']) && !empty($this->server['HTTP_USER_AGENT'])){
            return $this->server['HTTP_USER_AGENT'];
        } else {
            return "No agent";
        }
        
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