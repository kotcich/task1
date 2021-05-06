<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
//$this->registerJsFile('https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js', ['position' => $this::POS_HEAD]);
$this->registerJsFile('/js/sctipt.js');
?>

<main id = 'main'>
    <div class = 'wrapper'>

        <div class = 'for_btn'>
            <?= Html::submitButton('Пункты меню', ['id' => 'menu_btn']) ?>
            <?= Html::submitButton('Роли', ['id' => 'role_btn']) ?>
        </div>

        <table id = 'menu_table'><?= $menu_table ?></table>
        <table id = 'role_table'><?= $role_table ?></table>
    </div>
</main>

<div id = 'menu_form_wrapper'>
    <p><b id = 'menu_title_form'></b></p>

    <?php $form = ActiveForm::begin(['id' => 'change_menu_form', 'method' => 'get']) ?>

    <?= $form->field($menu, 'title')->textInput(['id' => 'menu_title_input']) ?>

    <div id = 'menu_buttons'></div>

    <?= Html::submitButton('Сохранить', ['id' => 'save']) ?>

    <span id = 'cancel'>Отмена</span>

    <?php ActiveForm::end() ?>
</div>