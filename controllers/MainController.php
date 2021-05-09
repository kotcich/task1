<?php


namespace app\controllers;


use app\controllers\TableController;
use app\models\Menu;
use app\models\Menu_role;
use app\models\Role;
use yii\web\Request;
use Yii;

class MainController extends TableController
{
    public $layout = 'basic';

    public function actionIndex()
    {
        $roles  = Role::find()->select('title')->asArray()->where('status=1')->all();
        $select = "<select id = 'select' onchange = 'tree(this)'><option>Роль</option>";

        foreach ($roles as $role) {
            $select .= "<option>{$role['title']}</option>";
        }

        $select .= '</select>';

        return $this->render('index', compact('select'));
    }

    // Вывод ролей в виде кнопок для формы
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
                        break;
                    }
                }

                if ($set === true) {
                    $buttons .= "<span class = 'edit edit_set'
                      data-id = '{$elem['id']}' data-edit = '1' onclick = 'set(this)'>{$elem['title']}</span><br>";
                } else {
                    $buttons .= "<span class = 'edit edit_unset'
                      data-id = '{$elem['id']}' data-edit = '0' onclick = 'set(this)'>{$elem['title']}</span><br>";
                }
            }

            return json_encode($buttons);
        }
    }

    // Вывод менюшек в видео кнопок для формы
    public function actionAllMenus()
    {
        $request = Yii::$app->request;

        if ($request->get()) {
            $buttons = '';
            $arr     = Menu::find()->with('menu_role')->asArray()->all();  // Получаю все роли и их связи

            // Формирую кнопки
            foreach ($arr as $elem) {
                $set = false;

                foreach ($elem['menu_role'] as $item) {
                    if ($item['role_id'] == $request->get('id')) {
                        $set = true;
                        break;
                    }
                }

                if ($set === true) {
                    $buttons .= "<span class = 'edit edit_set' onclick = 'set(this)'
                      data-id = '{$elem['id']}' data-edit = '1'>{$elem['title']}</span><br>";
                } else {
                    $buttons .= "<span class = 'edit edit_unset' onclick = 'set(this)'
                      data-id = '{$elem['id']}' data-edit = '0'>{$elem['title']}</span><br>";
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
            }

            // Назначаю родителя менюшки
            if ($request->get('parent')) {
                $menu_id = Menu::find()->select('id')->where(['title' => $request->get('parent')])->asArray()->one();
                $menu->menu_id = $menu_id['id'];
            }

            $menu->save();

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
                $nums = explode(',', $request->get('nums'));

                foreach ($nums as $index) {
                    if (!in_array($index, $roles_id)) {
                        $new_menu_role = new Menu_role();
                        $new_menu_role->menu_id = $id;
                        $new_menu_role->role_id = $index;
                        $new_menu_role->status  = 1;
                        $new_menu_role->save();
                    }
                }
            }

            return parent::actionShowMenu();  // Формирую таблицу
        }
    }

    // Изменяю связи c Ролью
    public function actionUpdateRole()
    {
        $request  = Yii::$app->request;
        $roles_id = [];

        if($request->get()) {
            $role       = Role::find()->where(['title' => $request->get('title')])->one();
            $id         = $role->id;
            $menu_roles = Menu_role::find()->where(['role_id' => $id])->all();

            // Меняю title, если его изменили
            if ($request->get('title') != $request->get('titleNew')) {
                $role->title = $request->get('titleNew');
                $role->save();
            }

            // Если есть связь, но она мягко удалена, то меняю ее статус
            foreach ($menu_roles as $menu_role) {
                if ($request->get('nums')) {
                    $nums = explode(',', $request->get('nums'));

                    // Востанавливаю связь, после мягко удаления
                    foreach ($nums as $num) {
                        if ($menu_role->status == -1 and $num == $menu_role->menu_id) {
                            $menu_role->status = 1;
                            $menu_role->save();
                            break;
                        }
                    }

                    // Мягко удаляю существующую связь
                    if ($menu_role->status == 1 and !in_array($menu_role->menu_id, $nums)) {
                        $menu_role->status = -1;
                        $menu_role->save();
                    }
                } else {
                    // Если в GET nums нет элементов, значит мягко удалить все существующие связи с менюшкой
                    $menu_role->status = -1;
                    $menu_role->save();
                }

                $menus_id[] = $menu_role->menu_id;
            }

            // Создание связи, если ее нет
            if ($request->get('nums')) {
                $nums = explode(',', $request->get('nums'));

                foreach ($nums as $index) {
                    if (!in_array($index, $menus_id)) {
                        $new_menu_role = new Menu_role();
                        $new_menu_role->role_id = $id;
                        $new_menu_role->menu_id = $index;
                        $new_menu_role->save();
                    }
                }
            }

            return parent::actionShowRole();  // Формирую таблицу
        }
    }

    // Создаю менюшку
    public function actionCreateMenu()
    {
        $request = Yii::$app->request;

        if ($request->get()) {
            $menu        = new Menu();
            $menu->title = $request->get('title');

            if ($request->get('parent')) {
                $id = Menu::find()->select('id')->where(['title' => $request->get('parent')])->asArray()->all();
                $menu->menu_id = $id[0]['id'];
            }

            $menu->save();

            if ($request->get('nums')) {
                $nums = explode(',', $request->get('nums'));

                foreach ($nums as $num) {
                    $link = new Menu_role();
                    $link->menu_id = $menu->id;
                    $link->role_id = $num;
                    $link->status  = 1;
                    $link->save();
                }
            }
        }

        return parent::actionShowMenu();
    }

    // Создаю роль
    public function actionCreateRole()
    {
        $request = Yii::$app->request;

        if ($request->get()) {
            $role        = new Role();
            $role->title = $request->get('title');
            $role->save();

            if ($request->get('nums')) {
                $nums = explode(',', $request->get('nums'));

                foreach ($nums as $num) {
                    $link = new Menu_role();
                    $link->role_id = $role->id;
                    $link->menu_id = $num;
                    $link->status  = 1;
                    $link->save();
                }
            }
        }

        return parent::actionShowRole();
    }
}