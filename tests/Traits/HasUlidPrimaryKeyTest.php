<?php

namespace Liaosankai\EloquentReinforce\Tests\Traits;


use Liaosankai\EloquentReinforce\Tests\BaseTestCase;
use Liaosankai\EloquentReinforce\Tests\Models\User;

class HasUlidPrimaryKeyTest extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test()
    {
        // ARRANGE
        $user = new User();

        // ACTION
        $user->save();

        // ASSERT
        $this->assertEquals(26, strlen($user->id));
        $this->assertEquals(true, is_string($user->id));
    }

}
