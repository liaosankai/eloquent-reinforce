<?php

namespace Liaosankai\EloquentReinforce\Tests;

use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Database\Schema\Blueprint;

class BaseTestCase extends TestCase
{
    /**
     * @var ConsoleOutput 終端器輸出器
     */
    protected $console;

    /**
     * @var \Faker\Factory 假資料產生器
     */
    protected $faker;

    /**
     * BaseTestCase constructor.
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->console = new ConsoleOutput();
        $this->faker = \Faker\Factory::create();
    }

    /**
     * 測試時的 Package Providers 設定
     *
     *  ( 等同於原 laravel 設定 config/app.php 的 Autoloaded Service Providers )
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Orchestra\Database\ConsoleServiceProvider::class,
            \Liaosankai\EloquentReinforce\EloquentReinforceServiceProvider::class,
        ];
    }

    /**
     * 測試時的 Class Aliases 設定
     *
     * ( 等同於原 laravel 中設定 config/app.php 的 Class Aliases )
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [

        ];
    }

    /**
     * 測試時的時區設定
     *
     * ( 等同於原 laravel 中設定 config/app.php 的 Application Timezone )
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return string|null
     */
    protected function getApplicationTimezone($app)
    {
        return 'Asia/Taipei';
    }

    /**
     * 測試時使用的 HTTP Kernel
     *
     * ( 等同於原 laravel 中 app/HTTP/kernel.php )
     * ( 若需要用自訂時，把 Orchestra\Testbench\Http\Kernel 改成自己的 )
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton(
            'Illuminate\Contracts\Http\Kernel',
            'Orchestra\Testbench\Http\Kernel'
        );
    }

    /**
     * 測試時使用的 Console Kernel
     *
     * ( 等同於原 laravel 中 app/Console/kernel.php )
     * ( 若需要用自訂時，把 Orchestra\Testbench\Console\Kernel 改成自己的 )
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function resolveApplicationConsoleKernel($app)
    {
        $app->singleton(
            'Illuminate\Contracts\Console\Kernel',
            'Orchestra\Testbench\Console\Kernel'
        );
    }

    /**
     * 測試環境設定
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        // 若有環境變數檔案，嘗試著讀取使用
        if (file_exists(dirname(__DIR__) . '/.env')) {
            $dotEnv = new \Dotenv\Dotenv(dirname(__DIR__));
            $dotEnv->load();
        }

        // 定義測試時使用的資料庫
        $driver = env('TEST_DB_CONNECTION', 'sqlite');
        $app['config']->set('database.connections.testing', [
            'driver' => $driver,
            'host' => env('TEST_DB_HOST', 'localhost'),
            'database' => env('TEST_DB_DATABASE', ':memory:'),
            'port' => env('TEST_DB_PORT'),
            'username' => env('TEST_DB_USERNAME'),
            'password' => env('TEST_DB_PASSWORD'),
            'prefix' => env('TEST_DB_PREFIX'),
        ]);
        $app['config']->set('database.default', 'testing');
    }

    /**
     * 測試初始設置
     */
    protected function setUp()
    {
        parent::setUp();

        // 建立 id 類型是字串的測試 user 資料表
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id');
            $table->text('remark');
            $table->datetime('last_login_at');
            $table->timestamps();
            $table->primary(['id']);
        });
        // 測試完後再砍掉臨時的 user 資料表
        $this->beforeApplicationDestroyed(function () {
            Schema::dropIfExists('users');
        });
    }
}
