<?php
namespace App\Http\Controllers\Role\Admin;
use App\Http\Controllers\Role\Shared\BaseSkController;

class SkController extends BaseSkController
{
    protected string $routeBase = 'admin';
    protected string $scope     = 'all'; // admin lihat semua
}
