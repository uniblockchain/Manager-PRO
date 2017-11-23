<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Providers\AppServiceProvider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\This;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Contracts\Cache\Repository;

class ProfileController extends Controller
{

    public $testID ;

    public function __construct()
    {
        $this->middleware('auth');


    }
    public function setTestID($id)
    {
//        $this->testID = $id;
//        Cache::put($this->testID, $id);
        echo  $this->testID ;
    }

    public function getTestID()
    {
//        echo 'get';
//        Cache::get($this->testID);
//        return $this->testID;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//dd($this);
        $id = \Auth::user()->id;
        $this->setTestID($id);

        $profiles = DB::table('profiles')
            ->where('user_id', $id)
            ->get();

        return view('Profile.index', ['profiles' => $profiles]);
    }

    public function save()
    {
//        $id = \Auth::user()->id;
//        $this->setTestID($id);
//        echo "<br/>";
//        echo $this->testID;

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = \Auth::user()->id;
        $currentProfile = \Auth::user()->profile;// udalo sie !!!!!!!!!!

        $profile = new Profile();

        $profile->name_profile = $request->input('name_profile');
        $profile->surname_profile = $request->input('surname_profile');
        $profile->user_id = $id;
        $profile->birthday_profile = $request->input('birthday_profile');
        $profile->tel_profile = $request->input('phone_profile');
        $profile->country_profile = $request->input('country_profile');

        $profile->save();
        dd($profile);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
//        $this->getTestID();


        $id = \Auth::user()->id;
        $profiles = DB::table('profiles')
            ->where('user_id', $id)
            ->get();

        return view('Profile.edit', ['profiles' => $profiles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = \Auth::user()->id;
        $profile_id = DB::table('profiles')->value('user_id');
        $allValueEditProfile = $request->except('_token');

        foreach ($allValueEditProfile as $key => $value) {

            $value === NULL ? $value = DB::table('profiles')->where('user_id', $id)->value($key): $value;

            $profile_name_update = DB::table('profiles')
                ->where('user_id', $profile_id)
                ->update([$key => $value]);

//            echo ('wszystko sie udalo, twoje dane zostały podmienione');
        // dziala pobranie danych skrocona wersja tego z empty ( empty do wywaleia )
        }

//        if(empty($newProfileSurname)) {
//            $newProfileSurname =  DB::table('profiles')->value('surname_profile');
//        }else if(empty($newProfileName)) {
//            $newProfileName =  DB::table('profiles')->value('name_profile');
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $id = \Auth::user()->id;

        $profiles = DB::table('profiles')
            ->where('user_id', $id)
            ->whereNotNull('updated_at')
            ->delete();

        return redirect('profile');
    }
}
