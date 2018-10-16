<?php



namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

class APIController extends Controller {
    
    public function getSourceFacebook(){
        $config = DB::table('config')->get();
        
        $tap = DB::table('tap')->where('tap_id', $tapid)->get();
        
        $graphAPI   = 'https://graph.facebook.com/v3.1/';
    
        $token = '&access_token=' . $config[0]->config_token_fb;

        $fields = '?fields=source';

        $videoID = '1077987079031052';

        $result = file_get_contents($graphAPI . $videoID . $fields . $token);

        $result_json = json_decode($result);

        $source = $result_json->source;

        return $source;
    }
    
}
