<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Tweet;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $all_users = $user->getAllUsers(auth()->user()->id);

        return view('users.index', [
            'all_users'  => $all_users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Tweet $tweet)
    {
        $login_user = auth()->user();
        $timelines = $tweet->getTimeLine($user->id);
        $tweet_count = $tweet->getTweetCount($user->id);

        return view('users.show', [
            'user'           => $user,
            'timelines'      => $timelines,
            'tweet_count'    => $tweet_count,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $user)
    {
        {
            $data = $request->all();
            $validator = Validator::make($data, [
                'screen_name'   => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
                'name'          => ['required', 'string', 'max:255'],
                'profile_image' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
                'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)]
            ]);
            $validator->validate();
            $user->updateProfile($data);
    
            return redirect('users/'.$user->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
