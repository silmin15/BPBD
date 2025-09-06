<?php
namespace App\Http\Controllers\Role\RR;
use App\Http\Controllers\Role\Shared\BaseSkController;

class SkController extends BaseSkController
{
    protected string $routeBase = 'rr';
    protected string $scope     = 'own';
}
