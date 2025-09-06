<?php

namespace App\Http\Controllers\Role\PK;

use App\Http\Controllers\Role\Shared\BaseSkController;

class SkController extends BaseSkController
{
    protected string $routeBase = 'pk';
    protected string $scope     = 'own';
}
