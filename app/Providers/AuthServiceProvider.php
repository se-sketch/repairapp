<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Nomenclature' => 'App\Policies\NomenclaturePolicy',
        'App\Models\Subdivision' => 'App\Policies\SubdivisionPolicy',
        'App\Models\ObjectRepair' => 'App\Policies\ObjectRepairPolicy',
        'App\Models\ReceiptOfMaterial' => 'App\Policies\ReceiptOfMaterialPolicy',
        'App\Models\WriteOffOfMaterial' => 'App\Policies\WriteOffOfMaterialPolicy',
        'App\Models\OrderMaterial' => 'App\Policies\OrderMaterialPolicy',
        //'App\Models\' => 'App\Policies\Policy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $arr_users_adm = [
            'thetestproton@protonmail.com',
            'krutko_av@tellur.com.ua',
        ];

        Gate::define('user-settings', function ($user) use ($arr_users_adm) {

            return in_array($user->email, $arr_users_adm);
            
        });        

        Gate::define('nomenclature-settings', function ($user) use ($arr_users_adm) {
            
            return $user->hasRole('admin');
        });

        Gate::define('subdivision-settings', function ($user) {

            return $user->hasRole('admin');
        });

        Gate::define('object-repair-settings', function ($user) {

            return $user->hasRole('mechanic');
        });
    
        Gate::define('receipt-of-material-settings', function ($user) {

            return $user->hasRole('mechanic');
        });

        Gate::define('write-off-of-material-settings', function ($user) {

            return $user->hasRole('mechanic');

        });

        Gate::define('order-material-settings', function ($user) {

            return $user->hasRole('mechanic');
        });

    }
}
