<?php
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
// @var $this yii\web\View
$this->registerJsFile("@web/js/main.js");
$this->title = 'My Yii Application';
?>
<div class="site-index container-fluid">
<div class="row">
    <div class="col-md-3">
    <select id="selectRole">
        <option value="0"> Выберите роль</option>
    </select>
    <h3>MENU</h3>
    <div id="pages">
    <ul>
        <li>PAGE 1</li>
        <li>PAGE 2</li>
    </ul>
    </div>
    </div>
    <div class="col-md-9">
    <button>ROLES</button> <button>MENUES</button>
    
    <table width = "100%" id="action_table"  border="1">
    <tr>
    <th>ID</th>
    <th>TITLE</th>
    <th>STATUS</th>
    <th>ACTION</th>
    </tr>
    </table>
    <button onclick="addRole()">ADD ROLE</button> <button onclick="addMenu()">ADD MENU</button>
    </div>
    
</div>
</div>
<div id="modal-dialog">
<h2 id="modal-title">LOADNG...</h2>
<input name="modal-input" type="text" placeholder="INPUT DATA" value=""><br>
<select id="modal-menu">
    <option value="0">Нет родителя</option>
</select>
<div id="modal-select" style="border:1px solid black;">
    <label><input type="checkbox"> Связь 1</label>
</div>
<button class= "select-all-btn">SELECT ALL</button><br>
<div class="wrapper-action-btn">
    <button>SAVE</button>
    <button onclick="showHideModal()">CANCEL</button>
</div>
</div>
