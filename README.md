# Eloquent Reinforce 
補充官方 Model 在專案缺少的功能

### Ulid 主鍵 (HasUlidPrimaryKey) 
停用 Model 原本的自動增號的數字主鍵方式，改以 `robinvdvleuten/ulid` 產生的 Ulid 字串代替

### 多語系日期時間 (HasI18nAsDateTime)
原本 Model 設定在 `$dates` 的欄位會取得為 `Carbon\Carbon` 類型資料，使用這個將會以支援多語系的 `Jenssegers\Date\Date` 替代

## 用法
使用 User 這個 Model 為範例，可以在 `tests/Models` 找到這個類別

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