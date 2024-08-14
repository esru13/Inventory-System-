<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\BusinessOwner;

class BusinessOwnerController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:business_owners',
            'password' => 'required|string|min:8|confirmed',
            'company_name' => 'required|string|max:255'
        ]);

        $businessOwner = BusinessOwner::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_name' => $request->company_name
        ]);

        $token = $businessOwner->createToken('auth-token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $businessOwner = BusinessOwner::where('email', $request->email)->first();

        if (! $businessOwner || ! Hash::check($request->password, $businessOwner->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $businessOwner->createToken('auth-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }
    public function logout(Request $request){   

        $request->user()->currentAccessToken()->delete();

        return response()->json(['message'=>'Logged out sucessfully']);
    }
}