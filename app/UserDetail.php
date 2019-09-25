<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends DefaultModel
{
    protected $table = 'users_detail';

    /**
     * Añade o edita los detalles de para el usuario recibido.
     */
    public static function addEdit($userDataModel, $request)
    {
        $profession = $request->get('profession') ?? null;
        $web = $request->get('web') ?? null;

        $userData = $userDataModel->fill([
            'profession' => $profession,
            'web' => $web,
        ]);

        $userData->store();

        return $userData;
    }
}
