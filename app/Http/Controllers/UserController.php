<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::all();
        return view('pages.manage.user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|unique:users,email|email:dns',
            'password' => 'required|string',
            'role' => 'required|string'
        ]);

        // if ($validator->fails()) {
        //     return redirect()->back()
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        // $validated = $validator->validated();

        DB::transaction(function () use ($request) {
            User::create([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'password' => bcrypt($request->input('password')),
                'created_by' => now(),
                'updated_by' => now(),
            ]);

            return redirect()->back()->with('success', 'New user saved!');
        }, 5);

        return redirect()->back()->with('error', 'Failed to save new user!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::find($id);
        return view('pages.manage.user.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'form-type' => 'required|in:profile-updates,security-updates'
        ]);

        $type = $request->input('form-type');

        switch ($type) {
            case 'profile-updates':
                return $this->profile_update($request, $id);
                break;
            case 'security-updates':
                return $this->security_update($request, $id);
                break;

            default:
                return redirect('/users/' . $id . '/edit')->with('error', 'Failed to save user data!');
                break;
        }
    }

    public function profile_update($request, $id)
    {
        $validator = Validator::make($request->all(), [
            // $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username,' . $id,
            'email' => 'required|string|unique:users,email,' . $id . '|email:dns',
            // 'password' => 'required|string',
            'role' => 'required|string'
        ]);

        // dd(redirect('/users/' . $id . '/edit'));

        if ($validator->fails()) {
            // return redirect('/users/' . $id . '/edit')
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()->with('error', 'Failed to save user data!');
        }

        // dd($validator->validated());

        DB::transaction(function () use ($request, $id) {
            User::where('id', $id)->update([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'updated_at' => now(),
            ]);

            return redirect('/users')->with('success', 'User data saved!');
        }, 5);

        return redirect('/users/' . $id . '/edit')->with('error', 'Failed to save user data!');
    }

    public function security_update($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => ['required'],
            'password' => ['required', 'confirmed', Password::min(9)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()],
        ]);

        if ($validator->fails()) {
            // return redirect('/users/' . $id . '/edit')
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()->with('error', 'Failed to save user data!');
        }

        DB::transaction(function () use ($request, $id) {
            User::where('id', $id)->update([
                'password' => bcrypt($request->input('password')),
                'updated_at' => now(),
            ]);

            return redirect('/users')->with('success', 'User data saved!');
        }, 5);

        return redirect('/users/' . $id . '/edit')->with('error', 'Failed to save user data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            User::destroy($id);

            return redirect('/users')
                ->with([
                    'success' => 'User deleted successfully!'
                ]);
        }, 5);

        return redirect('/users')
            // ->route('categories')
            ->with([
                'error' => 'An problem has occurred, please try again'
            ]);
    }
}
