<div id="backend-navbar">
<?php
Yii::import('p3pages.modules.*');

$rootNode = P3Page::model()->findByAttributes(array('name_id' => 'Navbar'));
$page = P3Page::getActivePage();
if ($page !== null) {
    $translation = $page->getTranslationModel();
} else {
    $translation = null;
}

$this->widget(
    'TbNavbar',
    array(
         'fluid'    => true,
         'fixed'    => 'bottom',
         'brand'    => false,
         'collapse' => false,
         'items'    => array(
             array(
                 'class'       => 'TbMenu',
                 'htmlOptions' => array('class' => ''),
                 'items'       => array(
                     array(
                         'label' => Yii::app()->name,
                         'icon'  => 'home white',
                         'url'   => Yii::app()->homeUrl,
                     ),
                 )
             ),
             array(
                 'class'       => 'TbMenu',
                 'htmlOptions' => array('class' => ''),
                 'items'       => array(
                     array(
                         'label' => Yii::app()->language,
                         'icon'  => 'globe white',
                         'url'   => '#',
                         'items' => Controller::getLanguageMenuItems()
                     ),
                     array(
                         'label'   => ucfirst(Yii::app()->user->name),
                         'visible' => !Yii::app()->user->isGuest,
                         'icon'    => 'user white',
                         'items'   => array(
                             array(
                                 'label'   => Yii::t('app', 'Profile'),
                                 'icon'    => 'tasks',
                                 'url'     => array('/user/profile'),
                                 'visible' => !Yii::app()->user->isGuest
                             ),
                             array(
                                 'label'   => Yii::t('app', 'User List'),
                                 'icon'    => 'group',
                                 'url'     => array('/user/default/index'),
                                 'visible' => !Yii::app()->user->isGuest
                             ),
                             array(
                                 'label'   => Yii::t('app', 'Logout'),
                                 'icon'    => 'lock',
                                 'url'     => array('/site/logout'),
                                 'visible' => !Yii::app()->user->isGuest
                             ),
                         )
                     ),
                     array(
                         'label'   => Yii::t('app', 'Login'),
                         'url'     => Yii::app()->user->loginUrl,
                         'visible' => Yii::app()->user->isGuest,
                         'icon'    => 'lock white'
                     ),
                     array(
                         'icon'        => 'edit white',
                         'url'         => '',
                         'visible'     => Yii::app()->user->checkAccess('Editor'),
                         'itemOptions' => array(
                             "id"    => "P3WidgetContainerShowControls",
                             'class' => 'edit',
                         )
                     ),

                 )
             ),
             array(
                 'class'       => 'TbMenu',
                 'htmlOptions' => array('class' => 'pull-right'),
                 'items'       => array(
                     array(
                         'label' => 'Phundament',
                         'url'   => array('/p3admin/default/index'),
                         'icon'  => 'heart white',
                         'items' => array(
                             array('label' => Yii::t('app', 'User')),
                             array(
                                 'label'   => Yii::t('app', 'Accounts'),
                                 'icon'    => 'user',
                                 'url'     => array('/user/admin/admin'),
                                 'visible' => Yii::app()->user->checkAccess('Admin')
                             ),
                             '---',
                             array(
                                 'label' => Yii::t('app', 'Media'),
                             ),
                             array(
                                 'label'   => Yii::t('app', 'Upload'),
                                 'icon'    => 'upload',
                                 'url'     => array('/p3media/import/upload'),
                                 'visible' => Yii::app()->user->checkAccess('P3media.Import.*')
                             ),
                             array(
                                 'label'   => Yii::t('app', 'Browse'),
                                 'icon'    => 'th ',
                                 'url'     => array('/p3media'),
                                 'visible' => Yii::app()->user->checkAccess('P3media.Default.*')
                             ),
                             '---',
                             array(
                                 'label' => Yii::t('app', 'Pages'),
                             ),
                             array(
                                 'label'   => Yii::t('app', 'Translation'),
                                 'icon'    => 'pencil ',
                                 'url'     => array(
                                     '/p3pages/p3PageTranslation/create',
                                     'returnUrl'         => getenv('REQUEST_URI'),
                                     'P3PageTranslation' => array(
                                         'p3_page_id' => ($page) ? $page->id : null,
                                         'language'   => Yii::app()->language
                                     )
                                 ),
                                 'visible' => Yii::app()->user->checkAccess(
                                     'P3pages.P3PageTranslation.*'
                                 ) && $page && !$translation
                             ),
                             array(
                                 'label'   => Yii::t('app', 'Append Child Page'),
                                 'icon'    => 'plus ',
                                 'url'     => array(
                                     '/p3pages/p3Page/create',
                                     'returnUrl'  => getenv('REQUEST_URI'),
                                     'P3Page' => array(
                                         'tree_parent_id' => ($page) ? $page->id : null,
                                     )
                                 ),
                                 'visible' => Yii::app()->user->checkAccess('P3pages.P3Page.*') && $page
                             ),
                             array(
                                 'label'   => Yii::t('app', 'Append Sibling Page'),
                                 'icon'    => 'plus-sign ',
                                 'url'     => array(
                                     '/p3pages/p3Page/create',
                                     'returnUrl'  => getenv('REQUEST_URI'),
                                     'P3Page' => array(
                                         'tree_parent_id' => ($page && $page->getParent()) ? $page->getParent()->id :
                                             null
                                     )
                                 ),
                                 'visible' => Yii::app()->user->checkAccess('P3pages.P3Page.*') && $page
                             ),
                             array(
                                 'label'   => Yii::t('app', 'Sitemap'),
                                 'icon'    => 'list ',
                                 'url'     => array('/p3pages'),
                                 'visible' => Yii::app()->user->checkAccess('P3pages.Default.*')
                             ),
                             array(
                                 'label'   => Yii::t('app', 'Translation'),
                                 'icon'    => 'flag ',
                                 'url'     => array(
                                     '/p3pages/p3PageTranslation/update',
                                     'returnUrl' => getenv('REQUEST_URI'),
                                     'id'        => ($translation) ? $translation->id : null
                                 ),
                                 'visible' => Yii::app()->user->checkAccess(
                                     'P3pages.P3PageTranslation.*'
                                 ) && $page && $translation
                             ),
                             array(
                                 'label'   => Yii::t('app', 'Template'),
                                 'icon'    => 'wrench ',
                                 'url'     => array(
                                     '/p3pages/p3Page/update',
                                     'id'        => ($page) ? $page->id : null,
                                     'returnUrl' => getenv('REQUEST_URI')
                                 ),
                                 'visible' => Yii::app()->user->checkAccess('P3pages.P3PageTranslation.*') && $page
                             ),

                             '---',
                             array(
                                 'label'   => Yii::t('app', 'Overview'),
                                 'icon'    => 'cog',
                                 'url'     => array('/p3admin/default/overview'),
                                 'visible' => Yii::app()->user->checkAccess('Admin')
                             ),
                             array(
                                 'label'   => Yii::t('app', 'Dashboard'),
                                 'icon'    => 'cog',
                                 'url'     => array('/p3admin/default/index'),
                                 'visible' => Yii::app()->user->checkAccess('Editor'),

                             ),
                         )
                     ),
                 )
             ),
         )
    )
);
?>
</div>