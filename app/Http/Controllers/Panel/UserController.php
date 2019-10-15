<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddRequest;
use App\SocialNetwork;
use App\User;
use App\UserData;
use App\UserDetail;
use App\UserSocial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use LogHelper;
use RoleHelper;
use function auth;
use function compact;
use function config;
use function dd;
use function is_null;
use function isEmpty;
use function redirect;
use function route;
use function view;

class UserController extends Controller
{
    /**
     * Añade un nuevo usuario, solo si tiene permisos para ello.
     */
    public function add($user_id = null)
    {
        $socialNetworks = SocialNetwork::all();

        $user = User::find($user_id);
        $user_data = $user ? $user->data : null;
        $user_detail = $user ? $user->details :null;
        $user_social = $user ? $user->social :null;
        return view('panel.users.edit')->with([
            'socialNetworks' => $socialNetworks,
            'user_id' => $user_id,
            'user' => $user,
            'user_data' => $user_data,
            'user_detail' => $user_detail,
            'user_social' => $user_social,
        ]);
    }

    /**
     * Modifica o crea un nuevo usuario.
     *
     * @param null                              $id
     * @param \App\Http\Requests\UserAddRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(UserAddRequest $request, $user_id = null)
    {
        if ($user_id) {
            $permission = RoleHelper::canUserEdit($user_id);
        } else {
            $permission = RoleHelper::canUserCreate();
        }

        if (! $permission) {
            return redirect()->back()->with([
               'error' => 'No tiene permisos para editar o crear el usuario',
            ]);
        }

        $action = 'create'; ## Identifica si se crea o edita (create|edit)

        ## Registro de Log.
        LogHelper::register('info', 'Creado usuario');

        /**
         * Busco usuario, lo crea en caso de no existir.
         */
        $user = User::find($user_id);

        if ($user) {
            $action = 'edit';
            $userDataModel = UserData::where('id', $user->data_id)->first();
            $userDetailModel = UserDetail::where('id', $user->detail_id)->first();
        } else {
            $user = new User(['role_id' => 3]);
            $userDataModel = new UserData();
            $userDetailModel = new UserDetail();
        }

        ## Almaceno los datos de usuario.
        $userData = UserData::addEdit($userDataModel, $request);

        ## Almaceno detalles del usuario.
        $userDetail = UserDetail::addEdit($userDetailModel, $request);

        ## Guardo y almaceno el usuario.
        $user->fill([
            'data_id' => $userData->id,
            'detail_id' => $userDetail->id,
            'name' => $request->get('name'),
            'nick' => $request->get('nick'),
            'email' => $request->get('email'),
        ]);

        ## Compruebo la contraseña antes de asignarla al usuario.
        $password = $request->get('password');
        if (isset($password) && !empty($password) && (mb_strlen($password) >= 6)) {
            $user->password = Hash::make($password, ['rounds' => config('constant.bcrypt_cost')]);
        }

        $user->save();

        ## Almaceno redes sociales.
        $social_id = $request->get('social_id') ?? null;
        $social_nick = $request->get('social_nick') ?? null;
        $social_url = $request->get('social_url') ?? null;

        $socialNetworks = UserSocial::saveAllForUser(
            compact('social_id', 'social_nick', 'social_url', 'user_id'),
            $user->id
        );

        // TODO → Crear trait para añadirlo al modelo de usuario
        return redirect()->route('panel.users.view', ['id' => $user->id])->with([
        ]);
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

    /**
     * Muestra la vista principal de usuarios con el listado de todos.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        ## Usuarios Activos
        $users = User::allActive();
        $n_users = $users->count();

        $n_users_this_month = $users->whereBetween('created_at',
            [
                Carbon::now()->subMonth()->format('Y-m-d H:i:s'),
                Carbon::now()->format('Y-m-d H:i:s'),
            ]
        )->count();

        ## Usuarios Inactivos (SoftDelete)
        $usersInactive = User::allInactive();
        $n_usersInactive = $usersInactive->count();

        return view('panel.users.index')->with([
            'users' => $users,
            'n_users' => $n_users,
            'n_users_this_month' => $n_users_this_month,
            'usersInactive' => $usersInactive,
            'n_usersInactive' => $n_usersInactive,
        ]);
    }
}
