<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;


use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\EloquentUserProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //return 'sadasda';
        // Validator::extend('cedula_ec', function ($attribute, $value, $parameters, $validator) {
        //     return $this->validateCedulaEcuador($value);
        // });

        // Validator::extend('greater_than_or_equal_field', function ($attribute, $value, $parameters, $validator) {
        //     $otherField = $parameters[0];
        //     return $value >= $validator->getData()[$otherField];
        // });

        Model::unguard();
    }



    public function validateCedulaEcuador($value)
     {
         if (strlen($value) !== 10) {
             return false;
         }

         $coeficients = [2, 1, 2, 1, 2, 1, 2, 1, 2];
         $sum = 0;

         for ($i = 0; $i < 9; $i++) {
             $result = $value[$i] * $coeficients[$i];
             $sum += $result > 9 ? $result - 9 : $result;
         }

         $lastDigit = intval(substr($value, -1));
         $calculatedLastDigit = ($sum + $lastDigit) % 10 === 0 ? 0 : 10 - (($sum + $lastDigit) % 10);

         return $lastDigit === $calculatedLastDigit;
     }
}
