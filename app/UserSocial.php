<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function dd;

class UserSocial extends Model
{
    protected $table = 'users_social';

    /**
     * Guarda las redes sociales por usuario, si las tuviera las elimina y
     * añade las nuevas.
     *
     * @param $socialNetwork Recibe un array con tres array para ids, nicks, urls
     */
    public static function saveAllForUser($array, $user_id)
    {
        $arraySocial_id = $array['social_id'];
        $arraySocial_nick = $array['social_nick'];
        $arraySocial_url = $array['social_url'];

        $socialNetworks = [];

        foreach ($arraySocial_id as $idx => $id) {
            $social_id = $id;
            $social_nick = $arraySocial_nick[$idx];
            $social_url = $arraySocial_url[$idx];

            if ($social_id && $social_nick && $social_url) {
                $newSocial = self::create([
                    'user_id' => $user_id,
                    'social_network' => $id,
                    'social_nick' => $social_nick,
                    'social_url' => $social_url,
                ])->save();

                $socialNetworkData[] = $newSocial;
            }
        }

        return $socialNetworks;
    }
}
