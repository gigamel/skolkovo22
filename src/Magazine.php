<?php

use App\Action\Core\Action as DefaultAction;
use Skolkovo22\DI\ConfigLoader;
use Skolkovo22\DI\ServiceConfigurator;
use Skolkovo22\DI\ServicesContainer;
use Skolkovo22\Http\ClientMessage;
use Skolkovo22\Http\ClientMessageInterface;
use Skolkovo22\Http\Router\Router;
use Skolkovo22\Http\Router\RoutesCollection;
use Skolkovo22\Util\Catcher;

final class Magazine
{
	/**
	 * @return void
	 */
	public function run(): void
	{   
        try {
            $this->mainProcess();
        } catch (\Throwable $e) {
            Catcher::show($e);
        }
	}
    
    /**
     * @return void
     */
    private function mainProcess(): void
    {
	    $servicesContainer = $this->loadServicesContainer();
        $request = new ClientMessage();
        
        $router = new Router($this->loadRoutes());
        $actionClassName = $router->handle($request);
        
        $this->runAction($actionClassName, $servicesContainer, $request);
    }


    /**
     * @param string $actionClassName
     * @param ServiceContainer $serviceContainer
     * @param ClientMessageInterface $request
     *
     * @return void
     */
    private function runAction(
        string $actionClassName,
        ServicesContainer $servicesContainer,
        ClientMessageInterface $request
    ): void {
        if (is_a($actionClassName, \App\Action\AbstractAction::class, true)) {
            $action = new $actionClassName($servicesContainer);
        } else {
            $action = new $actionClassName();
        }
        
        $response = $action($request);
        
        echo $response->getContent();
    }

    /**
	 * @return ServicesContainer
     *
     * @throws \RuntimeException
	 */
	private function loadServicesContainer(): ServicesContainer
	{
        $loader = new ConfigLoader(__DIR__ . '/../config/services');
        $configurator = new ServiceConfigurator($loader);
        $serviceContainer = new ServicesContainer($configurator);

        $services = require_once(__DIR__ . '/../config/services.php');
        foreach ($services as $id => $service) {
            $serviceContainer->put($id, $service);
        }
        
        return $serviceContainer;
	}
    
    /**
     * @return RoutesCollection
     */
    private function loadRoutes(): RoutesCollection
    {
        $routes = require_once(__DIR__ . '/../config/routes.php');
        
        $routesCollection = new RoutesCollection(DefaultAction::class);
        foreach ($routes as $name => $routeConfig) {
            $routesCollection->route(
                ...array_values(array_merge([$name], $routeConfig))
            );
        }
        
        return $routesCollection;
    }
}
