<?

namespace App\Core;

use App\Core\Interfaces\Query;
use PDOStatement;

class PdoQuery implements Query{
    protected $queryString;
    protected $queryParams;
    /**
     * @var PdoConnection $connection
     */
    protected $connection;

    function __construct(PdoConnection $connection, $queryString, $queryParams = []){
        $this->queryString = $queryString;
        $this->queryParams = $queryParams;
        $this->connection = $connection;
    }

    protected function prepareAndExecuteQuery(): PDOStatement{
        $statement = $this->connection->prepare($this->queryString);
        $statement->execute($this->queryParams);

        return $statement;
    }

    public function fetchAll(){
        return $this->prepareAndExecuteQuery()->fetchAll();
    }

    public function rowsCount(){
        return $this->prepareAndExecuteQuery()->rowCount();
    }

    public function fetch(){
        return $this->prepareAndExecuteQuery()->fetch();
    }

    public function insert($name = 'id'){
        $this->prepareAndExecuteQuery();
        return $this->connection->lastInsertId($name);
    }
}