<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
 * Copyright (c) 2023 by multiple authors                      *
 * Politechnika Śląska | Silesian University of Technology     *
 *                                                             *
 * Nazwa pliku: RestaurantsController.php                      *
 * Projekt: restaurant-project-php-si                          *
 * Data utworzenia: 2023-01-02, 21:40:28                       *
 * Autor: Miłosz Gilga                                         *
 *                                                             *
 * Ostatnia modyfikacja: 2023-01-11 15:42:29                   *
 * Modyfikowany przez: Miłosz Gilga                            *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

namespace App\Controllers;

use App\Core\MvcService;
use App\Core\MvcController;
use App\Core\ResourceLoader;
use App\Services\RestaurantsService;
use App\Services\Helpers\CookieHelper;
use App\Services\Helpers\SessionHelper;

ResourceLoader::load_service('RestaurantsService'); // ładowanie serwisu przy użyciu require_once

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class RestaurantsController extends MvcController
{
    private $_service; // instancja serwisu

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
    public function __construct()
    {
        parent::__construct();
		$this->_service = MvcService::get_instance(RestaurantsService::class); // stworzenie instancji serwisu
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Przejście pod adres: /restaurants/restaurant-details
     */
	public function restaurant_details()
    {
        $banner_data = SessionHelper::check_session_and_unset(SessionHelper::ORDER_FINISH_PAGE);
        if (!$banner_data) $banner_data = SessionHelper::check_session_and_unset(SessionHelper::ORDER_FINISH_PAGE);
        $res_details = $this->_service->getSingleRestaurantDetails();
        $this->renderer->render('restaurants/restaurant-details-view', array(
            'page_title' => $res_details['restaurantName']['name'],
            'data' => $res_details,
            'banner' => $banner_data
        ));
	}

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function add_dish()
    {
        $res_id = $this->_service->addDishToShoppingCard();
        header('Location:' . __URL_INIT_DIR__ . '/restaurants/restaurant-details?id=' . $res_id, true, 301);
        
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * Przejście pod adres: /restaurants/clear-filters
     */
    public function clear_filters()
    {
        CookieHelper::delete_cookie(CookieHelper::RESTAURANT_FILTERS);
        header('Location:' . __URL_INIT_DIR__ . 'restaurants', true, 301);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Przejście pod adres: /restaurants
     */
	public function index()
    {
        $res_list = $this->_service->get_all_accepted_restaurants();
        $banner_data = SessionHelper::check_session_and_unset(SessionHelper::HOME_RESTAURANTS_LIST_PAGE_BANNER);
        $this->renderer->render('restaurants/all-restaurants-view', array(
            'page_title' => 'Restauracje',
            'banner' => $banner_data,
            'data' => $res_list,
        ));
	}
}