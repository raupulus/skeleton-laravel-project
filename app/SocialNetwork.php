<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model
{
    protected $table = 'social_networks';

    protected $with = [
        'personal',
    ];

    /**
     * Relaciona con los datos personales del usuario para una red social.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personal()
    {
        return $this->hasOne(UserSocial::class, 'social_network_id', 'id');
    }
}
