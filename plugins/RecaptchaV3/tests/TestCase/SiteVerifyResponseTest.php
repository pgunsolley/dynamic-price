<?php
declare(strict_types=1);

namespace RecaptchaV3\Test\TestCase;

use Cake\I18n\DateTime;
use Override;
use PHPUnit\Framework\TestCase;
use RecaptchaV3\SiteVerifyResponse;

class SiteVerifyResponseTest extends TestCase
{
    private SiteVerifyResponse $siteVerifyResponse;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->siteVerifyResponse = new SiteVerifyResponse(
            success: true,
            score: 8.9,
            action: 'foobar',
            challengeTs: '2020-10-10T12:00:00',
            hostname: 'foobar',
            errorCodes: [],
        );
    }

    public function testGetSuccess()
    {
        $this->assertEquals(true, $this->siteVerifyResponse->getSuccess());
    }

    public function testGetScore()
    {
        $this->assertEquals(8.9, $this->siteVerifyResponse->getScore());
    }

    public function testGetAction()
    {
        $this->assertEquals('foobar', $this->siteVerifyResponse->getAction());
    }

    public function testGetChallengeTs()
    {
        $val = $this->siteVerifyResponse->getChallengeTs();
        $this->assertInstanceOf(DateTime::class, $val);
    }

    public function testGetHostname()
    {
        $this->assertEquals('foobar', $this->siteVerifyResponse->getHostname());
    }

    public function testGetErrorCodes()
    {
        $this->assertEquals([], $this->siteVerifyResponse->getErrorCodes());
    }
}
