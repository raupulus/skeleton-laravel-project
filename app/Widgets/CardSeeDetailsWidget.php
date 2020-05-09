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
class CardSeeDetailsWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'titleUrl' => 'Ver detalles',
        'color' => 'bg-primary',
        'class' => '',
        'id' => '',
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        return view('widgets.card_see_details', [
            'config' => $this->config,
            'title' => $this->config['title'],
            'icon' => $this->config['icon'],
            'titleUrl' => $this->config['titleUrl'],
            'url' => $this->config['url'],
            'color' => $this->config['color'],
            'class' => $this->config['class'],
            'id' => $this->config['id'],
        ]);
    }
}
