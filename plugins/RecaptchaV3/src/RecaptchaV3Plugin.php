<?php
declare(strict_types=1);

namespace RecaptchaV3;

use Cake\Controller\ComponentRegistry;
use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use League\Container\Argument\Literal\BooleanArgument;
use League\Container\Argument\Literal\StringArgument;
use RecaptchaV3\Controller\Component\RecaptchaV3Component;
use RecaptchaV3\Middleware\RecaptchaV3Middleware;
use RecaptchaV3\Service\RecaptchaV3Service;

/**
 * Plugin for RecaptchaV3
 */
class RecaptchaV3Plugin extends BasePlugin
{
    /**
     * Register application container services.
     *
     * @param \Cake\Core\ContainerInterface $container The Container to update.
     * @return void
     * @link https://book.cakephp.org/5/en/development/dependency-injection.html#dependency-injection
     */
    public function services(ContainerInterface $container): void
    {
        $container
            ->add(RecaptchaV3Middleware::class)
            ->addArguments([
                RecaptchaV3Service::class,
                new BooleanArgument(Configure::read('RecaptchaV3.sendRemoteIp', false)),
            ]);

        $container
            ->add(RecaptchaV3Component::class)
            ->addArguments([
                ComponentRegistry::class,
                RecaptchaV3Service::class,
            ]);

        $container
            ->addShared(RecaptchaV3Service::class)
            ->addArguments([
                new StringArgument(Configure::readOrFail('RecaptchaV3.secretKey')),
                new StringArgument(Configure::readOrFail('RecaptchaV3.siteKey')),
            ]);
    }
}
