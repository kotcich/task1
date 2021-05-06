<?php


namespace app\controllers;


use app\models\Menu;
use app\models\Menu_role;
use app\models\Role;
use yii\web\Controller;
use Yii;
use yii\web\Request;

class MainController extends Controller
{
    public $layout   = 'basic';

    public function actionIndex()
    {
        $this->view->title = 'Админка';

        $request    = Yii::$app->request;
        $menu       = new Menu();
        $role       = new Role();
        $menu_table = json_decode($this->actionShowMenu());
        $role_table = json_decode($this->actionShowRole());

        return $this->render('index', compact(['menu', 'role', 'menu_table', 'role_table']));
    }

    // Формирование таблицы менюшек
    public function actionShowMenu()
    {
        $request = Yii::$app->request;

        $arr  = Menu::find()->with('roles')->select(['id', 'title'])->asArray()->where('status=1')->all();

        $table = '<tr><th>Пункт меню</th><th>Привязанные роли</th><th></th></tr>';

        foreach ($arr as $elem) {
            $table .= "<tr><td>{$elem['title']}</td><td>";

            foreach ($elem['roles'] as $role) {
                $table .=  "<span class = 'values'>{$role['title']}</span>";
            }

            $table .= "</td><td><input type= 'submit' class = 'change change_menu_btn' value = 'изменить' 
                          data-id = '{$elem['id']}' data-title = '{$elem['title']}'></td></tr>";
        }

        return json_encode($table);
    }

    // Формирование таблицы ролей
    public function actionShowRole()
    {
        $request = Yii::$app->request;

        if ($request->isGet) {
            $arr  = Role::find()->with('menus')->select(['id', 'title'])->asArray()->where('status=1')->all();

            $table = '<tr><th>Роль пользователя</th><th>Пункты меню</th><th></th></tr>';

            foreach ($arr as $elem) {
                $table .= '<tr><td>' . $elem['title'] . '</td><td>';

                foreach ($elem['menus'] as $menu) {
                    $table .=  '<span class = \'values\'>' . $menu['title'] . '</span>';
                }

                $table .= "</td><td><input type= 'submit' class = 'change' value = 'изменить' 
                           data-id = \"{$elem['id']}\"></td></tr>";
            }

            return json_encode($table);
        }
    }

    // Вывод ролей в видео кнопок для формы
    public function actionAllRoles()
    {
        $request = Yii::$app->request;

        if ($request->get()) {
            $buttons = '';
            $arr     = Role::find()->with('menu_role')->asArray()->all();  // Получаю все роли и их связи

            // Формирую кнопки
            foreach ($arr as $elem) {
                $set = false;

                foreach ($elem['menu_role'] as $item) {
                    if ($item['menu_id'] == $request->get('id')) {
                        $set = true;
                    }
                }

                if ($set === true) {
                    $buttons .= "<span class = 'edit edit_set'
                      data-id = '". $elem['id'] ."' data-edit = '1'>{$elem['title']}</span><br>";
                } else {
                    $buttons .= "<span class = 'edit edit_unset'
                      data-id = '". $elem['id'] ."' data-edit = '0'>{$elem['title']}</span><br>";
                }
            }
            return json_encode($buttons);
        }
    }

    // Изменяю связи c Менюшкой
    public function actionUpdateMenu()
    {
        $request  = Yii::$app->request;
        $roles_id = [];

        if($request->get()) {
            $menu       = Menu::find()->where(['title' => $request->get('title')])->one();
            $id         = $menu->id;
            $menu_roles = Menu_role::find()->where(['menu_id' => $id])->all();

            // Меняю title, если его изменили
            if ($request->get('title') != $request->get('titleNew')) {
                $menu->title = $request->get('titleNew');
                $menu->save();
            }

            // Если есть связь, но она мягко удалена, то меняю ее статус
            foreach ($menu_roles as $menu_role) {
                if ($request->get('nums')) {
                    $nums = explode(',', $request->get('nums'));

                    // Востанавливаю связь, после мягко удаления
                    foreach ($nums as $num) {
                        if ($menu_role->status == -1 and $num == $menu_role->role_id) {
                            $menu_role->status = 1;
                            $menu_role->save();
                            break;
                        }
                    }

                    // Мягко удаляю существующую связь
                    if ($menu_role->status == 1 and !in_array($menu_role->role_id, $nums)) {
                        $menu_role->status = -1;
                        $menu_role->save();
                    }
                } else {
                    // Если в GET nums нет элементов, значит мягко удалить все существующие связи с менюшкой
                    $menu_role->status = -1;
                    $menu_role->save();
                }

                $roles_id[] = $menu_role->role_id;
            }

            // Создание связи, если ее нет
            if ($request->get('nums')) {
                foreach ($nums as $index) {
                    if (!in_array($index, $roles_id)) {
                        $new_menu_role = new Menu_role();
                        $new_menu_role->menu_id = $id;
                        $new_menu_role->role_id = $index;
                        $new_menu_role->save();
                    }
                }
            }

            return $this->actionShowMenu();  // Формирую таблицу
        }
    }
}