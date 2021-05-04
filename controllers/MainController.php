<?php


namespace app\controllers;


use app\models\Menu;
use app\models\Menu_role;
use app\models\Role;
//use yii\debug\models\search\Db;
use yii\web\Controller;
use Yii;
use yii\web\Request;

class MainController extends Controller
{
    public $layout = 'basic';

    public function actionIndex()
    {
        $this->view->title = 'Админка';
        $request = Yii::$app->request;
        $menu = new Menu();
        $role = new Role();
        $menu_role = new Menu_role();

//        if ($role->load($request->post())) {
//            $role->save();
//            $this->refresh();
//        }

//        if ($menu->load($request->post())) {
//            $menu->save();
//
//            $menu_role->menu_id = $menu->id;
//            $menu_role->role_id = 2;
//            $menu_role->save();
//
//            $this->refresh();
//        }

        return $this->render('index', compact(['menu', 'role']));
    }

    public function actionShowMenu()
    {
        $request = Yii::$app->request;

        if ($request->isGet) {
            $arr  = Menu::find()->with('roles')->asArray()->where('status!=-1')->all();

            $table = '<tr><th>Роль пользователя</th><th>Пункт меню</th><th></th></tr>';

            foreach ($arr as $elem) {
                $table .= '<tr><td>' . $elem['title'] . '</td><td>';

                foreach ($elem['roles'] as $menu) {
                    $table .=  '<span class = \'values\'>' . $menu['title'] . '</span>';
                }

                $table .= '</td><td><input type=\'submit\' class = \'change\' value = \'изменить\'></td></tr>';
            }

            return json_encode($table);
        }
    }

    public function actionShowRole()
    {
        $request = Yii::$app->request;

        if ($request->isGet) {
            $arr  = Role::find()->with('menus')->asArray()->where('status!=-1')->all();

            $table = '<tr><th>Пункт меню</th><th>Привязанные роли</th><th></th></tr>';

            foreach ($arr as $elem) {
                $table .= '<tr><td>' . $elem['title'] . '</td><td>';

                foreach ($elem['menus'] as $menu) {
                    $table .=  '<span class = \'values\'>' . $menu['title'] . '</span>';
                }

                $table .= '</td><td><input type=\'submit\' class = \'change\' value = \'изменить\'></td></tr>';
            }

            return json_encode($table);
        }
    }
}