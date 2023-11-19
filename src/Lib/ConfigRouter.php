<?php

namespace Jamkrindo\Lib;

use DI\Attribute\Inject;
use JetBrains\PhpStorm\NoReturn;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;

class ConfigRouter
{
    private const ANSI_RED_BOLD = "\033[1;31m";
    private const ANSI_GREEN = "\033[0;32m";
    private const ANSI_RESET = "\033[0m";
    private const ANSI_YELLOW_BG = "\033[43m";

    private array $attributes = [];
    private array $allRoutes = [];
    private ?string $prefix = null;
    private bool $checkingRest = true;

    #[Inject]
    public function __construct(
        private readonly array $classControllers
    ) {
        $this->getAttributes();
    }

//    public function handle(string $method,string $uri) : array
//    {
//        $attributes = self::getAttributes();
//        foreach ($attributes as $attribute) {
//
//        }
//    }

    private function getAttributes()
    {
        $routes = [];
        foreach ($this->classControllers as $class) {
            $this->processController($class);
            $this->setDataRoutes($class,$routes);
            $this->prefix = null;
        }
        $this->setRouteToJson($routes);
        return $this->attributes;
    }

    private function setRouteToJson($data) {
        $phpData = var_export($data, true);
        $filename = __DIR__ .'/../../bootstrap/routes_cache.php';
        file_put_contents($filename, "<?php\n\nreturn $phpData;\n");
    }

    private function setDataRoutes(string $class,&$data) : void
    {
        $middleware = !empty($this->attributes[$class]['Middleware']) ? $this->attributes[$class]['Middleware'] : null;
        $routes = $this->attributes[$class]['routes'];
        foreach ($routes as $key => $items) {
            foreach ($items as $item){
                $data[$item['method']][$key] =  array_merge(['middleware' => $middleware],$item);
            }
        }
    }


    private function cacheRoute(string $class,string $method,string $uri) : array
    {
        $middleware = !empty($this->attributes[$class]['Middleware']) ? $this->attributes[$class]['Middleware'] : null;
        $routes = $this->attributes[$class]['routes'];
        foreach ($routes as $key => $items) {
            $uriHttp = explode("/",$uri);
            $uriRoute = explode("/",$key);
            if(count($uriHttp) === count($uriRoute)) {
                $httpSlice2 = implode('',array_slice($uriHttp,1,-1));
                $routeSlice2 = "xxx ".implode('',array_slice($uriRoute,1,-1));
                foreach ($items as $item) {
                    if(is_int(strpos($routeSlice2,$httpSlice2)) && strtolower($method) === strtolower($item['method'])){
                        return array_merge(['middleware' => $middleware],$item);
                    }
                }
            }
        }
        return [];
    }

    #[NoReturn]
    private function processController(string $class): void
    {
        $reflectionClass = new ReflectionClass($class);
        $classAttributes = $reflectionClass->getAttributes();

        foreach ($classAttributes as $attribute) {
            $instance = $attribute->newInstance();
            $this->processAnnotationNamespace($attribute->getName(), $instance->value, $class);
        }

        $this->processControllerMethods($reflectionClass->getMethods(), $class);
    }

    #[NoReturn]
    private function processControllerMethods(array $methods, string $class): void
    {
        foreach ($methods as $method) {
            $this->isValidFunctionDeclaration($method,$class);
            $methodAttributes = $method->getAttributes();

            foreach ($methodAttributes as $attribute) {
                $attributeInstance = $attribute->newInstance();
                $routeInfo = $attributeInstance->getNameUri();
                $routeKey = $this->prefix . '+' . $routeInfo['uri'] . '+' . $routeInfo['method'];
                $dataRoute = array_merge($routeInfo, [
                    'action' => $method->getName(),
                    'controller' => $class,
                ]);
                $this->handleRouteConflictAcrossAllControllers(
                    $routeKey, $routeInfo, $dataRoute, $class, $method->getName()
                );
            }
        }
    }

    #[NoReturn]
    private function isValidFunctionDeclaration(object $reflectionFunction,string $class) : void
    {
        $checkReturnType = $reflectionFunction->getReturnType();
        $additionalInfo = self::ANSI_YELLOW_BG.$class.", line: ".$reflectionFunction->getStartLine().self::ANSI_RESET;
        if(is_null($checkReturnType)) {
            echo self::ANSI_RED_BOLD . "Fatal Error: Missing return type declaration for method {$reflectionFunction->getName()}\n" . self::ANSI_RESET;
            echo self::ANSI_RED_BOLD . "Additional Info: " . self::ANSI_RESET . $additionalInfo . "\n";
            die;
        }

        foreach ($reflectionFunction->getParameters() as $parameter)
        {
            if(!$parameter->hasType()){
                $parameterName = $parameter->getName();
                echo self::ANSI_RED_BOLD . "Fatal Error: Missing type declaration for parameter \$${parameterName} in {$reflectionFunction->getName()}\n" . self::ANSI_RESET;
                echo self::ANSI_RED_BOLD . "Additional Info: " . self::ANSI_RESET . $additionalInfo . "\n";
                die;
            }
        }

    }

    #[NoReturn]
    private function handleRouteConflictAcrossAllControllers(
        string $routeKey, array $routeInfo, array $dataRoute, string $class, string $method
    ): void {
        if (isset($this->allRoutes[$routeKey])) {
            $existingRoute = $this->attributes[$this->allRoutes[$routeKey]]['routes'][$this->prefix.$routeInfo['uri']];
            $this->printConflictMessage($dataRoute, $existingRoute);
        }

        $this->allRoutes[$routeKey] = $class;
        $this->attributes[$class]['routes'][$this->prefix.$routeInfo['uri']][$method] = $dataRoute;
    }

    #[NoReturn]
    private function processAnnotationNamespace(string $namespace, mixed $value, string $class): void
    {
        $annotationName = $this->extractAnnotationName($namespace);
        $this->attributes[$class][$annotationName] = $value;
        $this->updateRestAndPrefixFlags($annotationName, $value);
        $this->printErrorAndDie("Namespace: $class");
    }

    private function extractAnnotationName(string $namespace): string
    {
        return str_replace("Jamkrindo\Annotations\\", "", $namespace);
    }

    #[NoReturn]
    private function updateRestAndPrefixFlags(string $annotationName, mixed $value): void
    {
        if ($annotationName === 'RestController') {
            $this->checkingRest = false;
        }

        if ($annotationName === 'Prefix') {
            $this->prefix = $value;
        }
    }

    #[NoReturn] private function printErrorAndDie(string $additionalInfo): void
    {
        if ($this->checkingRest) {
            echo self::ANSI_RED_BOLD . "Error: The class must have the RestController Attribute.\n" . self::ANSI_RESET;
            echo self::ANSI_RED_BOLD . "Additional Info: " . self::ANSI_RESET . $additionalInfo . "\n";
            die;
        }
    }

    #[NoReturn]
    private function printConflictMessage(array $dataRoute, array $existingRoute): void
    {
        $padding = str_repeat(
            ' ', (115 - strlen('Conflict detected!')) / 2
        );
        echo "\n";
        echo self::ANSI_YELLOW_BG . " $padding Conflict detected! $padding " . self::ANSI_RESET . "\n \n";

        echo self::ANSI_RED_BOLD . "Conflicting Route:" . self::ANSI_RESET . "\n";
        FormaterCLI::printFormattedArrayRouter([$dataRoute]);
        echo "\n";

        echo self::ANSI_GREEN . "Existing conflicting routes:" . self::ANSI_RESET . "\n";
        FormaterCLI::printFormattedArrayRouter($existingRoute);
        die;
    }
}
