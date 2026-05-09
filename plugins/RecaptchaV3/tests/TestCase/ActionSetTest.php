<?php
declare(strict_types=1);

namespace RecaptchaV3\Test\TestCase;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RecaptchaV3\Action;
use RecaptchaV3\ActionSet;

class ActionSetTest extends TestCase
{
    public function testAdd_passAction_storesActionCorrectly()
    {
        $stubAction = $this->createStub(Action::class);
        $stubAction->method('getName')->willReturn('foobar');
        
        $actionSet = new ActionSet();
        $actionSet->add($stubAction);

        $this->assertSame($stubAction, $actionSet->get('foobar'));
    }

    public function testAdd_multipleActions_allAreStoredCorrectly()
    {
        $stubAction1 = $this->createStub(Action::class);
        $stubAction2 = $this->createStub(Action::class);

        $stubAction1->method('getName')->willReturn('first');
        $stubAction2->method('getName')->willReturn('second');

        $actionSet = new ActionSet();
        $actionSet->add([$stubAction1, $stubAction2]);

        $this->assertSame($stubAction1, $actionSet->get('first'));
        $this->assertSame($stubAction2, $actionSet->get('second'));
    }

    public function testAdd_multipleActionsWithSameName_invalidArgumentExceptionThrown()
    {
        $stubAction1 = $this->createStub(Action::class);
        $stubAction2 = $this->createStub(Action::class);

        $stubAction1->method('getName')->willReturn('foobar');
        $stubAction2->method('getName')->willReturn('foobar');

        $actionSet = new ActionSet();

        $this->expectException(InvalidArgumentException::class);
        $actionSet->add([$stubAction1, $stubAction2]);
    }

    public function testGet_noActionsStored_nullIsReturned()
    {
        $this->assertNull((new ActionSet)->get('foo'));
    }

    public function testGet_existingAction_returnsAction()
    {
        $stubAction = $this->createStub(Action::class);
        $stubAction->method('getName')->willReturn('foobar');

        $actionSet = new ActionSet();
        // TODO: Figure out if i should partialmock add method or something lol

    }
}
