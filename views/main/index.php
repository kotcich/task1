<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
//$this->registerJsFile('https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js', ['position' => $this::POS_HEAD]);
$this->registerJsFile('/js/sctipt.js');
?>

<main id = 'main'>
    <div class = 'wrapper'>

        <p class = 'for_btn'>
            <?= Html::submitButton('Пункты меню', ['id' => 'menu_btn']) ?>
            <?= Html::submitButton('Роли', ['id' => 'role_btn']) ?>
        </p>

        <table id = 'menu_table'><?= $menu_table ?></table>
        <table id = 'role_table'><?= $role_table ?></table>
    </div>
</main>

<div id = 'menu_change_form_wrapper'>
    <p><b id = 'menu_change_title_form'></b></p>

    <?php $form = ActiveForm::begin(['id' => 'change_menu_form', 'method' => 'get']) ?>
    <?= $form->field($menu, 'title')->textInput(['id' => 'menu_change_title_input']) ?>

    <div id = 'menu_change_buttons'></div>
    <span id = 'menu_change_all'>Выбрать все</span>

    <div>
        <?= Html::submitButton('Сохранить', ['id' => 'save_change_menu']) ?>
        <span id = 'cancel_change_menu'>Отмена</span>
    </div>
    <?php ActiveForm::end() ?>
</div>

<div id = 'role_change_form_wrapper'>
    <p><b id = 'role_change_title_form'></b></p>

    <?php $form = ActiveForm::begin(['id' => 'change_role_form', 'method' => 'get']) ?>
    <?= $form->field($role, 'title')->textInput(['id' => 'role_change_title_input']) ?>

    <div id = 'role_change_buttons'></div>
    <span id = 'role_change_all'>Выбрать все</span>

    <div>
        <?= Html::submitButton('Сохранить', ['id' => 'save_change_role']) ?>
        <span id = 'cancel_change_role'>Отмена</span>
    </div>
    <?php ActiveForm::end() ?>
</div>