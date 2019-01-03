<?php
use yii\base\Widget;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use mdm\admin\components\MenuHelper;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => '路由', 'icon' => 'dashboard', 'url' => 'admin/route'],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => '权限管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                        	[
                                'label' => '角色管理',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => '角色列表', 'icon' => 'dashboard', 'url' => 'role/list'],
                                    ['label' => '新增角色', 'icon' => 'circle-o', 'url' => 'role/add',],
                                ],
                            ],
                            [
                                'label' => '用户管理',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => '用户列表', 'icon' => 'dashboard', 'url' => 'user/list'],
                                    ['label' => '新增用户', 'icon' => 'circle-o', 'url' => 'user/add',],
                                ],
                            ],
                            [
                                'label' => '配置管理',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => '菜单管理', 'icon' => 'dashboard', 'url' => 'menu/list'],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
