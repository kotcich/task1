<?php


namespace app\controllers;
use app\models\Menu;
use app\models\Role;

use yii\web\Controller;
use Yii;

class TableController extends Controller
{
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

            if ($request->get('title') == 'Роль') {
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
            } else {
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
            $options = '';

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