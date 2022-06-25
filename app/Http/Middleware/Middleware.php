<?php

namespace App\Http\Middleware;

use ReflectionClass;

class Middleware
{
    /**
     * redirect url
     */
    protected $redirect = "/";

    protected function handle()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        $this->redirect;
    }

    final public function run()
    {
        if (DI) {
            $currentMiddlewarName = static::class;
            $currentMiddlewarClass = new ReflectionClass($currentMiddlewarName);
            $currentMiddlewarParameters = $currentMiddlewarClass->getMethod("handle")->getParameters();

            if (count($currentMiddlewarParameters)) {
                foreach ($currentMiddlewarParameters as $parameter) {
                    $argType = (string)$parameter->getType()->getName();

                    if (!checkNeedDI($argType)) {
                        helpReturn(702, "check handle(): " . $currentMiddlewarName . ' - find : ' . $argType);
                    }

                    $instanceReflection = new ReflectionClass($argType);

                    if ($instanceReflection->hasMethod("__construct") && count($instanceReflection->getMethod("__construct")->getParameters())) {
                        helpReturn(703, 'check : ' . $argType);
                    } else {
                        $instance[] = $instanceReflection->newInstance();
                    }
                }

                $handleCondition = $this->handle(...$instance);
            } else {
                $handleCondition = $this->handle();
            }
        } else {
            $handleCondition = $this->handle();
        }

        if ($handleCondition) {
            // go to next request
            return true;
        } else {
            // go to redirect url
            header('Location: ' . $this->redirect);
            return false;
        };
    }
}
