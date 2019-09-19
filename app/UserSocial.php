<?php

namespace App;

/**
 * Class UserSocial
 * Representa cada una de las redes sociales que dispone un usuario.
 * @package App
 */
class UserSocial extends DefaultModel
{
    protected $table = 'users_social';

    /**
     * Guarda las redes sociales por usuario, si las tuviera las elimina y
     * añade las nuevas.
     *
     * @param $array Recibe un array con tres array para ids, nicks, urls
     * @param $user_id
     *
     * @return array
     */
    public static function saveAllForUser($array, $user_id)
    {
        $arraySocial_id = $array['social_id'];
        $arraySocial_nick = $array['social_nick'];
        $arraySocial_url = $array['social_url'];

        ## Elimino todas las redes sociales anteriores.
        $deleteOld = self::where('user_id', $user_id)->delete();

        ## Almacena en el array las instancias guardadas para devolverlas.
        $socialNetworks = [];

        ## Proceso el guardado de cada una de las redes sociales.
        foreach ($arraySocial_id as $idx => $social_network_id) {
            $nick = $arraySocial_nick[$idx];
            $url = $arraySocial_url[$idx];

            ## Compruebo y obligo a que tenga $nick y $url
            if ($nick && $url) {
                $newSocial = self::create([
                    'user_id' => $user_id,
                    'social_network_id' => $social_network_id,
                    'nick' => $nick,
                    'url' => $url,
                ]);

                $newSocial->save();

                $socialNetworks[] = $newSocial;
            }
        }

        return $socialNetworks;
    }
}
