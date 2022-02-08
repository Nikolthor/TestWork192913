<?

namespace App\Models;

use App\Core\DefaultModel;

class UserAgent extends DefaultModel{
    public static function userAgentHash($userAgent){
        return md5($userAgent);
    }

    public function createUserAgent($userAgent){
        return $this->connection->createQuery('
            INSERT INTO user_agents (useragent, hash)
            VALUES (?,?)
        ', [
            $userAgent,
            static::userAgentHash($userAgent)
        ])->insert();
    }
    public function updateUserAgent($userAgent){
        $userAgentExists = $this->connection->createQuery('SELECT id FROM user_agents WHERE hash=?',[
            static::userAgentHash($userAgent)
        ])->fetch();

        if(!$userAgentExists){
            $createdUserAgent = $this->createUserAgent($userAgent);
            return $createdUserAgent;
        } else {
            return $userAgentExists['id'];
        }
    }
}