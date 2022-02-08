<?
namespace App\Models;

use App\Core\DefaultModel;
use DateTime;

class UserTrack extends DefaultModel{

    public static function prepareIp($ip){
        return ip2long($ip);
    }

    public function checkTrackExists($ip, $userAgentId, $origin){
        $query = $this->connection->createQuery('
            SELECT ut.id FROM user_tracks AS ut
            INNER JOIN user_agents AS ua
            ON ut.user_agent=ua.id
            WHERE
                ua.id=?
            AND
                ut.page_url=?
            AND 
                ut.ip_address=?
        ',[
            $userAgentId,
            $origin,
            static::prepareIp($ip)
        ]);
        $res = $query->fetch();

        if(isset($res['id'])){
            return $res['id'];
        } else {
            return false;
        }
    }

    public function updateUserTrack($ip, $userAgentId, $origin){
        $existedTrackId = $this->checkTrackExists($ip, $userAgentId, $origin);
        if(!$existedTrackId){
            $query = $this->connection->createQuery('
                INSERT INTO user_tracks
                    (ip_address, user_agent, page_url)
                VALUES
                    (?,?,?)
            ',[
                static::prepareIp($ip),
                $userAgentId,
                $origin,
            ]);
            return $query->insert();
        } else {
            $this->connection->createQuery('
                UPDATE user_tracks SET 
                    views_count=views_count+1,
                    view_date=?
                WHERE
                    id=?
            ', [
                (new DateTime())->format('Y-m-d H:i:s'),
                $existedTrackId
            ])->rowsCount();
            
            return $existedTrackId;
        }
    }
}