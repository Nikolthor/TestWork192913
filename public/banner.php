<?
require_once(__DIR__.'/../autoload.php');

use App\Controllers\Banner;

$app = new App\Core\App(realpath(__DIR__.'/..'));

$app->callControllerAction(Banner::class, 'show');

$app->terminate();