<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tweet;
use App\Rules\Myrule;

class TweetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Tweet $tweet)
    {
        $user = auth()->user();
        $timelines = $tweet->getUserTimeLine($user->id);
        return view('tweets.index', [
            'user'      => $user,
            'timelines' => $timelines
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();

        return view('tweets.create', [
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Tweet $tweet)
    {
        $user = auth()->user();
        $data = $request->all();
        $validator = Validator::make($data, [
            'text' => ['required', 'active_url',new Myrule]
        ]);

        $validator->validate();
        $tweet->tweetStore($user->id, $data);

        return redirect('/tweets');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tweet $tweet)
    {
        $user = auth()->user();
        $tweet->tweetDestroy($user->id, $tweet->id);

        return back();
    }
}
