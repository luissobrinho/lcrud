<?php

use Luissobrinho\LCrud\Services\ModelService;

class ModelServiceTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = app(ModelService::class);
    }

    public function testPrepareModelRelationships()
    {
        $relationships = [
            ['hasOne','App\Author','author']
        ];
        $result = $this->service->prepareModelRelationships($relationships);

        $this->assertContains('this->hasOne', $result);
        $this->assertContains('App\Author', $result);
        $this->assertContains('author()', $result);
    }
}
