<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddRequest;
use App\SocialNetwork;
use App\User;
use App\UserData;
use App\UserDetail;
use App\UserSocial;
use Illuminate\Http\Request;
use RoleHelper;
use function auth;
use function compact;
use function is_null;
use function redirect;
use function view;

class UserController extends Controller
{
    /**
     * Añade un nuevo usuario, solo si tiene permisos para ello.
     */
    public function add($id = null)
    {
        $socialNetworks = SocialNetwork::all();
        return view('panel.users.edit')->with([
            'socialNetworks' => $socialNetworks,
        ]);
    }

    /**
     * Modifica o crea un nuevo usuario.
     *
     * @param null $id
     */
    public function edit($id = null, UserAddRequest $request)
    {
        if ($id) {
            $permission = RoleHelper::canUserEdit($id);
        } else {
            $permission = RoleHelper::canUserCreate();
        }

        if (! $permission) {
            return redirect()->back()->with([
               'error' => 'No tiene permisos para editar este usuario',
            ]);
        }

        $id = $id ?? auth()->id();

        ## Creador del usuario.
        // TODO → Añadir al log
        //$created_by = auth()->id();

        /**
         * Busco usuario, lo crea en caso de no existir.
         */
        $user = User::find($id);

        if ($user) {
            $userDataModel = UserData::where('id', $user->data_id)->first();
            $userDetailModel = UserDetail::where('id', $user->detail_id)->first();
        } else {
            $user = new User();
            $userDataModel = new UserData();
            $userDetailModel = new UserDetail;
        }

        /**
         * Creo redes sociales.
         */
        $social_id = $request->get('social_id') ?? null;
        $social_nick = $request->get('social_nick') ?? null;
        $social_url = $request->get('social_url') ?? null;

        $socialNetworks = UserSocial::saveAllForUser(
            compact('social_id', 'social_nick', 'social_url'),
            $id // Todo → user_id
        );

        ## Almaceno los datos de usuario
        $userData = UserData::addEdit($userDataModel, $request);

        ## Almaceno detalles del usuario
        $userDetail = UserDetail::addEdit($userDetailModel, $request);

        dd($userDetail);

        // Busco todas las tablas relacionadas con el usuario.
        // TODO → Crear trait para añadirlo al modelo de usuario
    }

    /**
     * Vista individual de usuario.
     */
    public function view($id = null)
    {
        $user_id = $id ?: auth()->id();

        ## Obtengo el usuario (Así no repite consultas al ver mi propio user)
        if ((int) $id === (int) auth()->id()) {
            $user = auth()->user();
        } else {
            $user = User::find($user_id);
        }


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
