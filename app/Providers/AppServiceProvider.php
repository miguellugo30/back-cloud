<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\Facades\Schema;
/**
 * Modelos
 */
use App\Models\Empresas;

class AppServiceProvider extends ServiceProvider
{
    private $empresas;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events, Empresas $empresas)
    {
        Schema::defaultStringLength(191);

        $this->empresas = $empresas;

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

            $dataEmpresas = $this->empresas::active()->get();

            $event->menu->add('Listado de Empresas');
            foreach ($dataEmpresas as $e) {
                $event->menu->add([
                    'text' => $e->razon_social,
                    'can' => "view_empresa_".$e->id,
                    'url' => '#',
                    'classes' => 'menu_empresas',
                    'data' => [ 'empresa_id' => $e->id, 'empresa_nombre' => $e->razon_social, 'empresa_ruta' => $e->url_respaldo ],
                ]);
            }

        });
    }
}
