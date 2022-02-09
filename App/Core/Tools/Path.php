<?
namespace App\Core\Tools;

class Path{
    public static function filterBackPath($path){
        return str_replace('..', '', $path);
    }
}