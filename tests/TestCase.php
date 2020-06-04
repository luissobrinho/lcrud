<?php

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
            \Luissobrinho\LCrud\LCrudProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [];
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->withFactories(__DIR__.'/../src/Models/Factories');
        $this->artisan('migrate', [
            '--database' => 'testbench',
        ]);
        $this->artisan('vendor:publish', [
            '--provider' => 'Luissobrinho\LCrud\LCrudProvider',
            '--force' => true,
        ]);
        $this->withoutMiddleware();
        $this->withoutEvents();
    }
}
