<?php

namespace Liaosankai\EloquentReinforce\Tests\Traits;

use Liaosankai\EloquentReinforce\Tests\BaseTestCase;
use Liaosankai\EloquentReinforce\Tests\Models\User;
use Jenssegers\Date\Date as Carbon;

class HasI18nAsDateTimeTest extends BaseTestCase
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
        $beforeDiffForHumansA = $user->last_login_at->diffForHumans(); // 1 second ago
        $beforeDiffForHumansB = $user->created_at->diffForHumans(); // 1 second ago
        Carbon::setLocale('zh-TW');
        $afterDffForHumansA = $user->last_login_at->diffForHumans(); // 1 秒前
        $afterDffForHumansB = $user->created_at->diffForHumans(); // 1 秒前

        // ASSERT
        $this->assertNotEquals($beforeDiffForHumansA, $afterDffForHumansA);
        $this->assertNotEquals($beforeDiffForHumansB, $afterDffForHumansB);
    }

}
