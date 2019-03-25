<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Form::component('inputBlock', 'components.form.input_block', ['resource', 'name', 'niceName', 'attributes' => []]);
        Form::component('textareaBlock', 'components.form.textarea_block', ['resource', 'name', 'niceName', 'attributes' => []]);
    }
}
