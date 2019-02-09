<?php
namespace umbalaconmeogia\ssosubdomain\actions;

use Yii;
use yii\base\Action;

/**
 * Example of usage. In SiteController class, declare the action.
 * <pre>
 * public function actions()
 * {
 *     return [
 *         // Another definition.
 *         'test-session' => [
 *             'class' => \umbalaconmeogia\ssosubdomain\actions\TestSessionAction::class,
 *         ],
 *     ];
 * }
 * </pre>
 * @author thanh
 *
 */
class TestSessionAction extends Action
{
    /**
     * View of test session.
     * @var string
     */
    public $view = '@vendor/umbalaconmeogia/ssosubdomain/views/testSession';

    public function run()
    {
        $key = 'testSession';
        $setValue = Yii::$app->request->post($key);
        if ($setValue) {
            Yii::$app->session[$key] = $setValue;
        }

        return $this->controller->render($this->view);
    }
}