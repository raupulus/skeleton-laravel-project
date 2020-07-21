<?php

use App\SocialNetwork;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

/**
 * Class SocialNetworksTableSeeder
 *
 * Inserta datos en la tabla de redes sociales con las principales más usadas.
 */
class SocialNetworksTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'social_networks';

        $timestamp = Carbon::now();

        ## Facebook
        SocialNetwork::firstOrCreate([
            'name' => 'Facebook',
            'slug' => 'facebook',
            'type' => 'Red Social',
            'color' => '#3b5998',
            'url' => 'https://www.facebook.com/',
            'icon' => 'fa fa-facebook',
            'image' => 'images/icon/social-network/facebook.png',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        ## Twitter
        SocialNetwork::firstOrCreate([
            'name' => 'Twitter',
            'slug' => 'twitter',
            'type' => 'Red Social',
            'color' => '#1DA1F2',
            'url' => 'https://www.twitter.com/',
            'icon' => 'fa fa-twitter',
            'image' => 'images/icon/social-network/twitter.png',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        ## Instagram
        SocialNetwork::firstOrCreate([
            'name' => 'Instagram',
            'slug' => 'instagram',
            'type' => 'Red Social',
            'color' => '#bc2a8d',
            'url' => 'https://www.instagram.com/',
            'icon' => 'fa fa-instagram',
            'image' => 'images/icon/social-network/instagram.png',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
    }
}
