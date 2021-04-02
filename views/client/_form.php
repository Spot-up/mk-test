<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Clients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clients-form">

    <?php $form = ActiveForm::begin([
        'id' => 'client-create-form',
    ]); ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model,'phone')->widget(MaskedInput::className(),['mask'=>'+7 (999) 999-99-99'])->textInput(['placeholder'=>'+7 (999) 999-99-99']);?>

    <?= $form->field($model, 'agreement')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['id' => 'submit-btn', 'class' => 'btn btn-success']) ?>
        <span id='seconds' style='display:none'></span>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
    Modal::begin([
        'header' => '<h4>Ответ сервера</h4>',
        'id' => 'modal',
    ]);

    echo "<div id='modalContent'></div>";

    Modal::end();
?>

<?php
$js =
<<<JS
function delay(sec) {
    var _Seconds = sec,
      int;
    $('#seconds').text(_Seconds);
    $("#submit-btn").hide();
    $("#seconds").show();
    int = setInterval(function() { // запускаем интервал
      if (_Seconds > 1) {
        _Seconds--; // вычитаем 1
        $('#seconds').text(_Seconds); // выводим получившееся значение в блок
      } else {
        clearInterval(int); // очищаем интервал, чтобы он не продолжал работу при _Seconds = 0
        $("#submit-btn").show();
        $("#seconds").hide();
        $('#seconds').text(sec, int);
      }
    }, 1000);
}

$('#client-create-form').on('beforeSubmit', function() {
    var form = $(this);
    var data = form.serialize();
    $.ajax({
        url: '/client/create',
        type: 'POST',
        data: data
    })
    .done(function(data) {
        if (data.success) {
            $('#modalContent').text(JSON.stringify(data.message));
            $('#modal').modal('show');
            form[0].reset();
            delay(20);            
        }
        else {
            var errors = data.message;

            var errorsList = '<ul>';
            for (var key in errors) {
                errorsList += '<li>' + errors[key]+'</li>';
            }
            errorsList += '</ul>'

            console.log(errorsList);
        }
    })
    .fail(function () {
        alert('Произошла ошибка при отправке данных!');
    })
    return false;
});
JS;

$this->registerJs($js, $this::POS_READY);
?>