<?php
declare(strict_types=1);

use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->plugin(
        'ContactManager',
        ['path' => '/contact-manager', '_namePrefix' => 'contactManager:'],
        function (RouteBuilder $builder) {
            $builder->scope(
                '/contacts', 
                ['controller' => 'Contacts', '_namePrefix' => 'contacts:'],
                function (RouteBuilder $builder) {
                    $builder
                        ->connect(
                            '/',
                            ['action' => 'index'],
                            ['_name' => 'index'],
                        );

                    $builder
                        ->connect(
                            '/add',
                            ['action' => 'add'],
                            ['_name' => 'add'],
                        );

                    $builder
                        ->connect(
                            '/view',
                            ['action' => 'view'],
                            ['_name' => 'view'],
                        );

                    $builder
                        ->connect(
                            '/edit',
                            ['action' => 'edit'],
                            ['_name' => 'edit'],
                        );
                }
            );
        }
    );
};
