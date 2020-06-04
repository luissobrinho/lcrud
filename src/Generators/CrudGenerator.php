<?php

namespace Luissobrinho\LCrud\Generators;

use Illuminate\Filesystem\Filesystem;
use Luissobrinho\LCrud\Services\FileService;
use Luissobrinho\LCrud\Services\ModelService;
use Luissobrinho\LCrud\Services\TableService;
use Luissobrinho\LCrud\Services\TestService;

/**
 * Generate the CRUD.
 */
class CrudGenerator
{
    /**
     * Filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * FileService instance.
     *
     * @var FileService
     */
    protected $fileService;

    /**
     * TableService instance.
     *
     * @var TableService
     */
    protected $tableService;

    /**
     * TestService instance.
     *
     * @var TestService
     */
    protected $testService;

    /**
     * ModelService instance.
     *
     * @var ModelService
     */
    protected $modelService;

    /**
     * Create new CrudGenerator instance.
     */
    public function __construct()
    {
        $this->filesystem = new Filesystem();
        $this->fileService = new FileService();
        $this->tableService = new TableService();
        $this->testService = new TestService();
        $this->modelService = new ModelService();
    }

    /**
     * Create the controller.
     *
     * @param array $config
     *
     * @return bool
     */
    public function createController($config)
    {
        $this->fileService->mkdir($config['_path_controller_'], 0777, true);

        $request = $this->fileService->get($config['template_source'].'/Controller.txt');

        foreach ($config as $key => $value) {
            $request = str_replace($key, $value, $request);
        }

        $request = $this->putIfNotExists($config['_path_controller_'].'/'.$config['_ucCamel_casePlural_'].'Controller.php', $request);

        return $request;
    }

    /**
     * Create the model.
     *
     * @param array $config
     *
     * @return bool
     */
    public function createModel($config)
    {
        $repoParts = [
            '_path_model_',
        ];

        foreach ($repoParts as $repoPart) {
            $this->fileService->mkdir($config[$repoPart], 0777, true);
        }

        $model = $this->fileService->get($config['template_source'].'/Model.txt');
        $model = $this->modelService->configTheModel($config, $model);

        foreach ($config as $key => $value) {
            $model = str_replace($key, $value, $model);
        }

        $model = $this->putIfNotExists($config['_path_model_'].'/'.$config['_camel_case_'].'.php', $model);

        return $model;
    }

    /**
     * Create the request.
     *
     * @param array $config
     *
     * @return bool
     */
    public function createRequest($config)
    {
        $this->fileService->mkdir($config['_path_request_'], 0777, true);

        $createRequest = $this->fileService->get($config['template_source'].'/CreateRequest.txt');
        $updateRequest = $this->fileService->get($config['template_source'].'/UpdateRequest.txt');

        foreach ($config as $key => $value) {
            $createRequest = str_replace($key, $value, $createRequest);
            $updateRequest = str_replace($key, $value, $updateRequest);
        }

        $createRequest = $this->putIfNotExists($config['_path_request_'].'/'.$config['_camel_case_'].'CreateRequest.php', $createRequest);
        $updateRequest = $this->putIfNotExists($config['_path_request_'].'/'.$config['_camel_case_'].'UpdateRequest.php', $updateRequest);

        return $createRequest;
    }

    /**
     * Create the service.
     *
     * @param array $config
     *
     * @return bool
     */
    public function createService($config)
    {
        $this->fileService->mkdir($config['_path_service_'], 0777, true);

        $service = $this->fileService->get($config['template_source'].'/Service.txt');

        if ($config['options-withBaseService'] ?? false) {
            $baseService = $this->fileService->get($config['template_source'].'/BaseService.txt');
            $service = $this->fileService->get($config['template_source'].'/ExtendedService.txt');
        }

        foreach ($config as $key => $value) {
            $service = str_replace($key, $value, $service);
            if ($config['options-withBaseService'] ?? false) {
                $baseService = str_replace($key, $value, $baseService);
            }
        }

        $service = $this->putIfNotExists($config['_path_service_'].'/'.$config['_camel_case_'].'Service.php', $service);

        if ($config['options-withBaseService'] ?? false) {
            $this->putIfNotExists($config['_path_service_'].'/BaseService.php', $baseService);
        }

        return $service;
    }

    /**
     * Create the routes.
     *
     * @param array $config
     *
     * @return bool
     */
    public function createRoutes($config)
    {
        $routesMaster = $config['_path_routes_'];

        if (!empty($config['routes_prefix'])) {
            $this->filesystem->append($routesMaster, $config['routes_prefix']);
        }

        $routes = $this->fileService->get($config['template_source'].'/Routes.txt');

        foreach ($config as $key => $value) {
            $routes = str_replace($key, $value, $routes);
        }

        $this->filesystem->append($routesMaster, $routes);

        if (!empty($config['routes_prefix'])) {
            $this->filesystem->append($routesMaster, $config['routes_suffix']);
        }

        return true;
    }

