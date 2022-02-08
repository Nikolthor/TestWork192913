<?

namespace App\Core\Interfaces;

interface Connection{
    public function createQuery($string, $params = []): Query;
}