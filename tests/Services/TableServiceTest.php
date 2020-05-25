<?php

use Illuminate\Support\Str;
use org\bovigo\vfs\vfsStream;
use Luissobrinho\LCrud\Services\TableService;

class TableServiceTest extends TestCase
{
    protected $service;
    protected $config;

    public function setUp(): void
    {
        $this->service = new TableService();
        $this->config = [
            'bootstrap' => false,
            'semantic' => false,
            'relationships' => null,
            'schema' => null,
            '_path_facade_' => vfsStream::url('Facades'),
            '_path_service_' => vfsStream::url('Services'),
            '_path_repository_' => vfsStream::url('Repositories/'.ucfirst('testTable')),
            '_path_model_' => vfsStream::url('Repositories/'.ucfirst('testTable')),
            '_path_controller_' => vfsStream::url('Http/Controllers'),
            '_path_api_controller_' => vfsStream::url('Http/Controllers/Api'),
            '_path_views_' => vfsStream::url('resources/views'),
            '_path_tests_' => vfsStream::url('tests'),
            '_path_request_' => vfsStream::url('Http/Requests'),
            '_path_routes_' => vfsStream::url('Http/routes.php'),
            '_path_api_routes_' => vfsStream::url('Http/api-routes.php'),
            'routes_prefix' => '',
            'routes_suffix' => '',
            '_namespace_services_' => 'App\Services',
            '_namespace_facade_' => 'App\Facades',
            '_namespace_repository_' => 'App\Repositories\\'.ucfirst('testTable'),
            '_namespace_model_' => 'App\Repositories\\'.ucfirst('testTable'),
            '_namespace_controller_' => 'App\Http\Controllers',
            '_namespace_api_controller_' => 'App\Http\Controllers\Api',
            '_namespace_request_' => 'App\Http\Requests',
            '_lower_case_' => strtolower('testTable'),
            '_lower_casePlural_' => Str::plural(strtolower('testTable')),
            '_camel_case_' => ucfirst(Str::camel('testTable')),
            '_camel_casePlural_' => Str::plural(Str::camel('testTable')),
            'template_source' => __DIR__.'/../src/Templates/Laravel',
        ];
    }

    public function testPrepareTableDefinition()
    {
        $table = 'id:increments,name:string,details:text';

        $result = $this->service->prepareTableDefinition($table);

        $this->assertContains('id', $result);
        $this->assertContains('name', $result);
        $this->assertContains('details', $result);
    }

    public function testPrepareTableExample()
    {
        $table = 'id:increments,name:string,details:text,created_on:dateTime';

        $result = $this->service->prepareTableExample($table);

        $this->assertContains('name', $result);
        $this->assertContains('details', $result);
        $this->assertContains('1', $result);
    }
}
