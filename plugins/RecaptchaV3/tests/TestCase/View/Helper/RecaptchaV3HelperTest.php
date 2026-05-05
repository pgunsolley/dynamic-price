<?php
declare(strict_types=1);

namespace RecaptchaV3\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use RecaptchaV3\View\Helper\RecaptchaV3Helper;

/**
 * RecaptchaV3\View\Helper\RecaptchaV3Helper Test Case
 */
class RecaptchaV3HelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \RecaptchaV3\View\Helper\RecaptchaV3Helper
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
        $view = new View();
        $this->RecaptchaV3 = new RecaptchaV3Helper($view);
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
