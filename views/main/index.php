<?php
use yii\helpers\Html;
$this->registerJsFile('/js/sctipt.js');
?>

<main id = 'main'>
    <div class = 'wrapper'>
        <div id = 'for_selector'>
            <?= $select ?>
            <span id = 'tree_name' style = 'display: none;'></span>
            <ul id = 'tree' style = 'display: none;'></ul>
        </div>

        <p class = 'for_btn'>
            <?= Html::submitButton('Пункты меню', ['id' => 'menu_btn', 'onclick' => 'showMenu()']) ?>
            <?= Html::submitButton('Роли', ['id' => 'role_btn', 'onclick' => 'showRole()']) ?>
        </p>

        <table id = 'table'></table>
        <input type = 'submit' id = 'create_menu' style = 'display: none' onclick = 'openCreateMenu()' value = 'Создать пункт меню'>
        <input type = 'submit' id = 'create_role' style = 'display: none' onclick = 'openCreateRole()' value = 'Создать роль'>
    </div>
</main>

<div id = 'form' style="display: none;">
    <p><b id = 'form_name'></b></p>
    <input id = 'form_title'>

    <div id = 'form_buttons'></div>
    <span id = 'all' onclick = 'setAll()'>Выбрать все</span>
    <select id = 'parents' style = 'display: none;'></select>

    <div>
        <input type="submit" id = 'save' value = 'Сохранить'>
        <span id = 'cancel' onclick = 'cancelForm()'>Отмена</span>
    </div>
</div>