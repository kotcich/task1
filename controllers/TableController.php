<?php


namespace app\controllers;
use app\models\Menu;
use app\models\Role;

use yii\web\Controller;
use Yii;

class TableController extends Controller
{
    // Таблица менюшек
    public function actionShowMenu()
    {
        $arr = Menu::find()->with('roles')->select(['id', 'title'])->asArray()->where('status=1')->all();

        $table = '<tr><th>Пункт меню</th><th>Привязанные роли</th><th></th></tr>';

        foreach ($arr as $elem) {
            $table .= "<tr><td>{$elem['title']}</td><td>";

            foreach ($elem['roles'] as $role) {
                $table .=  "<span class = 'values'>{$role['title']}</span>";
            }

            $table .= "</td><td><input type= 'submit' class = 'change' onclick = 'openFormMenu(this)' value = 'изменить' 
                          data-id = '{$elem['id']}' data-title = '{$elem['title']}'></td></tr>";
        }

        return json_encode($table);
    }

    // Таблица ролей
    public function actionShowRole()
    {
        $arr = Role::find()->with('menus')->select(['id', 'title'])->asArray()->where('status=1')->all();

        $table = '<tr><th>Роль пользователя</th><th>Пункты меню</th><th></th></tr>';

        foreach ($arr as $elem) {
            $table .= "<tr><td>{$elem['title']}</td><td>";

            foreach ($elem['menus'] as $menu) {
                $table .= "<span class = 'values'>{$menu['title']}</span>";
            }

            $table .= "</td><td><input type= 'submit' class = 'change' value = 'изменить' onclick = 'openFormRole(this)'
                          data-id = '{$elem['id']}' data-title = '{$elem['title']}'></td></tr>";
        }

        return json_encode($table);
    }

    // Список под селектором
    public function actionTree()
    {
        $request = Yii::$app->request;

        if ($request->get()) {
            $ul   = '';

            if ($request->get('title') == 'Роль') {  // Все роли и их менюшки с детьми
                $tree = Menu::find()->select(['id', 'title'])->asArray()->where('status=1')->all();

                foreach ($tree as $menu) {
                    $sub_tree = Menu::find()->select('title')->asArray()->where(['menu_id' => $menu['id']])->all();

                    if ($sub_tree) {
                        $ul .= "<li>{$menu['title']}<ul id = 'sub_tree'>";

                        foreach ($sub_tree as $sub) {
                            $ul .= "<li>{$sub['title']}</li>";
                        }

                        $ul .= '</ul></li>';
                    } else {
                        $ul .= "<li>{$menu['title']}</li>";
                    }
                }
            } else {  // Конкретная роль и ее менюшки с детьми
                $tree = Role::find()->where(['title' => $request->get('title')])->with('menus')->asArray()->all();

                foreach ($tree[0]['menus'] as $menu) {
                    $sub_tree = Menu::find()->select('title')->asArray()->where(['menu_id' => $menu['id']])->all();

                    if ($sub_tree) {
                        $ul .= "<li>{$menu['title']}<ul id = 'sub_tree'>";

                        foreach ($sub_tree as $sub) {
                            $ul .= "<li>{$sub['title']}</li>";
                        }

                        $ul .= '</ul></li>';
                    } else {
                        $ul .= "<li>{$menu['title']}</li>";
                    }
                }
            }
        }

        return json_encode($ul);  // формирую список под селектором
    }

    // Родителя для менюшки
    public function actionParents()
    {
        $request = Yii::$app->request;

        if ($request->get()) {
            $menu_id = Menu::find()->select('menu_id')->where(['title' => $request->get('child')])
                ->asArray()->all();
            $link = Menu::find()->select(['id', 'title'])->where(['id' => $menu_id[0]['menu_id']])->asArray()->all();

            // Ставлю первой опцией имеющегося родителя менюшки, если она есть
            if ($link) {
                $options = "<option data-id = '{$link[0]['id']}'>{$link[0]['title']}</option></option><option>Нет</option>";
            } else {
                $options = '<option>Нет</option>';
            }

            if ($request->get('child') == 'нет') {
                $parents = Menu::find()->select(['id', 'title'])->where('status=1')->asArray()->all();

                foreach ($parents as $parent) {
                    $options .= "<option data-id = '{$parent['id']}'>{$parent['title']}</option>";
                }
            } else {
                $parents = Menu::find()->select(['id', 'title'])->where(['!=', 'title', $request->get('child')])
                    ->andWhere('status=1')->asArray()->all();

                foreach ($parents as $parent) {
                    $options .= "<option data-id = '{$parent['id']}'>{$parent['title']}</option>";
                }
            }
        }

        return json_encode($options);
    }
}