<?php use yii\helpers\Url;?>
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
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => Yii::t('backend','Dashboard'), 'options' => ['class' => 'header']],
                    ['label' => Yii::t('backend','Sumary'), 'icon' => 'fa fa-tachometer', 'url' => ['/gii']],
                    ['label' => Yii::t('backend','Reports'), 'icon' => 'fa fa-bar-chart', 'url' => ['/gii']],
                    ['label' => Yii::t('backend','Functions'), 'options' => ['class' => 'header']],
                    ['label' => Yii::t('backend','Sales'), 'icon' => 'fa fa-file-code-o', 'url' => ['/invoice']],
                    ['label' => Yii::t('backend','Receivings'), 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                    ['label' => Yii::t('backend','Store Management'), 'options' => ['class' => 'header']],
                    ['label' => Yii::t('backend','Suppliers'), 'icon' => 'fa fa-dashboard', 'url' => ['/supplier']],
                    ['label' => Yii::t('backend','Customers'), 'icon' => 'fa fa-dashboard', 'url' => ['/customer']],
                    ['label' => Yii::t('backend','Products'), 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                    [
                        'label' => 'Same tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'fa fa-circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
