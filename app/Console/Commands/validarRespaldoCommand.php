<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\periocidadRespaldosController;

class validarRespaldoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'validate:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Valida Backup del dia corriente';

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

        $d->validate_back_currentDay();
    }
}
