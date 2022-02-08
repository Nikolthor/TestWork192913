<?
namespace App\Core;

use App\Core\Database;
use App\Core\Interfaces\Connection;


class DefaultModel{
    /**
     * @var Connection $connection
     */
    protected $connection;

    public function __construct(){
        $this->connection = Database::getConnection('default');
    }

}