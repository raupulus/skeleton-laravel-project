<?php

namespace App;

use function asset;
use function func_get_args;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use function is_array;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Relaciones que siempre se llevarán al instanciar el modelo, esto
     * se realiza para disminuir consultas.
     *
     * Para no usar una relación:
     * $users = App\User::without(['role', 'details'])->get();
     *
     * @var array
     */
    protected $with = [
        'role',
        'social',
        'social.personal',
        'data',
        'details'
    ];

    /**
     * Atributos protegidos de asignación masiva.
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relación con el rol de usuarios
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    /**
     * Relaciona con las redes sociales a las que pertenece usando de tabla
     * pivote la tabla "users_social" para llegar a la tabla "social_networks"
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function social()
    {
        return $this->belongsToMany(SocialNetwork::class, 'users_social', 'user_id', 'social_network_id');
    }

    /**
     * Devuelve la relación con los datos principales del usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function data()
    {
        return $this->belongsTo(UserData::class, 'data_id', 'id');
    }

    /**
     * Devuelve la relación con los detalles, datos complementarios del usuario.
     */
    public function details()
    {
        return $this->belongsTo(UserDetail::class, 'detail_id', 'id');
    }


    /**
     * Devuelve el enlace hacia la imagen/avatar del usuario.
     *
     * @return string
     */
    public function getUrlImageAttribute()
    {
        if ($this->image) {
            $url = asset('storage/' . $this->image);
        } else {
            $url = asset('images/users/profile-avatars/default.png');
        }

        return $url;
    }

    public static function allActive()
    {
        return parent::all()->where('deleted_at', null);
    }

    public static function allInactive()
    {
        return parent::all()->where('deleted_at', 'not null');
    }

    /*
    public static function all($columns = ['*'])
    {
        return static::query()->get(
            is_array($columns) ? $columns : func_get_args()
        );
    }
    */
}
