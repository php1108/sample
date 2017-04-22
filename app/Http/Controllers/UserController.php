<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
class UserController extends Controller
{
    public function create()
    {
        return view('users.create');
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show',compact('user'));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required'
        ]);
        /**
         * 5.4.4 唯一性验证
        一般情况下，我们还需要验证用户使用的注册邮箱是否已被它人使用，这时我们可以使用唯一性验证，这里是针对于数据表 users 做验证。

        'email' => 'unique:users'
         * 5.4.5 密码匹配验证
        如果我们需要确保用户在输入密码时，保证两次输入的密码一致。这时候则可以使用 confirmed 来进行密码匹配验证。

        'password' => 'confirmed'
         */
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }
}
