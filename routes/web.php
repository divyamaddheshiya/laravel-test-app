<?php
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Models\Profile;
use App\Models\StockDetails;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('login/fb', function() {
    $facebook = new Facebook(Config::get('facebook'));
    $params = array(
        'redirect_uri' => url('/login/fb/callback'),
        'scope' => 'email',
    );
    return Redirect::to($facebook->getLoginUrl($params));
})->name('login.facebook');

Route::get('login/fb/callback', function(Request $request) {
    $code = $request['code'];

    if (strlen($code) == 0) return Redirect::to('/')->with('message', 'There was an error communicating with Facebook');

    $facebook = new Facebook(Config::get('facebook'));
    $uid = $facebook->getUser();

    if ($uid == 0) return Redirect::to('/')->with('message', 'There was an error');

    $me = $facebook->api('/me');

    $profile = Profile::whereUid($uid)->first();
    if (empty($profile)) {

        $user = new User;
        $user->name = $me['first_name'].' '.$me['last_name'];
        $user->email = $me['email'];
        $user->photo = 'https://graph.facebook.com/'.$me['username'].'/picture?type=large';

        $user->save();

        $profile = new Profile();
        $profile->uid = $uid;
        $profile->username = $me['username'];
        $profile = $user->profiles()->save($profile);
    }

    $profile->access_token = $facebook->getAccessToken();
    $profile->save();

    $user = $profile->user;

    Auth::login($user);

    return Redirect::to('/')->with('message', 'Logged in with Facebook');
});

Route::get('/', function()
{
    $data = array();

    if (Auth::check()) {
        $data = Auth::user();
    }
    return View::make('login', array('data'=>$data));
});


Route::get('/', function()
{
    $data = array();
    $stock = array();

    if (Auth::check()) {
        $data = Auth::user();
    }
    if(!empty($data))
    {
        $stock = StockDetails::where('user_id',auth()->user()->id)->orderBy('id', 'DESC')->get();
    }else{
        $stock = StockDetails::orderBy('id', 'DESC')->get();
    }
    
    return View::make('login', array('data'=>$data,'stock' => $stock));
});

Route::post('/getStockData','UserController@getStockData')->name('get.stock');

Route::get('logout', function() {
    Auth::logout();
    return Redirect::to('/');
})->name('logout');