    /**
     * Append to the factory.
     *
     * @param array $config
     *
     * @return bool
     */
    public function createFactory($config)
    {
        $this->fileService->mkdir(dirname($config['_path_factory_']), 0777, true);

        if (!file_exists($config['_path_factory_'])) {
            $this->putIfNotExists($config['_path_factory_'], '<?php');
        }

        $factory = $this->fileService->get($config['template_source'].'/Factory.txt');

        $factory = $this->tableService->getTableSchema($config, $factory);

        foreach ($config as $key => $value) {
            $factory = str_replace($key, $value, $factory);
        }

        return $this->filesystem->append($config['_path_factory_'], $factory);
    }

    /**
     * Create the facade.
     *
     * @param array $config
     *
     * @return bool
     */
    public function createFacade($config)
    {
        $this->fileService->mkdir($config['_path_facade_'], 0777, true);

        $facade = $this->fileService->get($config['template_source'].'/Facade.txt');

        foreach ($config as $key => $value) {
            $facade = str_replace($key, $value, $facade);
        }

        $facade = $this->putIfNotExists($config['_path_facade_'].'/'.$config['_camel_case_'].'.php', $facade);

        return $facade;
    }

    /**
     * Create a service provider.
     *
     * @param array $config
     *
     * @return bool
     */
    public function generatePackageServiceProvider($config)
    {
        $provider = $this->fileService->get(__DIR__.'/../Templates/Provider.txt');

        foreach ($config as $key => $value) {
            $provider = str_replace($key, $value, $provider);
        }

        $provider = $this->putIfNotExists($config['_path_package_'].'/'.$config['_camel_case_'].'ServiceProvider.php', $provider);

        return $provider;
    }

    /**
     * Create the tests.
     *
     * @param array        $config
     * @param bool $serviceOnly
     * @param bool $apiOnly
     * @param bool $withApi
     *
     * @return bool
     */
    public function createTests($config, $serviceOnly = false, $apiOnly = false, $withApi = false)
    {
        $testTemplates = $this->filesystem->allFiles($config['template_source'].'/Tests');

        $filteredTestTemplates = $this->testService->filterTestTemplates($testTemplates, $serviceOnly, $apiOnly, $withApi);

        foreach ($filteredTestTemplates as $testTemplate) {
            $test = $this->fileService->get($testTemplate->getRealPath());
            $testName = $config['_camel_case_'].$testTemplate->getBasename('.'.$testTemplate->getExtension());
            $testDirectory = $config['_path_tests_'].'/'.$testTemplate->getRelativePath();

            $this->fileService->mkdir($testDirectory, 0777, true);

            $test = $this->tableService->getTableSchema($config, $test);

            foreach ($config as $key => $value) {
                $test = str_replace($key, $value, $test);
            }

            if (!$this->putIfNotExists($testDirectory.'/'.$testName.'.php', $test)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Create the views.
     *
     * @param array $config
     *
     * @return bool
     */
    public function createViews($config)
    {
        $this->fileService->mkdir($config['_path_views_'].'/'.$config['_lower_casePlural_'], 0777, true);

        $viewTemplates = 'Views';

        if ($config['bootstrap']) {
            $viewTemplates = 'BootstrapViews';
        }

        if ($config['semantic']) {
            $viewTemplates = 'SemanticViews';
        }

        $createdView = false;

        foreach (glob($config['template_source'].'/'.$viewTemplates.'/*') as $file) {
            $viewContents = $this->fileService->get($file);
            $basename = str_replace('txt', 'php', basename($file));
            foreach ($config as $key => $value) {
                $viewContents = str_replace($key, $value, $viewContents);
            }
            $createdView = $this->putIfNotExists($config['_path_views_'].'/'.$config['_lower_casePlural_'].'/'.$basename, $viewContents);
        }

        return $createdView;
    }

    /**
     * Create the Api.
     *
     * @param array $config
     *
     * @return bool
     */
    public function createApi($config)
    {
        $routesMaster = $config['_path_api_routes_'];

        if (!file_exists($routesMaster)) {
            $this->putIfNotExists($routesMaster, "<?php\n\n");
        }

        $this->fileService->mkdir($config['_path_api_controller_'], 0777, true);

        $routes = $this->fileService->get($config['template_source'].'/ApiRoutes.txt');

        foreach ($config as $key => $value) {
            $routes = str_replace($key, $value, $routes);
        }

        $this->filesystem->append($routesMaster, $routes);

        $request = $this->fileService->get($config['template_source'].'/ApiController.txt');

        foreach ($config as $key => $value) {
            $request = str_replace($key, $value, $request);
        }

        $request = $this->putIfNotExists($config['_path_api_controller_'].'/'.$config['_ucCamel_casePlural_'].'Controller.php', $request);

        return $request;
    }

    /**
     * Make a file if it doesnt exist.
     *
     * @param string $file
     * @param mixed $contents
     *
     * @return bool|int|string
     */
    public function putIfNotExists($file, $contents)
    {
        if (!$this->filesystem->exists($file)) {
            return $this->filesystem->put($file, $contents);
        }

        return $this->fileService->get($file);
    }
}
