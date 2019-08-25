<?php

namespace App;

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
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'nick',
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

    /*
    public static function all($columns = ['*'])
    {
        return static::query()->get(
            is_array($columns) ? $columns : func_get_args()
        );
    }
    */
}
