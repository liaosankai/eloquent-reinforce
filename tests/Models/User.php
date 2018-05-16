<?php

namespace Liaosankai\EloquentReinforce\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Liaosankai\EloquentReinforce\Traits\HasI18nAsDateTime;
use Liaosankai\EloquentReinforce\Traits\HasUlidPrimaryKey;

class User extends Model
{
    use HasUlidPrimaryKey;
    use HasI18nAsDateTime;

    protected $dates = [
        'last_login_at'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // 除了 id 之外的欄位預設值，應該在建構式透過設定 $attributes 屬性來初始化
        // 避免資料庫忘記設定初始值，建議 Model 都應該定義每個欄位的初始值
        $this->attributes['remark'] = 'Hello World!';
        $this->attributes['last_login_at'] = time();
    }
}