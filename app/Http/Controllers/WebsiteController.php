<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('welcome',[
            'users' => $users
        ]);
    }

    public function destroy(Request $request)
    {
        $users = $request->ids;
        User::whereIn('id', explode(',', $users))->delete();
        return response()->json(['status' => true, 'message' => "User Deleted Successfully"], 200);
    }
}
