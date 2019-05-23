<?php
namespace umbalaconmeogia\ssosubdomain\actions;

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\web\HttpException;

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
        $loginUrl = $this->loginUrl();
        if (!Yii::$app->user->isGuest) {
            $this->clearCountAccess();
            return $this->controller->goBack();
        }

        $this->setCountAccess(); // Prevent loop of redirecting.
        return $this->controller->redirect($loginUrl);
    }

    /**
     * Reset count in session.
     */
    private function clearCountAccess()
    {
        $this->setCountAccess(true);
    }

    /**
     * Set counter in session to prevent looping of redirection from login Url.
     * @param boolean $clear
     * @throws HttpException
     */
    private function setCountAccess($clear = false)
    {
        \Yii::trace("setCountAccess($clear)", __METHOD__);
        $sessionKey = "COUNT_" . base64_encode($this->idProviderLoginUrl);
        if ($clear) {
            Yii::$app->session->remove($sessionKey);
        } else {
            $count = Yii::$app->session[$sessionKey];
            Yii::trace("Current $sessionKey = $count");
            if (Yii::$app->session[$sessionKey] >= 2) {
                $this->clearCountAccess();
                throw new HttpException(403, 'You do not have permission to access this page');
            }
            Yii::$app->session[$sessionKey] = $count + 1;
        }
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
