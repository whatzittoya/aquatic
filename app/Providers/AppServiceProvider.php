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
                    'text'        => 'Lomba',
                    'route'       => 'races',
                    'icon'        => 'far fa-fw fa-file',
                    'can'  => 'admin',

                ],
                [
                    'text'        => 'Peserta',
                    'route'       => 'participants',
                    'icon'        => 'far fa-fw fa-file',
                    'can'  => 'admin',

                ],
                [
                    'text' => 'Event',
                    'icon' => 'far fa-fw fa-file',
                    'can'  => 'admin',
                    'submenu' => [
                        [
                            'text' => 'Daftar Event',
                            'route'  => 'events',
                            'icon' => 'user',
                        ],
                        [
                            'text' => 'Lomba Event',
                            'url'  => 'admin/event/races/all',
                            'icon' => 'user',
                        ],
                        [
                            'text' => 'Peserta',
                            'url'  => 'admin/event/participants/all',
                            'icon' => 'user',
                        ]

                    ]
                ],
                'ACCOUNT SETTINGS',

                [
                    'text' => 'Ubah Password',
                    'route' => 'change_pass',
                    'icon' => 'fas fa-fw fa-lock'
                ]

            );
        });
    }
}
