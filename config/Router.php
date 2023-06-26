<?php
namespace Config;

use Vendor\Codingx\Redirect;
use Vendor\Exceptions\NotFoundException;
use App\Annotation\Route;

class Router
{
    use Redirect;

    public static function route()
    {
        // Récupérer toutes les classes dans le namespace des contrôleurs
        $controllers = glob('Src/Controller/*.php');
        $page = (isset($_GET["page"])) ? $_GET["page"] : DEFAULT_ROUTE;

        foreach ($controllers as $controller) {
            $className = 'App\\Controller\\' . basename($controller, '.php');

            $reflectionClass = new \ReflectionClass($className);
            $methods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);

            $classAnnotation = self::getClassAnnotation($className);

            foreach ($methods as $method) {
                $methodName = $method->getName();

                $annotation = self::getMethodAnnotation($method);
                if ($annotation !== null && $annotation instanceof Route) {
                    $annotationPath = $annotation->path;
                    if($classAnnotation !== null && $classAnnotation instanceof Route)
                    {
                        $classAnnotationPath = $classAnnotation->path;
                        if(trim($classAnnotationPath.$annotationPath, "/") == trim($page, "/")){
                            $classBuilder = new ClassBuilder();
                            $instanceController = $classBuilder->build($className);

                            //$instanceController = $reflectionClass->newInstance();
                            return $instanceController->$methodName($_REQUEST);
                            // Terminer l'exécution du routeur une fois que la route est trouvée
                        }
                    }
                    elseif(trim($annotationPath, "/") == trim($page, "/")){
                        $classBuilder = new ClassBuilder();
                        $instanceController = $classBuilder->build($className);

                        //$instanceController = $reflectionClass->newInstance();
                        return $instanceController->$methodName($_REQUEST);
                        // Terminer l'exécution du routeur une fois que la route est trouvée
                    }
                }
            }
        }

        throw new NotFoundException();
    }

    protected static function getMethodAnnotation(\ReflectionMethod $method)
    {
        $annotations = $method->getAttributes(Route::class);

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

