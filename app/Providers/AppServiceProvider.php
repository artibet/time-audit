<?php

namespace App\Providers;

use App\Models\Employee;
use App\Models\Punch;
use App\Models\UploadFile;
use App\Models\User;
use App\Policies\EmployeePolicy;
use App\Policies\PunchPolicy;
use App\Policies\UploadFilePolicy;
use App\Policies\UserPolicy;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    JsonResource::withoutWrapping();
    $this->registerPolicies();
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    Vite::prefetch(concurrency: 3);
  }

  // ---------------------------------------------------------------------------------------
  // Register policies
  // ---------------------------------------------------------------------------------------
  private function registerPolicies(): void
  {
    Gate::policy(User::class, UserPolicy::class);
    Gate::policy(UploadFile::class, UploadFilePolicy::class);
    Gate::policy(Employee::class, EmployeePolicy::class);
    Gate::policy(Punch::class, PunchPolicy::class);
  }
}
