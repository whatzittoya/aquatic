<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\FailedJob;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
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
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add(
                'MENU',
                [
                    'text'        => 'Home - Live Result',
                    'url'       => 'admin/home',
                    'icon'        => 'fas fa-home',
                    'can'  => 'manage-member',

                ],
                [
                    'text'        => 'Member',
                    'route'       => 'members',
                    'icon'        => 'fas fa-users',
                    'can'  => 'manage-member',

                ],
                [
                    'text'        => 'Klub',
                    'route'       => 'clubs',
                    'icon'        => 'fas fa-building',
                    'can'  => 'admin',

                ],
                [
                    'text'        => 'Lomba',
                    'route'       => 'races',
                    'icon'        => 'fas fa-swimmer',
                    'can'  => 'admin',

                ],
                [
                    'text'        => 'Rule',
                    'route'       => 'rules',
                    'icon'        => 'fas fa-sort-numeric-up',
                    'can'  => 'admin',

                ],

                [
                    'text' => 'Event',
                    'icon' => 'fas fa-calendar-alt',

                    'submenu' => [
                        [
                            'text' => 'Daftar Event',
                            'route'  => 'events',
                            'icon' => 'fas fa-calendar-plus',
                            'can'  => 'admin',
                        ],
                        [
                            'text' => 'Lomba Event',
                            'url'  => 'admin/event/races/all',
                            'icon' => 'fas fa-water',
                            'can'  => 'admin',
                        ],
                        [
                            'text' => 'Peserta',
                            'url'  => 'admin/event/participants/all',
                            'icon' => 'fas fa-address-card',
                            'can'  => 'manage-member',
                        ],
                        [
                            'text' => 'Hasil Pertandingan',
                            'url'  => 'admin/event/matches/all',
                            'icon' => 'fas fa-list-ol',
                            'can'  => 'admin',
                        ]

                    ]
                ],

                [
                    'text' => 'Starting List',
                    'route'       => 'starting_list',
                    'icon' => 'fas fa-clipboard-list',
                    'can'  => 'manage-member',
                ],
                [
                    'text' => 'Pembayaran',
                    'route'       => 'payment',
                    'icon' => 'fas fa-money-bill-wave',
                    'can'  => 'manage-member',
                ],
                'ACCOUNT SETTINGS',

                [
                    'text' => 'Ubah Password',
                    'route' => 'change_pass',
                    'icon' => 'fas fa-fw fa-lock'
                ],
                [
                    'text' => 'Profil Klub',
                    'route' => 'profile',
                    'icon' => 'fas fa-cog',
                    'can'  => 'club'
                ]

            );
        });
    }
}
