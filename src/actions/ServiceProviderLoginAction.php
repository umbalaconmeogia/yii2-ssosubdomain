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
 *         'login' => [
 *             'class' => \umbalaconmeogia\ssosubdomain\actions\ServiceProviderLoginAction::class,
 *             'idProviderLoginUrl' => \Yii::$app->params['idProviderLoginUrl'],
 *         ],
 *     ];
 * }
 * </pre>
 * @author thanh
 *
 */
class ServiceProviderLoginAction extends Action
{
    /**
     * Name of URL parameter to hold the returnUrl.
     * @var string
     */
    public $returnUrlParam = 'returnUrl';

    /**
     * URL of IdP login page.
     * @var string
     */
    public $idProviderLoginUrl;

    /**
     * Initializes the application component.
     */
    public function init()
    {
        parent::init();

        if ($this->idProviderLoginUrl === null) {
            throw new InvalidConfigException('ServiceProviderLoginAction::idProviderLoginUrl must be set.');
        }
    }

    /**
     * Login action.
     * @return \yii\web\Response
     */
    public function run()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->controller->goBack();
        }

        return $this->controller->redirect($this->loginUrl());
    }

    /**
     * @return string
     */
    private function loginUrl()
    {
        // TODO: Want to redirect to current page, not site/login page.
        $returnUrlQuery = http_build_query([$this->returnUrlParam => \Yii::$app->request->getAbsoluteUrl()]);
        $separator = (strpos($this->idProviderLoginUrl, '?') === false) ? '?' : '&';
        $url = "{$this->idProviderLoginUrl}{$separator}{$returnUrlQuery}";
        return $url;
    }
}