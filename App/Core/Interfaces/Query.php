<?

namespace App\Core\Interfaces;

interface Query{
    public function fetchAll();
    public function rowsCount();
    public function fetch();
    public function insert();
}