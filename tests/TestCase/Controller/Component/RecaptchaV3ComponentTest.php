<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\RecaptchaV3Component;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\RecaptchaV3Component Test Case
 */
class RecaptchaV3ComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\RecaptchaV3Component
     */
    protected $RecaptchaV3;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->RecaptchaV3 = new RecaptchaV3Component($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RecaptchaV3);

        parent::tearDown();
    }
}
