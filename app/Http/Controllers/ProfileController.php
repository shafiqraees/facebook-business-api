<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*$daat = User::whereEmail('malikshafiq995@yahoo.com')->first()->id;
        Auth::loginUsingId($daat);*/
        return view('profile.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProfileRequest $request)
    {
        $input = $request->all();
        $rules = [
            'name'=> 'required'
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()){
            $arr = ['status' =>400, "msg" => $validator->errors()->first(), 'result'=>[]];
        }else {
            try {
                $user = User::find(Auth::id());
                $user->name = $request->name;
                $user->save();
                $msg ='profile update successfully';
                $arr = array("status" => 200, "msg" => $msg );
            } catch (Exception $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2]))
                {
                    $msg = $ex->errorInfo[2];
                }
                $arr = array("status" => 400, "msg" => $msg,"result" => array() );
            }
        }
        return \Response::json($arr);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfileRequest  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }

    public function redirectToFacebookProvider()
    {
        return Socialite::driver('facebook')->scopes([
            "public_profile, pages_show_list", "pages_read_engagement", "pages_manage_posts", "pages_manage_metadata", "user_videos", "user_posts"
        ])->redirect();
    }
    public function loginUsingFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleProviderFacebookCallback()
    {
        $auth_user = Socialite::driver('facebook')->stateless()->user();
        dd($auth_user);
        DB::table('users')
            ->where('id', Auth::id())
            ->update([
                'token' => $auth_user->token,
                'facebook_app_id'  =>  $auth_user->id,
            ]);
        return redirect()->to('/profile');
    }

    public function callBack()
    {
        $auth_user = Socialite::driver('facebook')->user();
        //$auth_user = Socialite::driver('facebook')->user();
        dd($auth_user);
        DB::table('users')
            ->where('id', Auth::id())
            ->update([
                'token' => $auth_user->token,
                'facebook_app_id'  =>  $auth_user->id,
            ]);
        return redirect()->to('/profile');
    }

    public function facebook_page_id(Request $request)
    {
        $input = $request->all();
        $rules = [
            'facebook_page_id'=> 'required'
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()){
            $arr = ['status' =>400, "msg" => $validator->errors()->first(), 'result'=>[]];
        }else {
            try {
                $user = User::find(Auth::id());
                $user->facebook_page_id = $request->facebook_page_id;
                $user->save();
                $msg ='page id update successfully';
                $arr = array("status" => 200, "msg" => $msg );
            } catch (Exception $ex) {
                $msg = $ex->getMessage();
                if (isset($ex->errorInfo[2]))
                {
                    $msg = $ex->errorInfo[2];
                }
                $arr = array("status" => 400, "msg" => $msg,"result" => array() );
            }
        }
        return \Response::json($arr);

    }
}
