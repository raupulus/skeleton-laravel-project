<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use function view;

/**
 * Class CardSeeDetailsWidget
 *
 * Widget para mostrar una tarjeta con poca información y un enlace
 * para llevar a la sección correspondiente y ver más detalles.
 *
 * @package App\Widgets
 */
class UserSocialSelectorWidget extends AbstractWidget{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'titleUrl' => 'Ver detalles',
        'color' => 'bg-primary',
        'social_nick' => '',
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        return view('widgets.forms.user_social_selector', [
            'config' => $this->config,
            'socialNetworks' => $this->config['socialNetworks'],
            'social_nick' => $this->config['social_nick'],
        ]);
    }
}
