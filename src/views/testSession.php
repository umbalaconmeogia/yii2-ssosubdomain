<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
?>
<div class="country-form">

    <?php ActiveForm::begin(); ?>

    <?= Html::textInput('testSession') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <hr />
    <h2>Session</h2>
    <pre>
	    <?= print_r($_SESSION, true) ?>
    </pre>
    <h2>Cookies (including root domain)</h2>
    <pre>
	    <?= print_r($_COOKIE, true) ?>
    </pre>
</div>
