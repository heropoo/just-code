# API文档

> version: v1.0
> 接口地址： 
    - http://api.example.com/

## 文档说明
### APP接口固定参数

固定参数使用get方式传递

| 名称 | 类型 | 注释 |
|:-------------:|:-------------:|:-------------|
| clientType | string | 终端版本，取值范围： ios/android/pc/wap |
| appVersion | string | app版本，例如：1.0.0 |
| deviceName | string | 设备名称，例如：iphone7/xiaomi6 |
| osVersion | string | 设备os版本，例如：11.2/8.0.0 |

### 错误码规范
| 错误码 | 注释 |
|:-------------:|:-------------|
| >0 | 业务逻辑错误 |
| -1 | 系统通用错误，未指定具体错误码 |
| -2 | 未登录 |

## 目录
1. [用户账号](user.html#1-user)
    * [获取注册验证码](user.html#userRegGetCode)
    * [注册](user.html#userRegister)
    * [获取登陆验证码](user.html#userLoginGetCode)
    * [登录](user.html#userLogin)
    * [快速登录](user.html#userQuickLogin)
    * [退出](user.html#userLogout)
    * [修改登录密码](user.html#userChangePwd)
    * [找回登录密码时设置新密码](user.html#userResetPassword)
    * [验证当前手机号](user.html#userVerifyCode)
2. [用户认证](info.html#2-info)
    * [填写身份证和姓名并进行实名认证](info.html#infoSavePersonInfo)
3. [其他](other.html#3-other)
    * [上传图片](other.html#pictureUploadImage)

<script type="text/javascript">
    window.onload = function(){
        var h1 = document.getElementsByTagName('h1')[0];
        document.title = h1.textContent || h1.innerText;
        var a_list = document.getElementsByTagName("a");
        for(var i=0; i< a_list.length; i++){
            a_list[i].href = a_list[i].href.toLowerCase();
        }
    };
</script>