# 自动补全model类的字段属性注释

## 补全前
```php
namespace App\Models;

class TestUser{
    protected $table = 'user';
    protected $primaryKey = 'id';
}
```

## 补全后
```php
namespace App\Models;

/**
 * Class App\Models\TestUser 
 * @property integer $id 
 * @property string $username 用户名
 * @property string $email E-mail
 * @property string $password 密码
 * @property string $salt 密码盐
 * @property integer $status 0正常 -1删除
 * @property string $created_at 
 * @property string $updated_at 
 */
class TestUser{
    protected $table = 'user';
    protected $primaryKey = 'id';
}
```

## 使用方法
```php
require_once 'src/TestUser.php';
require_once 'src/FillModelPropertiesComment.php';

$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');

$fill = new FillModelPropertiesComment($pdo, 'user');   //user表名
$fill->fill(App\Models\TestUser::class);    //App\Models\TestUser类名
```
