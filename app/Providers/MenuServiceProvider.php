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
        if ($this->app->bound('larakuy.backend.menu')) {
            //
            $menuDashboard = $this->app['larakuy.backend.menu']
                ->add(trans('Dashboard'), url('dashboard'))
                ->data('icon', 'fa-dashboard')
                ->data('id', 'larakuy-dashboard');   
            $menuPermitsControl = $this->app['larakuy.backend.menu']
                ->add(trans('Permits Control'))
                ->data('icon', 'fa-thumbs-o-up ')
                ->data('id', 'larakuy-permitsControl');
            $menuPermitsControl->add(trans('Tabel Data'), url('/permitsControl'))->data('icon', 'fa-table');
            $menuPermitsControl->add(trans('Tambah Data'), url('/permitsControl/tambah'))->data('icon', 'fa-edit');
            $menuMouControl = $this->app['larakuy.backend.menu']
                ->add(trans('MOU Control'))
                ->data('icon', 'fa-handshake-o')
                ->data('id', 'larakuy-mouControl');    
            $menuMouControl->add(trans('Tabel Data'), url('/mouControl'))->data('icon', 'fa-table');
            $menuMouControl->add(trans('Tambah Data'), url('/mouControl/tambah'))->data('icon', 'fa-edit');
            $menuTruckPermits = $this->app['larakuy.backend.menu']
                ->add(trans('Truck Permits Control'))
                ->data('icon', 'fa-truck')
                ->data('id', 'larakuy-truckPermitsControl');
            $menuTruckPermits->add(trans('Tabel Data'), url('/truckPermits'))->data('icon', 'fa-table');
            $menuTruckPermits->add(trans('Tambah Data'), url('/truckPermits/tambah'))->data('icon', 'fa-edit');
            $menuManifestControl = $this->app['larakuy.backend.menu']
                ->add(trans('Manifest Control'), url('manifestControl'))
                ->data('icon', 'fa-clipboard')
                ->data('id', 'larakuy-manifestControl');   
            $menuPenyimpananLimbah = $this->app['larakuy.backend.menu']
                ->add(trans('Penyimpanan Limbah'))
                ->data('icon', 'fa-book')
                ->data('id', 'larakuy-dashboard');
            $menuPenyimpananLimbah->add(trans('Tabel Data'), url('/penyimpananLimbahB3'))->data('icon', 'fa-table');
            $menuPenyimpananLimbah->add(trans('Tambah Data'), url('/penyimpananLimbahB3/tambah'))->data('icon', 'fa-save');
            $menuPengangkutanLimbah = $this->app['larakuy.backend.menu']
            ->add(trans('Pengangkutan Limbah'))
            ->data('icon', 'fa-book')
            ->data('id', 'larakuy-dashboard');
            $menuPengangkutanLimbah->add(trans('Tabel Data'), url('/pengangkutanLimbahB3'))->data('icon', 'fa-table');    
            $menuPengangkutanLimbah->add(trans('Tambah Data'), url('/pengangkutanLimbahB3/tambah'))->data('icon', 'fa-truck');

            $menuPenggguna = $this->app['larakuy.backend.menu']
            ->add(trans('Manajemen Pengguna'))
            ->data('icon', 'fa-user')
            ->data('id', 'larakuy-user');
            $menuPenggguna->add(trans('Tabel Data'), url('/'))->data('icon', 'fa-table');    
            $menuPenggguna->add(trans('Tambah Data'), url('/user/tambah'))->data('icon', 'fa-user');
            // $menuMulti = $this->app['larakuy.backend.menu']
            //     ->add(trans('Multi Level'))s
            //     ->data('icon', 'fa-link')
            //     ->data('id', 'larakuy-multi');    
            // $menuMulti->add(trans('About'), url('about'))->data('icon', 'fa-circle');
            // $menuMulti->add(trans('About2'), url('about2'))->data('icon', 'fa-circle');
        }

        if ($this->app->bound('larakuy.user.menu')) {
            //
            $menuDashboard = $this->app['larakuy.user.menu']
                ->add(trans('Dashboard'), url('dashboard'))
                ->data('icon', 'fa-dashboard')
                ->data('id', 'larakuy-dashboard');   
            $menuPermitsControl = $this->app['larakuy.user.menu']
                ->add(trans('Permits Control'))
                ->data('icon', 'fa-thumbs-o-up ')
                ->data('id', 'larakuy-permitsControl');
            $menuPermitsControl->add(trans('Tabel Data'), url('permitsControl'))->data('icon', 'fa-table');
            $menuPermitsControl->add(trans('Tambah Data'), url('permitsControl/tambah'))->data('icon', 'fa-edit');
            $menuMouControl = $this->app['larakuy.user.menu']
                ->add(trans('MOU Control'))
                ->data('icon', 'fa-handshake-o')
                ->data('id', 'larakuy-mouControl');    
            $menuMouControl->add(trans('Tabel Data'), url('mouControl'))->data('icon', 'fa-table');
            $menuMouControl->add(trans('Tambah Data'), url('mouControl/tambah'))->data('icon', 'fa-edit');
            $menuTruckPermits = $this->app['larakuy.user.menu']
                ->add(trans('Truck Permits Control'))
                ->data('icon', 'fa-truck')
                ->data('id', 'larakuy-truckPermitsControl');
            $menuTruckPermits->add(trans('Tabel Data'), url('truckPermits'))->data('icon', 'fa-table');
            $menuTruckPermits->add(trans('Tambah Data'), url('truckPermits/tambah'))->data('icon', 'fa-edit');
            $menuManifestControl = $this->app['larakuy.user.menu']
                ->add(trans('Manifest Control'), url('manifestControl'))
                ->data('icon', 'fa-clipboard')
                ->data('id', 'larakuy-manifestControl');   
            $menuPenyimpananLimbah = $this->app['larakuy.user.menu']
                ->add(trans('Penyimpanan Limbah'))
                ->data('icon', 'fa-book')
                ->data('id', 'larakuy-dashboard');
            $menuPenyimpananLimbah->add(trans('Tabel Data'), url('penyimpananLimbahB3'))->data('icon', 'fa-table');
            $menuPenyimpananLimbah->add(trans('Tambah Data'), url('penyimpananLimbahB3/tambah'))->data('icon', 'fa-save');
            $menuPengangkutanLimbah = $this->app['larakuy.user.menu']
            ->add(trans('Pengangkutan Limbah'))
            ->data('icon', 'fa-book')
            ->data('id', 'larakuy-dashboard');
            $menuPengangkutanLimbah->add(trans('Tabel Data'), url('pengangkutanLimbahB3'))->data('icon', 'fa-table');    
            $menuPengangkutanLimbah->add(trans('Tambah Data'), url('pengangkutanLimbahB3/tambah'))->data('icon', 'fa-truck');
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

        $this->app->singleton('larakuy.user.menu', function(Application $app){
            return (new Menu())->make('sidebar', function(Builder $menu){
                return $menu;
            });
        });

    }
}
