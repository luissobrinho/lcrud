<?php

namespace Tests\Services;

use Luissobrinho\LCrud\Services\AppService;
use Tests\TestCase;

class AppServiceTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = app(AppService::class);
    }

    public function testGetAppNamespace()
    {
        $result = $this->service->getAppNamespace();
        $this->assertEquals($result, 'App\\');
    }
}
