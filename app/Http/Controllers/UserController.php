<?php

namespace App\Http\Controllers;

use App\Rules\HasDigit;
use App\Rules\HasLowercaseCharacter;
use App\Rules\HasUppercaseCharacter;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @param  Request  $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $users = User::filter($request)->paginate();

        return view('web.backend.sections.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('web.backend.sections.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'confirmed',
                'min:10',
                new HasDigit(),
                new HasLowercaseCharacter(),
                new HasUppercaseCharacter()
            ],
            'password_confirmation' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        flash('The new User was created successfully.')->success();

        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return RedirectResponse|View
     */
    public function edit(User $user)
    {
        if (auth()->id() === $user->id) {
            return view('web.backend.sections.users.edit')->with('user', $user);
        }

        flash('You can\'t edit another user.')->warning();

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => "required|unique:users,name,{$user->id}",
            'email' => "required|email|unique:users,email,{$user->id}",
            'password' => [
                'nullable',
                'confirmed',
                'min:10',
                new HasDigit,
                new HasLowercaseCharacter,
                new HasUppercaseCharacter
            ]
        ]);

        $user->update($request->only('name', 'email'));

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        flash('The User was updated successfully.')->success();

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return bool|null
     * @throws \Exception
     */
    public function destroy(User $user): ?bool
    {
        return $user->delete();
    }
}
