<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Storage;
use Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = new User;

        $query = User::query();
        
        $appendParameters = [];

        if(request()->has('sort')){
          $appendParameters['sort'] = request('sort');
        }

        if (request()->has('sort')){
          $query = User::orderBy('name', request('sort'));
        }

        $users = $query->paginate('10')->appends($appendParameters);

        return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = null;
        return view('profile.form')->with('user', $user);
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id = null)
    {   
        $biographyRoute = null;
        $userID = 0;

        if($id == null){
            $user = User::find($request->user()->id);
        }
        else {
            $user = User::find($request->user()->id);
            $userID = $id;
            $biographyRoute = "users/$user->id/biography";
        }
        return view('profile.form', ['user' => $user, 'biographyRoute' => $biographyRoute, 'userID' => $userID]);
    }

    function fetchBiography(Request $request) {
        $user = User::find($request->user()->id);
        if(empty($user->bio)){
            return response()->json("");
        }
        return response()->json($user->bio);
    }

    function updateBiography(Request $request) {
        $user = User::find($request->user()->id);
        $request->validate([
            'bio' => 'max:' . $request->input('maxLength'),
        ]);
        $user->bio = $request->input('bio');
        $user->save();
    
        return response()->json($user->bio);
    }
    
    function updateHeadshot(Request $request) {
        
        $request->validate([
            'headshot' => 'required|image|max:2048'
        ]);

        $user = User::find($request->user()->id);
        
        if (!empty($user->headshot)){
            $store = Storage::disk('public')->delete('images/headshots/' . basename($user->headshot));
        }

        if ($request->hasFile('headshot')){
            $file = $request->file('headshot');
            $extension = $file->getClientMimeType();
            $filename = time() .'.'. $extension;
            // Use Image facade to resize headshot to 300px wide
            $img = Image::make($file);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
                });
            $img->stream();
            $store = Storage::disk('public')->put('images/headshots/' . $filename, $img->__toString(), 'public');
            $img->destroy();
            $user->headshot = Storage::url('images/headshots/' . $filename);
        }
        $user->save();
    
        return redirect()->route('profile.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        
        $user = User::find($request->user()->id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        
        if (!empty($request['password'])) {
            $user->password = bcrypt($request['password']);
        }
 
        if ($request->hasFile('headshot')){
            $file = $request->file('headshot');
            $extension = $file->getClientMimeType();
            $filename = time() .'.'. $extension;
            $store = Storage::disk('public')->put('images/headshots/' . $filename, file_get_contents($file), 'public');
            $user->headshot = Storage::url('images/headshots/' . $filename);
        }

        $user->save();

        session()->flash('alert_class', 'success');
        session()->flash('alert_message', 'Profile updated.');

        return redirect(route('profile.edit'));

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
