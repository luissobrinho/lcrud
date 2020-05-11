<?php

use Illuminate\Support\Facades\File;

class TestCase extends Orchestra\Testbench\TestCase
{
    protected $app;

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app->make('Illuminate\Contracts\Http\Kernel');
    }

    protected function getPackageProviders($app)
    {
        return [
            \Luissobrinho\LForm\LFormProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Form' => \Collective\Html\FormFacade::class,
            'HTML' => \Collective\Html\HtmlFacade::class,
            'LForm' => \Luissobrinho\LForm\Facades\LForm::class,
            'InputMaker' => \Luissobrinho\LForm\Facades\InputMaker::class,
        ];
    }

    public function setUp()
    {
        parent::setUp();

        $destinationDir = realpath(__DIR__.'/../vendor/orchestra/testbench-core/laravel/database/migrations');
        File::copyDirectory(realpath(__DIR__.'/migrations'), $destinationDir);

        $this->artisan('migrate', [
            '--database' => 'testbench',
        ]);

        $this->withoutMiddleware();
        $this->withoutEvents();
    }
}
