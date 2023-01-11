<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
 * Copyright (c) 2023 by multiple authors                      *
 * Politechnika Śląska | Silesian University of Technology     *
 *                                                             *
 * Nazwa pliku: SessionHelper.php                              *
 * Projekt: restaurant-project-php-si                          *
 * Data utworzenia: 2023-01-05, 01:52:24                       *
 * Autor: Miłosz Gilga                                         *
 *                                                             *
<<<<<<< HEAD
 * Ostatnia modyfikacja: 2023-01-11 15:45:54                   *
 * Modyfikowany przez: Miłosz Gilga                            *
=======
 * Ostatnia modyfikacja: 2023-01-11 15:45:54                   *
 * Modyfikowany przez: Miłosz Gilga                            *
>>>>>>> 02a4e0244e98cb3ef22b8b709dadf24f2b7c1d74
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

namespace App\Services\Helpers;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class SessionHelper
{
    const LOGIN_PAGE_BANNER                 = 'login_page_banner';
    const FORGOT_PASSWORD_PAGE_BANNER       = 'forgot_password_page_banner';
    const REGISTER_PAGE_BANNER              = 'register_page_banner';
    const PENDING_RESTAURANT_PAGE_BANNER    = 'pending_restaurant_page_banner';
    const ADD_EDIT_DISH_PAGE_BANNER         = 'edit_dish_page_banner';
    const RESTAURANT_DETAILS_PAGE_BANNER    = 'restaurant_details_page_banner';
    const RESTAURANTS_PAGE_BANNER           = 'restaurants_page_banner';
    const ADD_EDIT_RESTAURANT_PAGE_BANNER   = 'add_edit_restaurant_page_banner';
    const LOGOUT_PAGE_BANNER                = 'logout_page_banner';
    const EDIT_USER_PROFILE_PAGE_BANNER     = 'edit_user_profile_page';
    const USER_PROFILE_PAGE_BANNER          = 'user_profile_page';
    const HOME_RESTAURANTS_LIST_PAGE_BANNER = 'home_restaurants_list_page';
    const ORDER_FINISH_PAGE                 = 'order_finish_page';
    const OWNER_RES_SEARCH                  = 'owner_restaurant_search';
    const OWNER_RES_DETAILS_SEARCH          = 'owner_restaurant_details_search';
    const OWNER_DISHES_SEARCH               = 'owner_dishes_search';
    const OWNER_DISHES_RES_SEARCH           = 'owner_dishes_res_search';
    const ADMIN_PENDING_RES_SEARCH          = 'admin_pending_res_search';
    const RES_MAIN_SEARCH                   = 'res_main_search';
    const CANCEL_ORDER                      = 'cancel_order';

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function check_session_and_unset($session_value_key)
    {
        $session_value = null;
        if (isset($_SESSION[$session_value_key]))
        {
            $session_value = $_SESSION[$session_value_key];
            unset($_SESSION[$session_value_key]);
        }
        return $session_value;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function create_session_banner($key, $message, $banner_error, $custom_baner_style = '')
    {
        if (empty($custom_baner_style)) $banner_class = $banner_error ? 'alert-danger' : 'alert-success';
        else $banner_class = $custom_baner_style;
        $_SESSION[$key] = array(
            'banner_message' => $message,
            'show_banner' => !empty($message),
            'banner_class' => $banner_class,
        );
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public static function persist_search_text($name, $key)
    {
        $search_text = '';
        if (isset($_POST[$name]))
        {
            $search_text = $_POST[$name];
            if (empty($search_text)) unset($_SESSION[$key]);
            else $_SESSION[$key] = $search_text;
        }
        else if (isset($_SESSION[$key])) $search_text = $_SESSION[$key];
        return $search_text;
    }
}