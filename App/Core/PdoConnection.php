<?

namespace App\Core;

use App\Core\Interfaces\Connection;
use App\Core\Interfaces\Query;
use PDO;

class PdoConnection extends PDO implements Connection{
    public function createQuery($string, $params = []): Query{

        $query = new PdoQuery($this, $string, $params);

        return $query;
    }
}