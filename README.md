# yii2-ssosubdomain

Library to help implementing SSO on subdomains.

To login using SSO, you need an IdentityProvider web server and several (at least one) ServiceProvider web server.

## Usage

### Install the library to each server system.

```shell
composer require umbalaconmeogia/yii2-ssosubdomain
```

### Update login and logout action in IdentityProvider server.

Edit SiteController class, remove *actionLogin()*, *actionLogout()* functions, and update function *actions()* instead.

```php
public function actions()
{
    return [
        'login' => [
            'class' => \umbalaconmeogia\ssosubdomain\actions\IdentityProviderLoginAction::class,
            'loginFormClass' => LoginForm::class,
        ],
        'logout' => [
            'class' => \umbalaconmeogia\ssosubdomain\actions\IdentityProviderLogoutAction::class,
            'ssoCookieDomain' => Yii::$app->session->cookieParams['domain'],
        ],

        // Another definition.
    ];
}
```

**Notice**: Remove the requirement that *logout* should be called by POST method in *behaviors()* function.

### Update login and logout action in ServiceProvider server.

Edit SiteController class, remove *actionLogin()*, *actionLogout()* functions, and update function *actions()* instead.

```php
public function actions()
{
    return [
        'login' => [
            'class' => \umbalaconmeogia\ssosubdomain\actions\ServiceProviderLoginAction::class,
            'idProviderLoginUrl' => \Yii::$app->params['idProviderLoginUrl'],
        ],
        'logout' => [
            'class' => \umbalaconmeogia\ssosubdomain\actions\ServiceProviderLogoutAction::class,
            'idProviderLogoutUrl' => \Yii::$app->params['idProviderLogoutUrl'],
        ],

        // Another definition.
    ];
}
```

Also set *idProviderLoginUrl* and *idProviderLogoutUrl* in config params.