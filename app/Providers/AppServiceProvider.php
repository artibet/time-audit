<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
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
    //
  }
}
