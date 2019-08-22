<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use function auth;
use function redirect;
use function view;

class UserController extends Controller
{
    /**
     * Añade un nuevo usuario, solo si tiene permisos para ello.
     */
    public function add()
    {
        return 'Entra add';
    }

    /**
     * Vista individual de usuario.
     */
    public function view($id = null, $nick = null)
    {
        $user_id = $id ?: auth()->id();
        $user = User::find($user_id);

        if (! $user) {
            return redirect()->back()->with([
                'error' => 'Hubo un problema mientras se buscaba al usuario.'
            ]);
        }

        return view('panel.users.view')->with([
            'user_id' => $user_id,
            'user' => $user,
            'nick' => $user->nick,
        ]);
    }

    public function index()
    {
        return view('panel.users.index');
    }
}
