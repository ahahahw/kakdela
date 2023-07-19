<?php

namespace App;

use Psr\Container\ContainerInterface;
use App\Exceptions\Container\NotFoundException;
use App\Exceptions\Container\ContainerException;
class Container implements ContainerInterface
{
    private array $entries = [];

    public function get($id)
    {
        if($this->has($id)){
            $entry = $this->entries[$id];
            if(is_callable($entry)){
                return $entry($this);
            }
            $id = $entry;
        }

        return $this->resolve($id);

    }

    public function has(string $id) : bool
    {
        return isset($this->entries[$id]);

    }
    public function set($id,callable|string $concrete)
    {
        $this->entries[$id] = $concrete;
    }

    public function resolve($id)
    {
       $reflectionClass = new \ReflectionClass($id);

       if(!$reflectionClass->isInstantiable()){
        throw new ContainerException('Class '.$id.' is not instantiable');
       }

       $constructor = $reflectionClass->getConstructor();

       if(!$constructor)
       {
        return new $id;
       }

       $parameters = $constructor->getParameters();

       
       if(!$parameters)
       {
        return new $id;
       }    

       $dependencies = array_map(function(\ReflectionParameter  $param){
        $name= $param->getName();
        $type = $param->getType();

        if(!$type){
            throw new ContainerException('Failed to resolve class '.$id.' because param '.$name.' is missing a type hint');
        }
        if($type instanceof \ReflectionUnionType)
        {
            throw new ContainerException('Failed to resolve class '.$id.' because of union type of param '.$name.' is missing a type hint');
        }
        if($type instanceof \ReflectionNamedType && ! $type->isBuiltin())
        {
            return $this->get($type->getName());
            
        }
        throw new ContainerException('Failed to resolve class '.$id.' because invalid param param '.$name.' is missing a type hint');
       },$parameters);

       return $reflectionClass->newInstanceArgs($dependencies);
    }

}