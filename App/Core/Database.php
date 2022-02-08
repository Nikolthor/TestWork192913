<?

namespace App\Core;

use App\Core\Interfaces\Connection;

class Database{
    protected static $connections = [];


    protected static function createPdoConnection($name, $params){
        $dsn = 'mysql:host='.$params['dbhost'].';dbname='.$params['dbname'].';charset='.$params['charset'];
        $options = [
            PdoConnection::ATTR_ERRMODE            => PdoConnection::ERRMODE_EXCEPTION,
            PdoConnection::ATTR_DEFAULT_FETCH_MODE => PdoConnection::FETCH_ASSOC,
            PdoConnection::ATTR_EMULATE_PREPARES   => false,
        ];
        static::$connections[$name] = new PdoConnection($dsn, $params['dbuser'], $params['dbpassword'], $options);
    }

    public static function createConnection($name, $params = [
        'driver' => 'pdo',
        'dbname' => '',
        'dbhost' => '',
        'dbuser' => '',
        'dbpassword' => '',
        'charset' => ''
    ]){
        $driver = ucfirst(strtolower($params['driver']));
        $initMethod = 'create'.$driver.'Connection';
        if(method_exists(static::class, $initMethod)){
            static::$initMethod($name, $params);
        }
    }

    public static function getConnection($name): Connection{
        if(isset(static::$connections[$name]) && static::$connections[$name]){
            return static::$connections[$name];
        }
    }

}