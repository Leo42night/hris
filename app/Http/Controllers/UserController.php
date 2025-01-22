<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("welcome");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|unique:users,email'
            ]);
         
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password)
            ]);
            
            return response()->json([
                'success' => true,
                'msg' => $user->name
            ], 201); // Created
    
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errorMsgs' => $e->errors(), // Mengembalikan array error per kolom
            ], 422); // 422 Unprocessable Entity
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'errorMsg' => $e->getMessage()], 500); // 500 Internal Server Error
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'email' => 'email|unique:users,email,'.$id //pengecualian
            ]);

        $password = $request->input('password');

        // cek apakah ada password baru
        if (!empty($request->input('newPassword'))) {
            $password = Hash::make($request->input('newPassword'));
        }

        $newUser = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $password
        ];

            $user = User::findOrFail($id);
            $result = $user->update($newUser);

            return response()->json([
                'success' => true,
                'msg' => $result
            ], 202); // Accepted (asynchronous)

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errorMsgs' => $e->errors(), // Mengembalikan array error per kolom
            ], 422); // 422 Unprocessable Entity
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
            User::destroy($id);
            return response()->json($id);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'errorMsg' => $e->getMessage()], 500);
        }
    }
}
