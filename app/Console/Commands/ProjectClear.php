<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProjectClear extends Command
{
    protected $signature = 'project:clear';

    protected $description = 'Limpia toda la caché del proyecto';

    public function handle(): int
    {
        $this->info('=== Limpiando caché ===');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('event:clear');
        $this->call('cache:clear');
        $this->call('optimize:clear');
        $this->info('=== Caché limpiada ===');

        return Command::SUCCESS;
    }
}
