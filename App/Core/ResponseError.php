<?

namespace App\Core;

use App\Core\Interfaces\Response;

class ResponseError implements Response{
    protected $errorCode;
    protected $text;
    function __construct($code, $text){
        $this->errorCode = $code;
        $this->text = $text;
    }

    public function send(){
        switch ($this->errorCode) {
            case '404':
                header("HTTP/1.1 404 Not Found", true, 404);
                echo $this->text;
            break;
            
            default:
                header('500 Internal Server Error', true, 500);
                echo $this->text;
            break;
        }
    }
}