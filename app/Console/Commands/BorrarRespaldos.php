<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\periocidadRespaldosController;

class BorrarRespaldos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sort:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ordenar de respaldos de las empresa con base a la configuración';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $d = new periocidadRespaldosController();

        $d->index();
    }
}
