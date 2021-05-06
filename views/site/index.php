<?php
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
// @var $this yii\web\View

$this->title = 'My Yii Application';
$js = <<<JS
    fetch("/role/getall").then(
        function (response){
            response.json().then(function(data) {
            var table = document.getElementById('role_table');
            data.forEach((element) => {
                let e = document.createElement("tr");
                e.innerHTML += "<td>"+ element.id +"</td>";
                e.innerHTML += "<td>"+ element.title +"</td>";
                e.innerHTML += "<td>"+ element.status +"</td>";
                e.innerHTML += "<td>"+ element.created_at +"</td>";
                e.innerHTML += "<td>"+ element.updated_at +"</td>";
                table.appendChild(e);
            });
        });
    });
JS;
$this->registerJs($js);
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>
        <?php $f = ActiveForm::begin([
            'action' => Yii::$app->urlManager->createUrl(['role/add']),
            'id' => "test-form"
        ]); ?>
        <?=$f->field($form, 'title')?>
        <?=Html::submitButton("SEND")?>
        <?php ActiveForm::end(); ?>
        </div>

    <table id="role_table"  border="1">
    <tr>
    <th>ID</th>
    <th>TITLE</th>
    <th>STATUS</th>
    <th>UPDATED</th>
    <th>ADDED</th>
    </tr>
    </table>
</div>
