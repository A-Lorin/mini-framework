<?php

namespace Config;

class ClassBuilder
{
    public function build(string $className)
    {
        $arguments = $this->getClassArguments($className);
        return new $className(...$arguments);
    }

    protected function getClassArguments(string $className)
    {
        $class = new \ReflectionClass($className);
        if (!$class->hasMethod('__construct')) {
            return [];
        }
        $params = $class->getMethod('__construct')->getParameters();
        $services = [];
        foreach ($params as $param) {
            $type = $param->getType();
            if ($type !== null && !$type->isBuiltin()) {
                $services[] = $this->build($type->getName());
            }
        }
        return $services;
    }

}