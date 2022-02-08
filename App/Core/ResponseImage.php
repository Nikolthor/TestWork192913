<?

namespace App\Core;

use App\Core\Interfaces\Response;

class ResponseImage implements Response{
    protected $imagePath;
    function __construct($imagePath){
        if(is_file($imagePath)){
            $this->imagePath = $imagePath;
        } else {
            throw new \Exception('Unable to find image: '.$imagePath);
        }
    }
    public function send(){
        $fileType = mime_content_type($this->imagePath);
        
        header('Content-Type:'.$fileType);
        header('Content-Length: ' . filesize($this->imagePath));
        echo file_get_contents($this->imagePath);
    }
}