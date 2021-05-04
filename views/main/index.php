<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->registerJsFile('https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js', ['position' => $this::POS_HEAD]);
$this->registerJsFile('/js/sctipt.js');
?>

<main>
    <div class = 'wrapper'>
        <div class = 'for_btn'>
            <?= Html::submitButton('Пункты меню', ['id' => 'menu_btn']) ?>
            <?= Html::submitButton('Роли', ['id' => 'role_btn']) ?>
        </div>
        <table id = 'table'></table>
    </div>
</main>