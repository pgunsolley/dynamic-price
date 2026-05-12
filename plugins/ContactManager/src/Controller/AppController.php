<?php
declare(strict_types=1);

namespace ContactManager\Controller;

use App\Controller\AppController as BaseController;
use Crud\Controller\ControllerTrait;
use Override;

class AppController extends BaseController
{
    use ControllerTrait;

    #[Override]
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'Crud.Index',
                'Crud.View',
                'Crud.Add',
                'Crud.Edit',
                'Crud.Delete',
            ],
        ]);
    }
}
