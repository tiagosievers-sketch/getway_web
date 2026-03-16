<?php

namespace App\Actions;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserActions
{
    public static function listUsers(Request $request): UserCollection
    {
        $userId = Auth::id();
        $user =  User::find($userId);
        if(isset($user->is_admin)) {
            if($user->is_admin){
                return new UserCollection(
                    User::orderBy('id', 'asc')->get()
                );
            }
            return new UserCollection(
                User::orderBy('id', 'asc')->where('id',$userId)->get()
            );
        }
        return new UserCollection(
            User::orderBy('id', 'asc')->where('id',$userId)->get()
        );
    }

    public static function isAdmin(): bool
    {
        $userId = Auth::id();
        $user =  User::find($userId);
        if(isset($user->is_admin)) {
            return $user->is_admin;
        }
        return false;
    }
}
