<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Mail;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'only' => ['edit', 'update', 'destroy']
        ]);
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
    public function index()
    {
        $users = User::paginate(30);
        return view('users.index', compact('users'));
    }
    public function create()
    {
        return view('users.create');
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        $statuses = $user->statuses()
            ->orderBy('created_at', 'desc')
            ->paginate(30);
        return view('users.show',compact('user','statuses'));
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

        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'aufree@estgroupe.com';
        $name = 'Aufree';
        $to = $user->email;
        $subject = "感谢注册 Sample 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }

    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'confirmed|min:6'
        ]);

        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');
        return redirect()->route('users.show', $id);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }

}
