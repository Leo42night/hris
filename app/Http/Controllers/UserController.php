<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view("welcome", compact("users"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        try {
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password)
            ]);

            // Jika berhasil
            if (!$user instanceof User) {
                // Jika gagal
                return response()->json(['success' => false, 'errorMsg' => 'Failed to create user'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'errorMsg' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $password = $request->input('password');

        // cek apakah ada password baru
        if (!empty($request->input('newPassword'))) {
            $password = Hash::make($request->input('newPassword'));
        }

        // return response()->json(['success update' => true, 'id' => $id, 'user' => $request->all()]);

        $newUser = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $password
        ];

        try {
            $user = User::findOrFail($id);
            $status = $user->update($newUser);

            // Jika berhasil
            if ($status) {
                return response()->json(['success' => true, 'message' => 'User updated successfully']);
            } else {
                // Jika gagal
                return response()->json(['success' => false, 'errorMsg' => 'Failed to update user'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'errorMsg' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $status = User::destroy($id);
            if ($status) {
                return response()->json(['success' => true, 'message' => 'User deleted successfully']);
            } else {
                // Jika gagal
                return response()->json(['success' => false, 'errorMsg' => 'Failed to delete user'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'errorMsg' => $e->getMessage()], 500);
        }
    }
}
