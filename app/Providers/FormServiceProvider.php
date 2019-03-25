<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Form;

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
        Form::component('inputBlock', 'components.forms.input_block', ['resource', 'name', 'niceName', 'attributes' => []]);
        Form::component('textareaBlock', 'components.forms.textarea_block', ['resource', 'name', 'niceName', 'attributes' => []]);
        Form::component('passwordBlock', 'components.forms.password_block', ['resource', 'name', 'niceName', 'attributes' => []]);
        Form::component('fileBlock', 'components.forms.file_block', ['resource', 'name', 'niceName', 'attributes' => []]);
    }
}
