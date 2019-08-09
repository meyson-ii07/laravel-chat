<?php
/**
 * Created by PhpStorm.
 * User: illya
 * Date: 23.07.2019
 * Time: 16:44
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Image;
class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function profile()
    {
        if(Auth::user() == NULL)
        {
            return redirect('home');
        }
        return view('profile',array('user'=>Auth::user()));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request){
        $user = Auth::user();
        //avatar
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );
            $user->avatar = $filename;
        }
        $email = $request->get("email");
        //email
        if(trim($email) != "" and $email != $user->email)
            $user->email = $email;
        //password
        $password = $request->get("password");
        $password_confirmation = $request->get("password_confirmation");
        if($password != "")
        {
            if($password != $password_confirmation)
                return redirect("/profile")->with("errors",['confirmation'=> 'Password confirmation mismatch']);
            $user->password = bcrypt($request->get("password"));
        }
        $user->save();
        return redirect('/home')->with('success', 'Profile has been successfully updated!');
    }

}
