<?php

namespace App\Http\Controllers;
use App\Models\Automations;
use App\Models\automStatus;
use App\Models\Category;
use App\Models\package_users;
use App\Models\package;
use App\Models\Type;
use App\Models\order;
use Illuminate\Support\Facades\View;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Models\User;
use File;
use Illuminate\Support\Facades\Mail;
use Response;
use App\Document;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;
use Tinify\Source;
use Tinify\Tinify;

class AutomationController extends Controller
{

    public function getAllAutos (){
        $auto = Automations::with(['category','automationType'])->get();
        $success =  $auto;

        return response()->json($success, 200);
    }

    public function getActiveAutos(){
        $autos = Automations::with(['category','automationType'])->where('status','=','1')->get();

        return response()->json($autos, 200);
    }
    public function getAutoByCategoryId (Request $request){
        $autos = Automations::select('id','name','shortDescription','url','category_id','type_id')->with(['automationType'])->where('status','=','1')->where('category_id','=',$request->id)->get();
        return response()->json($autos);
    }
    public function listAllAutos (){
        $autos = Automations::with(['category','automationType'])->get();
        return view('automation.list')->with('autos', $autos);
    }

    public function editAuto (Request $request) {
        $autos = Automations::find($request->id);
        $categories = Category::all();
        $types = Type::all();
        $related = Automations::all();
        $inputType = ['text','file','url','username','password','email','textarea'];
        $inputs = ['Name','Username','Password','E-Mail','URL','Element','File'];
        return view('automation.form', compact('autos', 'categories', 'types','inputs','inputType','related'));
    }
    
    public function addAutoView (){
        $categories = Category::all();
        $types = Type::all();
        $related = Automations::all();
        $inputType = ['text','file','url','username','password','email','textarea'];
        $inputs = ['Name','Username','Password','E-Mail','URL','Element','File'];
        return view('automation.form', compact('categories', 'types','inputs','inputType','related'));
    }

    public function addAuto (Request $request){
        $auto = new Automations;

        $auto->category_id = $request->category;
        $auto->name = $request->name;
        $auto->h1 = $request->h1;
        $auto->text1 = $request->text1;
        $auto->h2 = $request->h2;
        $auto->text2 = $request->text2;
        $auto->h2 = $request->h2;
        $auto->text2 = $request->text2;
        $auto->h3 = $request->h3;
        $auto->text3 = $request->text3;
        $auto->tutorial = $request->tutorial;
        $auto->updates = $request->updates;
        $auto->type_id = $request->type;
        $auto->url = $request->url;
        $auto->metaDescription = $request->metaDescription;
        $auto->metaTitle = $request->metaTitle;
        $auto->status = $request->status;
        $auto->api = $request->api;
        $auto->slug = $request->slug;
        $auto->tabName = $request->tabName;
        $auto->tabText = $request->tabText;
        $auto->related = $request->related;
        $auto->shortDescription = $request->shortDescription;
        $auto->step1Header = $request->step1Header;
        $auto->step2Header = $request->step2Header;
        $auto->step3Header = $request->step3Header;
        $auto->step4Header = $request->step4Header;
        $auto->step1Text = $request->step1Text;
        $auto->step2Text = $request->step2Text;
        $auto->step3Text = $request->step3Text;
        $auto->step4Text = $request->step4Text;
        $auto->save();
        return redirect('admin/automation/list');
    }

    public function updateAuto (Request $request){
        $auto = Automations::find($request->id);

        $auto->category_id = $request->category;
        $auto->name = $request->name;
        $auto->h1 = $request->h1;
        $auto->text1 = $request->text1;
        $auto->h2 = $request->h2;
        $auto->text2 = $request->text2;
        $auto->h2 = $request->h2;
        $auto->text2 = $request->text2;
        $auto->h3 = $request->h3;
        $auto->text3 = $request->text3;
        $auto->tutorial = $request->tutorial;
        $auto->updates = $request->updates;
        $auto->type_id = $request->type;
        $auto->url = $request->url;
        $auto->metaDescription = $request->metaDescription;
        $auto->metaTitle = $request->metaTitle;
        $auto->status = $request->status;
        $auto->api = $request->api;
        $auto->slug = $request->slug;
        $auto->tabName = $request->tabName;
        $auto->tabText = $request->tabText;
        $auto->related = $request->related;
        $auto->shortDescription = $request->shortDescription;
        $auto->step1Header = $request->step1Header;
        $auto->step2Header = $request->step2Header;
        $auto->step3Header = $request->step3Header;
        $auto->step4Header = $request->step4Header;
        $auto->step1Text = $request->step1Text;
        $auto->step2Text = $request->step2Text;
        $auto->step3Text = $request->step3Text;
        $auto->step4Text = $request->step4Text;
        $auto->save();
        return redirect('admin/automation/list');
    }

