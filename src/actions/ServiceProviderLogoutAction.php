<?php
namespace umbalaconmeogia\ssosubdomain\actions;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;

/**
 * Example of usage. In SiteController class, declare the action.
 * <pre>
 * public function actions()
 * {
 *     return [
 *         // Another definition.
 *         'logout' => [
 *             'class' => \umbalaconmeogia\ssosubdomain\actions\ServiceProviderLogoutAction::class,
 *             'idProviderLogoutUrl' => \Yii::$app->params['idProviderLogoutUrl'],
 *         ],
 *     ];
 * }
 * </pre>
 * @author thanh
 *
 */
class ServiceProviderLogoutAction extends Action
{
    /**
     * Name of URL parameter to hold the returnUrl.
     * @var string
     */
    public $returnUrlParam = 'returnUrl';

    /**
     * URL of IdP logout page.
     * @var string
     */
    public $idProviderLogoutUrl;

    /**
     * Initializes the application component.
     */
    public function init()
    {
        parent::init();

        if ($this->idProviderLogoutUrl === null) {
            throw new InvalidConfigException('ServiceProviderLogoutAction::idProviderLogoutUrl must be set.');
        }
    }


    /**
     * Logout action.
     * @return \yii\web\Response
     */
    public function run()
    {
        return $this->controller->redirect($this->logoutUrl());
    }

    /**
     * @return string
     */
    private function logoutUrl()
    {
        $returnUrlQuery = http_build_query([$this->returnUrlParam => \yii\helpers\Url::home(true)]);
        $separator = (strpos($this->idProviderLogoutUrl, '?') === false) ? '?' : '&';
        $url = "{$this->idProviderLogoutUrl}{$separator}{$returnUrlQuery}";
        return $url;
    }
}