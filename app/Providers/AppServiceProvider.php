<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Project;
use App\Models\Service;
use App\Models\Subscription;
use App\Models\User;
use App\Observers\CustomerObserver;
use App\Observers\InvoiceObserver;
use App\Observers\PaymentObserver;
use App\Observers\PlanObserver;
use App\Observers\ProjectObserver;
use App\Observers\ServiceObserver;
use App\Observers\SubscriptionObserver;
use App\Observers\UserObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        Project::observe(ProjectObserver::class);
        Plan::observe(PlanObserver::class);
        Customer::observe(CustomerObserver::class);
        Invoice::observe(InvoiceObserver::class);
        Payment::observe(PaymentObserver::class);
        User::observe(UserObserver::class);
        Subscription::observe(SubscriptionObserver::class);
        Service::observe(ServiceObserver::class);
    }
}
