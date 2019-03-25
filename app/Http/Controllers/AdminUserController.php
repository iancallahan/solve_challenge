<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Storage;
use Image;

class AdminUserController extends Controller
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
          $query = User::orderBy('created_at', request('sort'));
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
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user = User::create(['name' => $request->input('name'),
                              'email' => $request->input('email'),
                              'password' => bcrypt($request->input('password'))]);

        return redirect()->route('admin.users.edit', $user->id);

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
    public function edit(Request $request, User $user)
    {   
        $userID = $user->id;
        return view('profile.form', ['user' => $user, 'userID' => $userID]);
    }

    function fetchBiography(Request $request, User $user) {
        if(empty($user->bio)){
            return response()->json("");
        }
        return response()->json($user->bio);
    }

    function updateBiography(Request $request, User $user) {
        $request->validate([
            'bio' => 'max:' . $request->input('maxLength'),
        ]);
        $user->bio = $request->input('bio');
        $user->save();
    
        return response()->json($user->bio);
    }
    
    function updateHeadshot(Request $request, User $user) {
        
        $request->validate([
            'headshot' => 'required|image|max:2048'
        ]);

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
    
        return redirect()->route('admin.users.edit', $user->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        
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
