<?php
namespace Config;

use Vendor\Codingx\ReadFile;
use Vendor\Codingx\Redirect;
use Vendor\Codingx\Request;
use Vendor\Exceptions\NotFoundException;
use App\Annotation\Route;

class Router{
    use Redirect;

    public static function guardian($routes,$page){
        if(isset($routes[$page][2]) && $routes[$page][2]==="guard"){
            $user = Session::getInstance()->get("user");
            if(!$user){
                Router::redirect("login");
            }
        }
    }

    public static function route() {
        $routes = ReadFile::readJson(ROUTES);
        $page = (isset($_GET["page"])) ? $_GET["page"] : "";
        self::guardian($routes, $page);

        foreach ($routes as $path => $route) {
            if (is_array($route) && count($route) >= 2) {
                $controllerName = $route[0];
                $methodName = $route[1];
                $annotation = self::getMethodAnnotation($controllerName, $methodName);
                $classAnnotation = self::getClassAnnotation($controllerName);
                if (
                    ($annotation !== null && $annotation instanceof Route) &&
                    ($classAnnotation !== null && $classAnnotation instanceof Route)
                ) {
                    $annotationPath = $annotation->path;
                    $classAnnotationPath =  $classAnnotation->path;
                    if (trim($annotationPath.$classAnnotationPath, '/') === $page) {
                        $classBuilder = new ClassBuilder();
                        $instanceController = $classBuilder->build($controllerName);
                        return $instanceController->$methodName($_REQUEST);
                    }
                }
                if ($annotation !== null && $annotation instanceof Route && $classAnnotation == null) {
                    $annotationPath = $annotation->path;
                    if (trim($annotationPath, '/') === $page) {
                        $classBuilder = new ClassBuilder();
                        $instanceController = $classBuilder->build($controllerName);
                        return $instanceController->$methodName($_REQUEST);
                    }
                }
            }
        }

        throw new NotFoundException();
    }

    protected static function getMethodAnnotation(string $className, string $methodName) {
        $reflectionClass = new \ReflectionClass($className);
        $reflectionMethod = $reflectionClass->getMethod($methodName);
        $annotations = $reflectionMethod->getAttributes();

        foreach ($annotations as $annotation) {
            $annotationInstance = $annotation->newInstance();
            if ($annotationInstance instanceof Route) {
                return $annotationInstance;
            }
        }

        return null;
    }

    protected static function getClassAnnotation(string $className) {
        $reflectionClass = new \ReflectionClass($className);
        $classAnnotations = $reflectionClass->getAttributes(Route::class);

        foreach ($classAnnotations as $annotation) {
            $annotationInstance = $annotation->newInstance();
            if ($annotationInstance instanceof Route) {
                return $annotationInstance;
            }
        }

        return null;
    }
}
