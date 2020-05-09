<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserData extends DefaultModel
{
    protected $table = 'users_data';

    /**
     * Añade o edita los datos de usuario para el usuario recibido.
     */
    public static function addEdit($userDataModel, $request)
    {
        $phone = $request->get('phone') ?? null;
        $description = $request->get('description') ?? null;
        $bio = $request->get('bio');

        $userData = $userDataModel->fill([
            'phone' => $phone,
            'description' => $description,
            'bio' => $bio,
        ]);

        $userData->store();

        return $userData;
    }
}
