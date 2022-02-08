<?

namespace App\Controllers;

use App\Core\Config;
use App\Core\Interfaces\Response;
use App\Core\Request;
use App\Core\ResponseError;
use App\Core\ResponseImage;
use App\Core\Session;
use App\Models\UserAgent;
use App\Models\UserTrack;

class Banner{
    function show(Config $appConfig, Request $request, Session $session): Response {
        $bannerId = $request->get('banner');
        $origin = $request->get('origin');
        $userAgentString = $request->getUserAgent();
        $ip = $request->getIp();

        $imagePath = $appConfig->get('appRoot').'/public/banners/'.$bannerId;

        if(!is_file($imagePath)){
            return new ResponseError(404, 'Banner not found');
        }


        $userTrack = new UserTrack();
        $userAgent = new UserAgent();


        $userAgentHash = UserAgent::userAgentHash($userAgentString);

        $userAgentCache = $session->get('userAgentCache');

        if(!isset($userAgentCache[$userAgentHash]) || empty($userAgentCache[$userAgentHash])){
            $userAgentId = $userAgent->updateUserAgent($userAgentString);
            $userAgentCache = [
                $userAgentHash => $userAgentId
            ];
            $session->set('userAgentCache', $userAgentCache);
        } else {
            $userAgentId = $userAgentCache[$userAgentHash];
        }

        $userTrack->updateUserTrack($ip, $userAgentId, $origin);
        
        return new ResponseImage($imagePath);
    }
}