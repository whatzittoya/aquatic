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
                    'url'       => 'admin/home/all',
                    'icon'        => 'far fa-fw fa-file',
                    'can'  => 'manage-member',

                ],
                [
                    'text'        => 'Member',
                    'route'       => 'members',
                    'icon'        => 'far fa-fw fa-file',
                    'can'  => 'manage-member',

                ],
                [
                    'text'        => 'Klub',
                    'route'       => 'clubs',
                    'icon'        => 'far fa-fw fa-file',
                    'can'  => 'admin',

                ],

                [
                    'text'        => 'Rule',
                    'route'       => 'rules',
                    'icon'        => 'far fa-fw fa-file',
                    'can'  => 'admin',

                ],

                [
                    'text' => 'Event',
                    'icon' => 'far fa-fw fa-file',

                    'submenu' => [
                        [
                            'text' => 'Daftar Event',
                            'route'  => 'events',
                            'icon' => 'user',
                            'can'  => 'admin',
                        ],
                        [
                            'text' => 'Lomba Event',
                            'url'  => 'admin/event/races/all',
                            'icon' => 'user',
                            'can'  => 'admin',
                        ],
                        [
                            'text' => 'Peserta',
                            'url'  => 'admin/event/participants/all',
                            'icon' => 'user',
                            'can'  => 'manage-member',
                        ],
                        [
                            'text' => 'Hasil Pertandingan',
                            'url'  => 'admin/event/matches/all',
                            'icon' => 'user',
                            'can'  => 'admin',
                        ]

                    ]
                ],

                [
                    'text' => 'Starting List',
                    'route'       => 'starting_list',
                    'icon' => 'far fa-fw fa-file',
                    'can'  => 'admin',
                ],
                [
                    'text' => 'Pembayaran',
                    'route'       => 'payment',
                    'icon' => 'far fa-fw fa-file',
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
                    'icon' => 'fas fa-fw fa-user',
                    'can'  => 'club'
                ]

            );
        });
    }
}
