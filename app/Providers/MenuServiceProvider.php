<?php

namespace App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Lavary\Menu\Builder;
use App\Classes\Menu;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if ($this->app->bound('larakuy.backend.menu')) {
            $menuDashboard = $this->app['larakuy.backend.menu']
                ->add(trans('Dashboard'), url('backend/dashboard'))
                ->data('icon', 'fa-dashboard')
                ->data('id', 'larakuy-dashboard');   
            $menuPermitsControl = $this->app['larakuy.backend.menu']
                ->add(trans('Permits Control'))
                ->data('icon', 'fa-thumbs-o-up ')
                ->data('id', 'larakuy-permitsControl');    
            $menuPermitsControl->add(trans('Form Isian'), url('backend/permitsControl/tambah'))->data('icon', 'fa-edit');
            $menuPermitsControl->add(trans('Tabel Data'), url('backend/permitsControl'))->data('icon', 'fa-table');
            // $menuMouControl = $this->app['larakuy.backend.menu']
                // ->add(trans('MOU Control'))
                // ->data('icon', 'fa-handshake-o')
                // ->data('id', 'larakuy-mouControl');    
            // $menuMouControl->add(trans('Form Isian'), url('backend/permitsControl'))->data('icon', 'fa-edit');
            // $menuMouControl->add(trans('Tabel Data'), url('backend/permitsControl'))->data('icon', 'fa-table');
            $menuTruckPermits = $this->app['larakuy.backend.menu']
                ->add(trans('Truck Permits Control'))
                ->data('icon', 'fa-truck')
                ->data('id', 'larakuy-truckPermitsControl');
            $menuTruckPermits->add(trans('Tabel Data'), url('backend/truckPermits'))->data('icon', 'fa-table');
            $menuTruckPermits->add(trans('Tambah Data Truck'), url('backend/truckPermits/tambah'))->data('icon', 'fa-edit');
            $menuManifestControl = $this->app['larakuy.backend.menu']
                ->add(trans('Manifest Control'), url('backend/manifestControl'))
                ->data('icon', 'fa-clipboard')
                ->data('id', 'larakuy-manifestControl');   
            $menuPenyimpananLimbah = $this->app['larakuy.backend.menu']
                ->add(trans('Penyimpanan Limbah'))
                ->data('icon', 'fa-book')
                ->data('id', 'larakuy-dashboard');
            $menuPenyimpananLimbah->add(trans('Tabel Data'), url('backend/penyimpananLimbahB3'))->data('icon', 'fa-table');
            $menuPenyimpananLimbah->add(trans('Tambah Data'), url('backend/penyimpananLimbahB3/tambah'))->data('icon', 'fa-save');
            $menuPengangkutanLimbah = $this->app['larakuy.backend.menu']
            ->add(trans('Pengangkutan Limbah'))
            ->data('icon', 'fa-book')
            ->data('id', 'larakuy-dashboard');
            $menuPengangkutanLimbah->add(trans('Tabel Data'), url('backend/pengangkutanLimbahB3'))->data('icon', 'fa-table');    
            $menuPengangkutanLimbah->add(trans('Tambah Data'), url('backend/pengangkutanLimbahB3/tambah'))->data('icon', 'fa-truck');
            // $menuMulti = $this->app['larakuy.backend.menu']
            //     ->add(trans('Multi Level'))s
            //     ->data('icon', 'fa-link')
            //     ->data('id', 'larakuy-multi');    
            // $menuMulti->add(trans('About'), url('backend/about'))->data('icon', 'fa-circle');
            // $menuMulti->add(trans('About2'), url('backend/about2'))->data('icon', 'fa-circle');
        }

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('larakuy.backend.menu', function(Application $app){
            return (new Menu())->make('sidebar', function(Builder $menu){
                return $menu;
            });
        });
    }
}
