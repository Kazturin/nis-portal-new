<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModifyLinkController extends Controller
{

    public function __invoke(Request $request)
    {
        if (!Auth::guard('ldap')->check()) {
            return redirect()->guest(route('login'));
        }
        /** @var mixed $user */
        $user = Auth::guard('ldap')->user();
        $email = $user->mail;

        $email = explode('@', $email[0])[1];

        $url = $request->query('url').'.'.$email;

        return redirect($url);
    }
}