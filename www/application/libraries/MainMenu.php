<?php
defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Main Menu library. For manual menu generation.
 *
 * @copyright   Copyright (C) 2010 Ilya Semerhanov
 * @author      Ilya Semerhanov
 * @version     1.0
 * @package     MainMenu
 */


class MainMenu
{

        public function __construct()
	{
		

	}

        /**
         *
         * Create menu.
         */
       /* public static function Create()
        {
               $acl = new Acl();
               if($acl->logged_as('admin'))
               {
                       $menu = "<h2><a href='#'>Добавить</a></h2>
                                <div>
                                       <ul>
                                              <li>".html::anchor(url::base().'add/author','Автора')."</li>
                                              <li>".html::anchor(url::base().'add/org','Организацию')."</li>
                                              <li>".html::anchor(url::base().'add/publication','Публикацию')."</li>
                                              <li>".html::anchor(url::base().'add/publisher','Издательство')."</li>
                                              <li>".html::anchor(url::base().'add/issue','Издание')."</li>

                                        </ul>


                                </div>
                                <h2><a href='#'>Редактировать</a></h2>
                                <div>
                                           <ul>
                                               <li>".html::anchor(url::base().'edit/author','Автора')."</li>
                                               <li>".html::anchor(url::base().'edit/organization','Организацию')."</li>
                                               <li>".html::anchor(url::base().'edit/publisher','Издательство')."</li>
                                           </ul>
                                </div>";

                       echo $menu;
               }else
               {
                       echo 'No menu yet';
               }

        }*/

        public static function Create()
        {
               
               $acl = new Acl();
               $db  = new Publication_Model();
               $session                = Session::instance();
               $username = $session->get('username');
               $new_pubs = $db->get_new_publications_amount($username);

               if($new_pubs == 0)
               {
                       $pub_link = 'Публикации';
               }else
               {
                      $pub_link = 'Публикации <b>('.$new_pubs.')</b>';
               }
               $mod = uri::segment(1);
               $add = '';
               $edit ='';
               $user ='';
               $my ='';
               $finder = '';
               $admin = '';
               
               switch($mod)
               {
                       case 'add':
                               $add = 'show';
                               break;
                       case 'edit':
                              $my = 'show';
                               break;
                       case 'user':
                                $user = 'show';
                                break;
                       case 'my':
                                $my = 'show';
                                break;
                       case 'finder':
                                $user = 'show';
                                break;
                       case 'show':
                                $user = 'show';
                                break;
                       case 'admin':
                               $admin = 'show';
                               break;
                      
               }
               $role = $acl->role();
               if($role == 'admin')
               {

                       $menu = "
                               <li><a href='#'>Мой RefDB</a>
                                          <ul id='".$user."'>
                                               <li>".html::anchor(url::base().'user/home','Главная')."</li>
                                               <li>".html::anchor(url::base().'user/lib','Библиотека')."</li>
                                               <li>".html::anchor(url::base().'finder/searcher','Поиск')."</li>
                                               <li>".html::anchor(url::base().'user/profile','Настройки')."</li>

                                          </ul>

                                </li>
                               <li><a href='#'>Мои записи</a>
                                          <ul id='".$my."'>
                                               <li>".html::anchor(url::base().'my/publications',$pub_link)."</li>
                                               <li>".html::anchor(url::base().'edit/authors','Авторы')."</li>
                                               <li>".html::anchor(url::base().'edit/organizations','Организации')."</li>
                                               <li>".html::anchor(url::base().'edit/publishers','Издательства')."</li>
                                               <li>".html::anchor(url::base().'edit/issues','Издания')."</li>
                                           </ul>

                                </li>
                                <li><a href='#'>Добавить запись</a>
                                         <ul id = '".$add."'>
                                              <li>".html::anchor(url::base().'add/publication','Публикацию')."</li>
                                              <li>".html::anchor(url::base().'add/author','Автора')."</li>
                                              <li>".html::anchor(url::base().'add/org','Организацию')."</li>
                                              <li>".html::anchor(url::base().'add/publisher','Издательство')."</li>
                                              <li>".html::anchor(url::base().'add/issue','Издание')."</li>

                                        </ul>

                                </li>
                                <li><a href='#'>Администрирование</a>
                                         <ul id = '".$admin."'>
                                              <li>".html::anchor(url::base().'admin/users','Пользователи')."</li>
                                              <li>".html::anchor(url::base().'add/author','Ресурсы')."</li>
                                              <li>".html::anchor(url::base().'add/org','Авторы')."</li>
                                              <li>".html::anchor(url::base().'add/org','Мониторинг')."</li>
                                              <li>".html::anchor(url::base().'admin/sxd','Управление БД')."</li>
                                              <li>".html::anchor(url::base().'admin/mode','Режим разработки')."</li>
                                        </ul>

                                </li>


                                ";


                       echo $menu;
               }elseif ($role == 'user')
               {
                    

                       $menu = "
                               <li><a href='#'>Мой RefDB</a>
                                          <ul id='".$user."'>
                                               <li>".html::anchor(url::base().'user/home','Главная')."</li>
                                               <li>".html::anchor(url::base().'user/lib','Библиотека')."</li>
                                               <li>".html::anchor(url::base().'finder/searcher','Поиск')."</li>
                                               <li>".html::anchor(url::base().'user/profile','Настройки')."</li>
                                              
                                          </ul>

                                </li>
                               <li><a href='#'>Мои записи</a>
                                          <ul id='".$my."'>
                                               <li>".html::anchor(url::base().'my/publications',$pub_link)."</li>
                                               <li>".html::anchor(url::base().'edit/authors','Авторы')."</li>
                                               <li>".html::anchor(url::base().'edit/organizations','Организации')."</li>
                                               <li>".html::anchor(url::base().'edit/publishers','Издательства')."</li>
                                               <li>".html::anchor(url::base().'edit/issues','Издания')."</li>
                                           </ul>

                                </li>
                                <li><a href='#'>Добавить запись</a>
                                         <ul id = '".$add."'>
                                              <li>".html::anchor(url::base().'add/publication','Публикацию')."</li>
                                              <li>".html::anchor(url::base().'add/author','Автора')."</li>
                                              <li>".html::anchor(url::base().'add/org','Организацию')."</li>
                                              <li>".html::anchor(url::base().'add/publisher','Издательство')."</li>
                                              <li>".html::anchor(url::base().'add/issue','Издание')."</li>

                                        </ul>

                                </li>
                                ";

                       echo $menu;

               }else
               {
                       echo 'No menu yet';
               }

        }

}