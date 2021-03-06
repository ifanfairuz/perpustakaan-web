<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class ProfileController extends Controller
{
	public function save(Request $request)
	{
		$request->validate([
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users,email,'. Auth::id(),
			'password' => 'string|min:8|confirmed|nullable'
		]);

		if ($request->filled('password')) {
			$password = Hash::make($request->password);

			$request->merge(['password' => $password]);

			$data = $request->all();
		} else {
			$data = $request->only('name', 'email');
		}

		$user = Auth::user();
		if ($user instanceof User) {
			$user->update($data);
		}

		return back()->with('success', 'Success Update Profile');
	}
}
