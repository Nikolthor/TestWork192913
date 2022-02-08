<?

namespace App\Controllers;

use App\Core\Config;
use App\Core\Interfaces\Response;
use App\Core\Request;
use App\Core\ResponseError;
use App\Core\ResponseImage;
use App\Models\UserAgent;
use App\Models\UserTrack;

class Banner{
    function show(Config $appConfig, Request $request): Response{
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

        if($userAgentId = $userAgent->updateUserAgent($userAgentString)){
            $userTrack->updateUserTrack($ip, $userAgentId, $origin);
        }
        
        return new ResponseImage($imagePath);
    }
}