    public function exportCsv (Request $request){
        $response = [];
        $cvs = [];
        if (!$request){
            return response()->json('error',401);

        }
        //return response()->json($request->json()->all(),401);
        foreach ($request->json()->all() as $fields){
            
            
        
        //return;
            foreach($fields as $user){
                $response['id'][] = $user['node']['id']; 
                $response['username'][] = $user['node']['username']; 
                $response['full_name'][] = $user['node']['full_name']; 
                $response['profile_pic_url'][] = $user['node']['profile_pic_url']; 
                $response['is_private'][] = $user['node']['is_private']; 
                $response['is_verified'][] = $user['node']['is_verified']; 
                $response['followed_by_viewer'][] = $user['node']['followed_by_viewer']; 
                $response['requested_by_viewer'][] = $user['node']['requested_by_viewer']; 
                $response['reel_id'][] = $user['node']['reel']['id']; 
                $response['reel_expiring_at'][] = $user['node']['reel']['expiring_at']; 
                $response['reel_has_pride_media'][] = $user['node']['reel']['has_pride_media']; 
                $response['reel_latest_reel_media'][] = $user['node']['reel']['latest_reel_media']; 
                $response['reel_seen'][] = $user['node']['reel']['seen']; 
                $response['reel_owner___typename'][] = $user['node']['reel']['owner']['__typename']; 
                $response['reel_owner_id'][] = $user['node']['reel']['owner']['id']; 
                $response['reel_owner_profile_pic_url'][] = $user['node']['reel']['owner']['profile_pic_url']; 
                $response['reel_owner_username'][] = $user['node']['reel']['owner']['username']; 
                $cvs[] = [
                    $user['node']['id'],
                    $user['node']['username'],
                    $user['node']['full_name'],
                    $user['node']['profile_pic_url'],
                    $user['node']['is_private'],
                    $user['node']['is_verified'],
                    $user['node']['followed_by_viewer'],
                    $user['node']['requested_by_viewer'],
                    $user['node']['reel']['id'],
                    $user['node']['reel']['expiring_at'],
                    $user['node']['reel']['has_pride_media'],
                    $user['node']['reel']['latest_reel_media'],
                    $user['node']['reel']['seen'],
                    $user['node']['reel']['owner']['__typename'],
                    $user['node']['reel']['owner']['id'],
                    $user['node']['reel']['owner']['profile_pic_url'],
                    $user['node']['reel']['owner']['username']
                ];

            }
        }
        $automUser = automStatus::where('token','=',$request->token)->first();
        $user = User::find($automUser->user_id);
        $fileName = strtotime($automUser->created_at).".csv";
        $file = public_path('userStorage').strtotime($user->created_at)."-".$user->id."/";
        if (!file_exists("userStorage/".strtotime($user->created_at)."-".$user->id."/")) {
            mkdir("userStorage/".strtotime($user->created_at)."-".$user->id."/");
        }

        /*if (!file_exists("userStorage/"."123123-123"."/")) {
            mkdir(strtotime("userStorage/"."123123-123"."/"));
        }*/
        
        $automUser->exported_file = "userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName;
        $automUser->save();
        $keys = array_keys($response, true);
        
        $fp = fopen("userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName, 'w');
        fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
        if(count($request->json()->all()) > 10){
            fputcsv($fp, $keys);
        }
        
        
        foreach ($cvs as $row) {
            fputcsv($fp, $row);
        }
        
        fclose($fp);

        //$moveFile = File::move($fileName,"storage/".$fileName);

        //$fileName->move(public_path('images'), $iconName2);
        

        $automStatus = $this->automStatusUpdate($request);

        /*$automUser = automStatus::where('token','=',$request->token)->first();
        $user = User::find($automUser->user_id);
        $file = "/"."userStorage/".strtotime($user->created_at)."-".$user->id."/".time().".csv";
        $automUser->exported_file = $file;
        $automUser->save();*/
        
        return response()->json($automStatus,200);
    }
    function array_keys_multi(array $array)
    {
        $keys = array();

        foreach ($array as $key => $value) {
            $keys[] = $key;

            if (is_array($value)) {
                $keys = array_merge($keys, $this->array_keys_multi($value));
            }
        }

        return $keys;
    }

    public function deleteAuto (Request $request){
        $auto = Automations::find($request->id);

        $auto->delete();
        return redirect('admin/automation/list');
    }

    public function settings_json ($request,$autom) {
        /*$settings_json['user_agent'] = "random_desktop";
        $settings_json['custom_user_agent'] = "";
        $settings_json['screen_resolution'] = "1360x768";
        $settings_json['browser_name'] = "google-chrome";
        $settings_json['process_timeout_seconds'] = "600";
        $settings_json['timezone'] = "America/New_York";
        $settings_json['content_security_policy'] = "";
        $settings_json['chrome_shell_options_str'] = "";
        $settings_json['microphone_allowd_hosts'] = [];
        $settings_json['extra_plugins_paths'] = [];
        $settings_json['remove_chrome_cli_params'] = [];
        $settings_json['geolocation_allowd_hosts'] = [];
        $settings_json['startup_full_screen'] = false;
        $settings_json['browser_enable_audio'] = false;
        $settings_json['redirect_audio_output_to_microphone'] = false;
        $settings_json['run_browser_as_root'] = false;
        $settings_json['dont_clear_cache'] = false;
        $settings_json['webrtc_ip_handling_policy'] = "default";
        $settings_json['ensure_proxied'] = false;

        if(strpos(json_encode($autom->tabText),'name=\"user_agent\"')){
            $settings_json["user_agent"] = $request->all()['user_agent'];
        }
        if(strpos(json_encode($autom->tabText),'name=\"custom_user_agent\"')){
            $settings_json["custom_user_agent"] = $request->all()['custom_user_agent'];
        }
        if(strpos(json_encode($autom->tabText),'name=\"screen_resolution\"')){
            $settings_json["screen_resolution"] = $request->all()['screen_resolution'];
        }
        if(strpos(json_encode($autom->tabText),'name=\"browser_name\"')){
            $settings_json["browser_name"] = $request->all()['browser_name'];
        }
        if(strpos(json_encode($autom->tabText),'name=\"process_timeout_seconds\"')){
            $settings_json["process_timeout_seconds"] = $request->all()['process_timeout_seconds'];
        }
        if(strpos(json_encode($autom->tabText),'name=\"timezone\"')){
            $settings_json["timezone"] = $request->all()['timezone'];
        }
        if(strpos(json_encode($autom->tabText),'name=\"content_security_policy\"')){
            $settings_json["content_security_policy"] = $request->all()['content_security_policy'];
        }
        if(strpos(json_encode($autom->tabText),'name=\"chrome_shell_options_str\"')){
            $settings_json["chrome_shell_options_str"] = $request->all()['chrome_shell_options_str'];
        }
        if(strpos(json_encode($autom->tabText),'name=\"microphone_allowd_hosts\"')){
            $settings_json["microphone_allowd_hosts"] = $request->all()['microphone_allowd_hosts'];
        }
        if(strpos(json_encode($autom->tabText),'name=\"ensure_proxied\"')){
            $settings_json["ensure_proxied"] = true;

        }*/
                             //"{\"user_agent\":\"random_desktop\",\"custom_user_agent\":\"\",\"screen_resolution\":\"1360x768\",\"browser_name\":\"google-chrome\",\"process_timeout_seconds\":\"360\",\"timezone\":\"America\\/New_York\",\"content_security_policy\":\"\",\"chrome_shell_options_str\":\"\",\"microphone_allowd_hosts\":[],\"extra_plugins_paths\":[],\"remove_chrome_cli_params\":[\"\"],\"geolocation_allowd_hosts\":[],\"startup_full_screen\":false,\"browser_enable_audio\":false,\"redirect_audio_output_to_microphone\":false,\"run_browser_as_root\":false,\"dont_clear_cache\":false,\"webrtc_ip_handling_policy\":\"default\",\"ensure_proxied\":true,\"ensure_no_proxied\":false,\"recaptcha_v2\":{\"proxyless\":[\"automatic proxyless solving recaptcha v2 site key\"]},\"funcaptcha\":{\"proxyless\":[]},\"enable_fingerprint_tests\":false,\"sizing_obfuscation\":false,\"block_third_party_cookies\":false,\"obfuscate_navigator_connection\":false,\"obfuscate_canvas_fingerprint\":false,\"webgl_buffer_data_obfuscation\":false,\"webgl_supported_extensions_obfuscation\":false,\"webgl_read_pixels_data_obfuscation\":false,\"obfuscate_audio_fingerprint\":false,\"obfuscate_fonts_fingerprint\":false,\"obfuscate_audio_video_canplay_media_types\":false,\"obfuscate_navigator_plugins\":false,\"dont_inject_any_scripts\":false,\"navigator_device_memory\":\"off\",\"engine_version\":\"v1\",\"navigator_hardware_concurrency\":\"off\",\"code_snippets\":{\"front\":[],\"back\":[]},\"proxy\":{\"type\":\"socks5\",\"host\":\"92.222.195.176\",\"port\":\"10000-12999\",\"username\":\"\",\"password\":\"\",\"domains_proxies\":[],\"urls_proxies\":[],\"bypass_domains_or_ips\":[\"35.238.47.14\",\"pc.am\",\"bot.pc.am\"],\"bypass_url_or_paths\":[]},\"blocking_resource_types\":[],\"webgl_obfuscate_options\":[]}")),
        $settings_json = "{\"user_agent\":\"random_desktop\",\"custom_user_agent\":\"\",\"screen_resolution\":\"1400x1050\",\"process_timeout_seconds\":\"1200\",\"startup_full_screen\":false,\"ensure_proxied\":false,\"proxy\":{\"type\":\"http\",\"host\":\"\",\"port\":\"\",\"username\":\"\",\"password\":\"\",\"domains_proxies\":[],\"urls_proxies\":[],\"bypass_domains_or_ips\":[]},\"blocking_resource_types\":[]}";
        if(strpos(json_encode($autom->tabText),'name=\"proxy_type\"')){
            $settings_json = "{\"user_agent\":\"random_desktop\",\"custom_user_agent\":\"\",\"screen_resolution\":\"1360x768\",\"browser_name\":\"google-chrome\",\"process_timeout_seconds\":\"172800\",\"timezone\":\"America\\/New_York\",\"content_security_policy\":\"\",\"chrome_shell_options_str\":\"\",\"microphone_allowd_hosts\":[],\"extra_plugins_paths\":[],\"remove_chrome_cli_params\":[\"\"],\"geolocation_allowd_hosts\":[],\"startup_full_screen\":false,\"browser_enable_audio\":false,\"redirect_audio_output_to_microphone\":false,\"run_browser_as_root\":false,\"dont_clear_cache\":false,\"webrtc_ip_handling_policy\":\"default\",\"ensure_proxied\":true,\"ensure_no_proxied\":false,\"recaptcha_v2\":{\"proxyless\":[\"automatic proxyless solving recaptcha v2 site key\"]},\"funcaptcha\":{\"proxyless\":[]},\"enable_fingerprint_tests\":false,\"sizing_obfuscation\":false,\"block_third_party_cookies\":false,\"obfuscate_navigator_connection\":false,\"obfuscate_canvas_fingerprint\":false,\"webgl_buffer_data_obfuscation\":false,\"webgl_supported_extensions_obfuscation\":false,\"webgl_read_pixels_data_obfuscation\":false,\"obfuscate_audio_fingerprint\":false,\"obfuscate_fonts_fingerprint\":false,\"obfuscate_audio_video_canplay_media_types\":false,\"obfuscate_navigator_plugins\":false,\"dont_inject_any_scripts\":false,\"navigator_device_memory\":\"off\",\"engine_version\":\"v1\",\"navigator_hardware_concurrency\":\"off\",\"code_snippets\":{\"front\":[],\"back\":[]},\"proxy\":{\"type\":\"".$request->all()['proxy_type']."\",\"host\":\"".$request->all()['proxy_host']."\",\"port\":\"".$request->all()['proxy_port']."\",\"username\":\"\",\"password\":\"\",\"domains_proxies\":[],\"urls_proxies\":[],\"bypass_domains_or_ips\":[\"35.238.47.14\",\"pc.am\",\"bot.pc.am\"],\"bypass_url_or_paths\":[]},\"blocking_resource_types\":[],\"webgl_obfuscate_options\":[]}";
        }
        return $settings_json;
    }

    public function runAutom (Request $request){
        $token = Str::random(16);
        $slug = Automations::where('url',$request->botname)->first();
        $automStatus = new automStatus;
        $task_data = ["token" => $token];
        $settings_json = $this->settings_json($request,$slug);
        //return response()->json($settings_json);
        if(strpos(json_encode($slug->tabText),'name=\"url\"')){
            $task_data["url"] = urlencode($request->url);
            $task_data["url"] = $request->url;
            
        }if(strpos(json_encode($slug->tabText),'name=\"cookies\"')){
            $task_data["cookies"] = json_decode($request->all()['cookies']);
        }if(strpos(json_encode($slug->tabText),'name=\"username\"')){
            $task_data["username"] = json_decode($request->all()['username']);
        }if(strpos(json_encode($slug->tabText),'name=\"search\"')){
            $task_data["search"] = json_decode($request->all()['search']);
        }if(strpos(json_encode($slug->tabText),'name=\"message\"')){
            $task_data["message"] = $request->message;
        }
        if(strpos(json_encode($slug->tabText),'name=\"file\"') && strpos(json_encode($slug->tabText),'type=\"file\"')){
            if ($file = $request->file('file')) {
                $path = "userStorage/".strtotime($request->user()->created_at)."-".$request->user()->id."/";
                if (!file_exists($path)) {
                    //return $path;
                    //mkdir($path);
                }
                $file->move($path,time()."-".$file->getClientOriginalName());
                
                
                $automStatus->uploaded_file = $path."".time()."-".$file->getClientOriginalName();
                $task_data["url"] = "file";
                //return response()->json(["data" => $task_data,"bla" => "vlad", "fileName" => $path."".time()."-".$file->getClientOriginalName()]);
            }
        }
        $task_data = json_encode($task_data,JSON_UNESCAPED_SLASHES);
        $endpoint = "https://instance.checkout.am/api/v1/RunPlugin";
        $postData = [
            'api_key' => $slug->slug,
            'slug' => $slug->api,
            'settings_json' => urlencode(addslashes($settings_json)),
            //'settings_json' => urlencode(addslashes("{\"user_agent\":\"random_desktop\",\"custom_user_agent\":\"\",\"screen_resolution\":\"1400x1050\",\"process_timeout_seconds\":\"99999\",\"startup_full_screen\":false,\"ensure_proxied\":false,\"proxy\":{\"type\":\"http\",\"host\":\"\",\"port\":\"\",\"username\":\"\",\"password\":\"\",\"domains_proxies\":[],\"urls_proxies\":[],\"bypass_domains_or_ips\":[]},\"blocking_resource_types\":[]}")),
            'task_data_json' => urlencode(addslashes($task_data))
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data;charset=utf-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $status = curl_exec($ch);

        $statusJson = json_decode($status);
        
        
        $automStatus->autom_id = $slug->id;
        $automStatus->token = $token;
        $automStatus->run_id = automStatus::where('user_id','=',$request->user()->id)->max('run_id') + 1;
        $automStatus->user_id = $request->user()->id;
        $automStatus->back_log = "justlogthis";
        if($statusJson->success){
            $automStatus->instance = $statusJson->instance_uuid;
            $response = json_decode($statusJson->response);
            if ($response->success){
                $automStatus->status = "Runing";
                $automStatus->save();

                return response()->json(['status' => "success",'id' => $automStatus->run_id],200);
            }else{
                $automStatus->status = "Failed";
                $automStatus->save();
                $statusJson->apiKey = $slug->api;
                //$this->stopAutom($statusJson);
                return response("something wrong not success".$status);
            }
        }else{
                $automStatus->instance = "Failed";
                $automStatus->status = "Failed";
                $automStatus->save();
                $statusJson->apiKey = $slug->api;
                //$this->stopAutom($statusJson);
                return response("something wrong no response".$status);
        }
        
        
    }

    public function automStatusUpdate (Request $request){
        $automStatus = automStatus::where('token','=',$request->token)->first();
        $automStatus->status = $request->status;
        $automStatus->back_log = $request->message;
        $automStatus->save();
        return response("done");
    }

    public function automByUrl(Request $request){
        $auto = Automations::with(['automationType','category'])->where('url','=',$request->url)->first();
        $related = Automations::select('id','category_id','status','shortDescription','url','name','type_id','updated_at')->with(['category','automationType'])->where('id','=',$auto->related)->get();
        $auto['related'] = $related;
        return response()->json($auto, 200);
    }
    public function automListByUrl(Request $request){
        $category = Category::where('url',$request->url)->first();
        $auto = Automations::select('id','category_id','status','shortDescription','url','name','type_id','updated_at')->with(['automationType'])->where('category_id','=',$category->id)->where('status','=','1')->orderBy('updated_at','DESC')->get();
        $related = Automations::select('id','category_id','status','shortDescription','url','name','type_id','updated_at')->with(['category','automationType'])->find($category->related);
        $auto['related'] = $related;
        return response()->json($auto, 200);
    }
    public function stopAutom ($request){
        $client = new Client();
        $res = $client->request('POST', 'https://instance.checkout.am/api/v1/SendActionToInstance', [
            'form_params' => [
                'instance_uuid' => $request->instance_uuid,
                'api_key' => $request->apiKey,
                'data_json' => '{"action":"stop_running_plugin"}',
            ]
        ]);

        $result= $res->getBody();
        return response($result,200);
    }

    public function parseRequest(Request $request){
        $automUser = automStatus::where('token','=',$request->token)->first();
        $user = User::find($automUser->user_id);
        $fileName = strtotime($automUser->created_at).".csv";
        if (!file_exists("userStorage/".strtotime($user->created_at)."-".$user->id."/")) {
            mkdir("userStorage/".strtotime($user->created_at)."-".$user->id."/");
        }
        
        $automUser->exported_file = "userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName;
        $automUser->save();
        
        $fp = fopen("userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName, 'a');
        //$fp = fopen("linkedin.csv","a");
        fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

        $keys = ['Name','Profile Url','Position & Company','Region','Summary','Badge'];

        if($request->data['paging']['start'] == 0){
            fputcsv($fp, $keys);
        }
        
        if ($request->data['paging']['total'] - $request->data['paging']['start'] < 10){
            $count = $request->data['paging']['total'] - $request->data['paging']['start'];
        }else{
            $count = $request->data['paging']['count'];
        }
        //$count = count($request->included) / 3;
        for($i = $count; $i < $count * 2; $i++ ){
            $summary = "Dont Exist";
            $badgeText = "Dont Exits";
            $primary = "Dont Exist";
            $secondary = "Dont Exist";
            if ($request->included[$i]['summary']){
                $summary = $request->included[$i]['summary']['text'];
            }
            if ($request->included[$i]['badgeText']){
                $badgeText = $request->included[$i]['badgeText']['text'];
            }
            if($primary = $request->included[$i]['primarySubtitle']){
                $primary = $request->included[$i]['primarySubtitle']['text'];
            }
            if($request->included[$i]['secondarySubtitle']){
               $secondary = $request->included[$i]['secondarySubtitle']['text']; 
            }
            $array = [$request->included[$i]['title']['text'],$request->included[$i]['navigationUrl'],$primary,$secondary,$summary,$badgeText];
            fputcsv($fp, $array);
        }

        fclose($fp);
        /*
        /*$string = $request->data;
        $string = str_replace('\n', '', $string);
        $string = rtrim($string, ',');
        $string = "[" . trim($string) . "]";
        $json = json_decode($request->json);
        $requestConvert = json_decode($request->json);*/

        //dd($requestConvert->included[4]->title->text);

        $automStatus = $this->automStatusUpdate($request);
        return response()->json("exporting",200);
    }

    public function getAutomationsStatus(Request $request){

        //$auto = Automations::with(['category','automationStatus'])->get();

        $auto = automStatus::with(['automation.category','automation'])->where('user_id','=', Auth::user()->id)->limit(10)->orderBy('id','DESC')->get();

       // $auto = automStatus::all()->where('user_id','=','35');

        return response()->json($auto);
    }

    public function getAutomationsStatusDetails (Request $request){
        $auto = automStatus::with(['automation.category','automation'])->where('run_id','=',$request->id)->where('user_id','=', Auth::user()->id)->first();

        return response()->json($auto);
    }

    public function sendFileWithEmail (Request $request){
        $auto = automStatus::where('run_id','=',$request->id)->where('user_id','=', Auth::user()->id)->first();
        $user = Auth::user();
        //return response()->json($user->email);
        $data = array('name'=>"Automatr");
        $mail = Mail::send('email.sendFile', $data, function($message) use($auto,$user){
           $message->to($user->email,$user->name)->subject
              ('Automatr file extraetor');
           $message->attach(public_path()."/".$auto->exported_file);
        });
        return response()->json($mail);
    }

    public function getCsvDataByRow($data){
        $response = [];
        $lines = file($data["filename"],FILE_SKIP_EMPTY_LINES);
        $row = $lines[$data["row"]]; // Assuming one header row
        $csvdata = str_getcsv($row); // Parse line to CSV

        $num = count($csvdata); // Get number of columns

        for ($c=0; $c < $num; $c++) { // Loop through columns
            $response[] = $csvdata[$c]; // Echo column
        }

        return ["data" => $response,"count" => count($lines)];
    }

    public function test(Request $request){
        $data["filename"] = "file3th.csv";
        $data["row"] = $request->row;
        $uploadedFile = file('file3th.csv', FILE_SKIP_EMPTY_LINES);
        $fp = fopen("test3thClient.csv", 'a');
            //$fp = fopen("linkedin.csv","a");
            fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
            $companyName = "";
            $companyLinkedinUrl = "";
            $companyWebSite = "";
            foreach ($request->companyName as $companyNames){
                $companyName .= $companyNames." - ";
            }
            foreach ($request->companyLinkedinUrl as $companyLinkedinUrls){
                $companyLinkedinUrl .= $companyLinkedinUrls." - ";
            }
            foreach ($request->companyWebSite as $companyWebSites){
                $companyWebSite .= $companyWebSites." - ";
            }
            $array = [$request->name,$request->userLinkedinUrl,$request->region,$companyName,$companyLinkedinUrl,$companyWebSite];
            fputcsv($fp, $array);
            fclose($fp);
        if (count($uploadedFile) > $request->row){
            $response = $this->getCsvDataByRow($data);
            $response = ["name" => $response["data"][0]." ".$response["data"][1],"company" => $response["data"][2],"status" => "next"];
            
            return response()->json($response);
        }else if(count($uploadedFile) == $request->row){
            $response = ["status" => "done"];
            return response()->json($response);
        }
    }

    public function linkedinMatchData (Request $request){
        $automUser = automStatus::where('token','=',$request->token)->first();
        
        if ($request->data['paging']['total'] - $request->data['paging']['start'] < 10){
            $count = $request->data['paging']['total'] - $request->data['paging']['start'];
        }else{
            $count = $request->data['paging']['count'];
        }
        $returnIndex = 1;
        $companyName = "asdasd";
        for($i = $count; $i < $count + 3; $i++ ){
            if($request->included[$i]['primarySubtitle'] && str_contains($companyName, $request->included[$i]['primarySubtitle']['text'])){
                return response()->json([
                    'status' => 'success',
                    'userIndex' => $returnIndex
                ]);
            }

            $returnIndex++;
        }
        return response()->json([
            'status' => 'next',
            'userIndex' => $request->userIndex + 1
        ]);
    }
    /*public function responseRequest(Request $request){
        $f = File::allFiles(public_path('images'));
        $optimizer = new Tinify();
        $optimizer->setKey("dlPPcwgBlTrplzpCbnJgxGkyPM0561M7");
        for ($i = 90; $i < 122; $i++){
            if(pathinfo($f[$i])['extension'] == "png" || pathinfo($f[$i])['extension'] == "jpg" || pathinfo($f[$i])['extension'] == "jpeg"){
                $file = Source::fromFile(public_path('images')."/".pathinfo($f[$i])['basename']);
                $file->toFile(public_path('images')."/".pathinfo($f[$i])['basename']);
            }
            
        }
        
        return response()->json(pathinfo($f[1])['extension']);
    }*/

    public function twitterPostLiker(Request $request){
        $data["filename"] = "twitter.csv";
        $data["row"] = $request->row;
        //$fp = fopen("twitterOutput.csv", 'a');
        $uploadedFile = file('twitter.csv', FILE_SKIP_EMPTY_LINES);
        $response = ["status" => "error"];
        $element = "";
        if (count($uploadedFile) > $request->row){
            $response = $this->getCsvDataByRow($data);
            //return response()->json($response['data'][0]);
            $response = $response['data'][0];
            $element = parse_url($response);
            return response()->json(["url" => $response, "element" => $element['path'],"status" => "next"]);
        }else if(count($uploadedFile) == $request->row){
            return response()->json( $response = ["status" => "done"]);
        }    
    }

    public function uploadCsv (Request $request){

        //dd($request);

        //return response()->json($request);

        if ($file = $request->file('file')) {
             
            //store file into document folder
            $path = $file->move("userStorage/","vlad.csv");
            $name = $file->getClientOriginalName();
              
            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "file" => $name,
                "path" => $path
            ]);
  
        }
    }

    public function dateDiffBet (Request $request){
        $auto = automStatus::where('id','=',"1")->first();
        $data = array('name'=>"Automatr");
        $mail = Mail::send('email.sendFile', $data, function($message) use($auto){
           $message->to("vladevoyan@gmail.com","Vlad")->subject
              ('Automatr file extraetor');
           //$message->attach(public_path()."/".$auto->exported_file);
        });
        return response()->json($mail);
    }

    public function changeUserPackgaeUsage ($autom){
        $automUser = automStatus::where('token','=',$autom)->first();
        $diff =  strtotime(now()) - strtotime($automUser->updated_at);
        $package = package_users::where('user_id', '=', $automUser->user_id)->first();
        if($package){
            $remaining = package::where('id','=',$package->package_id)->first();
            if($remaining->timeLimit > $diff){
                $package->usedTime = $package->usedTime + $diff;
                $package->save();
                return true;
            }else{
                $package->usedTime = $remaining->timeLimit ;
                $package->save();
                return false;
            }
        }else{
            return true;
        }
        
        
    }

    public function checkIsPackageValid ($user){
        $package = order::where('user_id', '=',$user)->first();
        if($package->packageType == "monthly" && strtotime(now()) < strtotime($package->created_at.' + 1 months')){
            return true;

        }else if($package->packageType == "annually" && strtotime(now()) < strtotime($package->created_at.' + 1 year')){
            return true;
        }else{
            return false;
        }
    }

    public function checkIsPackageLimit ($user){
        $package = package_users::where('user_id', '=', $user)->first();
        $remaining = package::where('id','=',$package->package_id)->first();
        if($remaining->timeLimit > $package->usedTime && $remaining->autoLimit > $package->usedAutom ){
            return $package;
        }
        return $remaining;
    }

    public function instaApiExtractor(Request $request){
        $this->changeUserPackgaeUsage($request->token);
        $automUser = automStatus::where('token','=',$request->token)->first();
        $user = User::find($automUser->user_id);
        if($request->statusAutom !="Done"){
            $fileName = strtotime($automUser->created_at).".csv";
        if (!file_exists("userStorage/".strtotime($user->created_at)."-".$user->id."/")) {
            mkdir("userStorage/".strtotime($user->created_at)."-".$user->id."/");
        }
        
        $automUser->exported_file = "userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName;
        $automUser->save();
        
        $fp = fopen("userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName, 'a');

        fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

        
        $keys = [$request->user['full_name'],
            "https://www.instagram.com/".$request->user['username'],
            $request->user['username'],
            $request->user['profile_pic_url'],
            $request->user['is_private'],
            $request->user['is_verified'],
            $request->user['media_count'],
            $request->user['follower_count'],
            $request->user['following_count'],
            $request->user['following_tag_count'],
            $request->user['biography'],
            $request->user['external_url'],
            $request->user['total_igtv_videos'],
            $request->user['usertags_count'],
            $request->user['mutual_followers_count'],
            $request->user['profile_context'],
            $request->user['is_business'],
            $request->user['is_potential_business'],
            $request->user['is_new_to_instagram']];
        if($request->turn <= 1){
            $header = ['Name',
                'Profile Url',
                'Username',
                'Profile pic',
                'Profile is private',
                'Profile is verified', 
                'Post count', 
                'Follower count',
                'Following count',
                'Following tag count', 
                'Bio', 
                'Website', 
                'igtv count', 
                'User tag count', 
                'Mutual followers count', 
                'Profile context',
                'Is business profile',
                'Is potential business', 
                'Is new to instagram'];
                fputcsv($fp, $header);
        }

        fputcsv($fp, $keys);
        fclose($fp);

        }
        
        $request->status = $request->statusAutom;
        
        $automStatus = $this->automStatusUpdate($request);
        
        return response()->json(["status" => "go"]);
    }

    public function followingCollector (Request $request){
        $this->changeUserPackgaeUsage($request->token);
        $automUser = automStatus::where('token','=',$request->token)->first();
        $user = User::find($automUser->user_id);
        if($request->statusAutom !="Done"){
            $fileName = strtotime($automUser->created_at).".csv";
        if (!file_exists("userStorage/".strtotime($user->created_at)."-".$user->id."/")) {
            mkdir("userStorage/".strtotime($user->created_at)."-".$user->id."/");
        }
        
        $automUser->exported_file = "userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName;
        $automUser->save();
        
        $fp = fopen("userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName, 'a');

        fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
        if($request->turn <= 0){
            $header = ['Name',
                'Profile Url',
                'Username',
                'Profile pic',
                'Profile is private',
                'Profile is verified'];
                fputcsv($fp, $header);
        }

        foreach($request->users as $user){
            $keys = [$user['full_name'],
            "https://www.instagram.com/".$user['username'],
            $user['username'],
            $user['profile_pic_url'],
            $user['is_private'],
            $user['is_verified']];

            fputcsv($fp, $keys);

        }
        fclose($fp);

        }
        $automStatus = $this->automStatusUpdate($request);
        return response()->json(["status" => "go"]);
    }

    public function automActionUpdate (Request $request){
        $this->changeUserPackgaeUsage($request->token);
        $automStatus = $this->automStatusUpdate($request);

        return response()->json(["status" => "done"]);

    }

    public function instagramPostExtractor (Request $request) {

        $this->changeUserPackgaeUsage($request->token);
        $automUser = automStatus::where('token','=',$request->token)->first();
        $user = User::find($automUser->user_id);

        $fileName = strtotime($automUser->created_at).".csv";
        if (!file_exists("userStorage/".strtotime($user->created_at)."-".$user->id."/")) {
            mkdir("userStorage/".strtotime($user->created_at)."-".$user->id."/");
        }
        
        $automUser->exported_file = "userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName;
        $automUser->save();
        
        $fp = fopen("userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName, 'a');

        fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

        if($request->turn <= 0){
            $header = ['Name',
                'Profile Url',
                'Username',
                'Image',
                'Location',
                'Like count',
                'Comment count',
                'Caption',
                'Description',
                'Date'
            ];
                fputcsv($fp, $header);
        }

        $keys = [$request->full_name,
            $request->profileUrl,
            $request->username,
            $request->imgUrl,
            $request->location,
            $request->like_count,
            $request->comment_count,
            $request->caption,
            $request->description,
            $request->date    
        ];

        fputcsv($fp, $keys);
        $automStatus = $this->automStatusUpdate($request);
        return response()->json(['status' => 'done']);
    }

    public function getFullTabData (Request $request) {
        $package_users = package_users::where('user_id', '=', $request->user()->id)->first();
        $package = package::where('id', '=', $package_users->package_id)->first();

        if($package_users->valid != 1)
        return response()->json(['error' => 'NotValid']);

        if($package_users->usedTime > $package->timeLimit)
            return response()->json(['error' => 'Time']);
        
        if($package_users->usedAutom > $package->autoLimit)
            return response()->json(['error' => 'Count']);

        return $this->runAutom($request);
    }

    public function yellowPageSearchExtractor (Request $request){
        $this->changeUserPackgaeUsage($request->token);
        $automUser = automStatus::where('token','=',$request->token)->first();
        $user = User::find($automUser->user_id);

        $fileName = strtotime($automUser->created_at).".csv";
        if (!file_exists("userStorage/".strtotime($user->created_at)."-".$user->id."/")) {
            mkdir("userStorage/".strtotime($user->created_at)."-".$user->id."/");
        }
        
        
        
        $fp = fopen("userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName, 'a');

        fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

        if($automUser->exported_file != "userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName){
            $header = ['Name',
                'number',
                'address',
                'locality',
                'website',
                'url'
            ];
                fputcsv($fp, $header);
        }
        foreach ($request->data as $row){
            $website = "";
            $number = "";
            $name = "";
            $locality = "";
            $address = "";
            $url = "";
            if(array_key_exists("website",$row)){
                $website = $row['website'];
            }if(array_key_exists("name",$row)){
                $name = $row['name'];
            }
            if(array_key_exists("address",$row)){
                $address = $row['address'];
            }
            if(array_key_exists("locality",$row)){
                $locality = $row['locality'];
            }
            if(array_key_exists("number",$row)){
                $number = $row['number'];
            }
            if(array_key_exists("url",$row)){
                $url = $row['url'];
            }
            $keys = [
                $name,
                $number,
                $address,
                $locality,
                $website,
                $url
                
            ];

            fputcsv($fp, $keys);

        }
        $automUser->exported_file = "userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName;
        $automUser->save();
        $automStatus = $this->automStatusUpdate($request);
        if($request->status == "done"){
            return response()->json(['status' => 'done']);
        }
        return response()->json(['status' => 'next']);
    }
    public function returnDataByRow(Request $request){
        //$this->changeUserPackgaeUsage($request->token);
        $automUser = automStatus::where('token','=',$request->token)->first();
        $row = $this->getCsvDataByRow(["row" => $request->row, "filename" => $automUser->uploaded_file]);
        $status = "next";
        if($request->row +1 >= $row['count']){
            $status = "done";
        }
        return ["url" => $row['data'][0], "count" => $row['count'], "status" => $status];
    }
    public function yellowPageCompanyExtractor (Request $request){
        $this->changeUserPackgaeUsage($request->token);
        $automUser = automStatus::where('token','=',$request->token)->first();
        $user = User::find($automUser->user_id);

        $fileName = strtotime($automUser->created_at).".csv";
        if (!file_exists("userStorage/".strtotime($user->created_at)."-".$user->id."/")) {
            mkdir("userStorage/".strtotime($user->created_at)."-".$user->id."/");
        }
        
        
        
        $fp = fopen("userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName, 'a');

        
        if($automUser->uploaded_file != NULL){
            $response = $this->returnDataByRow($request);
        }else{
            $response = ["status" => "done"];
        }

        if($automUser->exported_file == NULL){
            fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
            $keys = ["Name","Phone","Address","Website","Email","Yellow page url","Categories","Working hours"];
            fputcsv($fp, $keys);
        }
        
        if($request->row > 1){
            $keys = [$request->data[0]["name"],$request->data[0]["number"],$request->data[0]["address"],$request->data[0]["website"],$request->data[0]["email"],$request->data[0]["ypUrl"],$request->data[0]["categories"],$request->data[0]["hours"]];
            fputcsv($fp, $keys);
        }
        $automUser->exported_file = "userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName;
        $automUser->save();
        $this->automStatusUpdate($request);
        return $response;
    }

    public function mapExtract (Request $request){
        $this->changeUserPackgaeUsage($request->token);
        $automUser = automStatus::where('token','=',$request->token)->first();
        $user = User::find($automUser->user_id);
        $fileName = strtotime($automUser->created_at).".csv";
        if (!file_exists("userStorage/".strtotime($user->created_at)."-".$user->id."/")) {
            mkdir("userStorage/".strtotime($user->created_at)."-".$user->id."/");
        }
        $fp = fopen("userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName, 'a');

        
        if($automUser->exported_file == NULL){
            fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
            $keys = array_keys($request->data[0]);
            //$keys = ["Name","Phone","Address","Website","rating","Working hours"];
            fputcsv($fp, $keys);
        }
        //$keys = [$request->data[0]["name"],$request->data[0]["phone"],$request->data[0]["address"],$request->data[0]["website"],$request->data[0]["rating"],$request->data[0]["hours"]];
        $keys = array_values($request->data[0]);
        fputcsv($fp, $keys);
        $this->automStatusUpdate($request);
        $automUser->exported_file = "userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName;
        $automUser->save();
        if($request->status == "done"){
            return response()->json(["status" => "done"]);
        }
        return response()->json(["status" => "next"]);
    }


    public function automExtraction(Request $request){
        if(!$this->changeUserPackgaeUsage($request->token)){
            $request->status = "Package Expired";
            $this->automStatusUpdate($request);
            return response()->json(["status" => "Package Expired"]);
        }
        $automUser = automStatus::where('token','=',$request->token)->first();
        $user = User::find($automUser->user_id);
        if($request->automType == "export"){
            $fileName = strtotime($automUser->created_at).".csv";
            if (!file_exists("userStorage/".strtotime($user->created_at)."-".$user->id."/")) {
                mkdir("userStorage/".strtotime($user->created_at)."-".$user->id."/");
            }
            $fp = fopen("userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName, 'a');
            if($automUser->exported_file == NULL){
                fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
                $keys = array_keys($request->data[0]);
                fputcsv($fp, $keys);
            }

            foreach($request->data as $data){
                $keys = array_values($data);
                fputcsv($fp, $keys);
            }
            $automUser->exported_file = "userStorage/".strtotime($user->created_at)."-".$user->id."/".$fileName;
            $automUser->save();
        }
        if($automUser->uploaded_file != NULL){
            $response = $this->returnDataByRow($request);
        }else{
            $response = ["status" => $request->status];
        }
        $this->automStatusUpdate($request);

        return response()->json($response);
    }

    public function automAction (Request $request){
        if(!$this->changeUserPackgaeUsage($request->token)){
            $request->status = "Package Expired";
            $this->automStatusUpdate($request);
            return response()->json(["status" => "Package Expired"]);
        }
        $automUser = automStatus::where('token','=',$request->token)->first();
        if($automUser->uploaded_file != NULL){
            $response = $this->returnDataByRow($request);
        }else{
            $response = ["status" => $request->status];
        }
        return response()->json($response);
    }
}
