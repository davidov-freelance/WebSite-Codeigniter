<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

switch ( $_SERVER['HTTP_HOST'] ) {
    default:

		// Главная страница сайта
		$route['default_controller'] = "default/home/landing";
		$route['index.php'] = "default/home/landing";


		$route['scripts/landing.js'] = "api/api_index/landingJs";
		$route['api/crm/change_status(:any)'] = "api/crm/change_status";
		$route['api'] = "api/api_index";
		$route['api/getData'] = "api/api_index/getData";
		$route['api/getTitle'] = "api/api_index/getTitle";
		$route['api/transit'] = "user/webmaster/stat/record/url";


		$route['api/get_info'] = "api/api_index/get_info";
		$route['api/get_cities'] = "api/get_cities";
		$route["api/get_info_transit/(:any)"] = "api/api_index/get_info_transit/$1";
		$route['api/loader/(:any)'] = "api/api_index/loader/$1";


		$route['panel'] = 'default/home/index';
		$route['rules'] = 'pages/rules';

		$route['404_override'] = '';

		$route['offer/list'] = "offer/offer";
		$route['offer/list/ind'] = "offer/offer";

		$route['offer/my'] = "offer/offer/my";
		$route['offer/view/id/(:any)'] = "offer/offer/id/$1";
		$route['offer/goalGeo/id/(:any)'] = "offer/offer/goalGeo/$1";

		$route['tickets'] = "help/ticket/lists";
		$route['tickets/(:any)'] = "help/ticket/$1";


		// новости
		$route['news'] = "news/news";
		$route['sawnews'] = "news/news/sawnews";
		$route['news/add_news'] = "news/news/add_news";
		$route['news/view/(:num)'] = "news/news/view/$1";
		$route['news/edit/(:num)'] = 'news/news/add_news/edit/$1';
		$route['news/delete/(:num)'] = 'news/news/delete/$1';

		// деньги: выплаты

		$route['money/payment'] = 'money/payment';
		$route['money/payment/(:any)'] = 'money/payment/$1';


		$route['for_advertisers'] = "home/for_advertisers";


		/*
		 * Cooperators
		 */
		$route['cooperator/(:any)'] = 'user/cooperators/home_cooperators/$1';
		
		/*
		 * Admin
		 */
		$route['admin'] = 'user/admin/home';


		$route['admin/utm'] = 'user/admin/utm';
		$route['admin/utm/groups'] = 'user/admin/utm/groups';
		$route['admin/utm/add_utm'] = 'user/admin/utm/add_utm';
		$route['admin/utm/edit/(:num)'] = 'user/admin/utm/add_utm/edit/$1';
		$route['admin/utm/update_group'] = 'user/admin/utm/update_group';
		$route['admin/utm/delete/(:num)'] = 'user/admin/utm/delete/$1';
		$route['admin/utm/delete_group/(:num)'] = 'user/admin/utm/delete_group/$1';


		$route['admin/helper'] = 'user/admin/helper';

		$route['admin/helper/add_helper'] = 'user/admin/helper/add_helper';
		$route['admin/helper/edit/(:num)'] = 'user/admin/helper/add_helper/edit/$1';

		$route['admin/helper/delete/(:num)'] = 'user/admin/helper/delete/$1';

	//	$route['news/add_news'] = "news/news/add_news";
	//	$route['news/view/(:num)'] = "news/news/view/$1";
	//	$route['news/edit/(:num)'] = 'news/news/add_news/edit/$1';
	//	$route['news/delete/(:num)'] = 'news/news/delete/$1';




		$route['admin/news/delete/(:num)'] = 'user/admin/news/news/delete/$1';
		
		
		
		$route['admin/news/(:any)'] = 'user/admin/news/$1';
		$route['admin/user/(:num)'] = 'user/admin/user/view_admin/view/$1';

		$route['admin/users'] = 'user/admin/user/list_admin';
		$route['admin/users/(:any)'] = 'user/admin/user/list_admin/$1';
		
        $route["admin/countries"] = "user/admin/countries";
        $route["admin/countries/(:any)"] = "user/admin/countries/$1";
                
		$route['admin/stats/(:any)/(:num)'] = 'user/admin/user/stats_admin/$1/$2';
		$route['admin/offer/add'] = "user/admin/offer/add_offer";
		$route['admin/offer/list'] = 'user/admin/offer/list_admin/passed_moderation';
		$route['admin/offer/list/moderation'] = 'user/admin/offer/list_admin/not_passed_moderation';
		$route['admin/offer/take_moderation/(:any)'] = 'user/admin/offer/take_moderation/$1';

		$route['admin/offer/delete/(:num)'] = "user/admin/offer/add_offer/delete/$1";
		$route['admin/offer/edit/(:num)'] = "user/admin/offer/add_offer/edit/$1";
		$route['admin/offer/edit_true'] = "user/admin/offer/add_offer/edit_true";

		

		// pages
		$route['admin/offer/delete_page/(:num)/(:num)'] = "user/admin/offer/add_offer/delete_page/$1/$2";
		$route['admin/offer/edit_page'] = "user/admin/offer/add_offer/edit_page";

		// gaskets
		$route['admin/offer/delete_gasket/(:num)/(:num)'] = "user/admin/offer/add_offer/delete_gasket/$1/$2";
		$route['admin/offer/edit_gasket'] = "user/admin/offer/add_offer/edit_gasket";

		// goals
		$route['admin/offer/bunch/(:num)/(:num)/(:num)'] = "user/admin/offer/add_offer/bunch_status/$1/$2/$3";
		$route['admin/offer/delete_goal/(:num)/(:num)'] = "user/admin/offer/add_offer/delete_goal/$1/$2";
		$route['admin/offer/delete_geo_goal/(:num)/(:num)'] = "user/admin/offer/add_offer/delete_geo_goal/$1/$2";
		$route['admin/offer/edit_geo_goal'] = "user/admin/offer/add_offer/edit_geo_goal";
				
		
		$route['admin/offer/edit_goal'] = "user/admin/offer/add_offer/edit_goal";
		$route['admin/offer/goals/(:num)'] = "user/admin/offer/add_offer/goals_list/$1";
		
		$route['admin/visitors'] = 'user/admin/visitors/visitors_admin';
		$route['admin/visitors/(:any)'] = 'user/admin/visitors/visitors_admin/$1';
		$route['admin/user/operations/(:any)'] = 'user/admin/user/operations_admin/$1';
		$route['admin/user/cooperators'] = 'user/admin/user/cooperators_admin';
		$route['admin/user/cooperators/(:any)'] = 'user/admin/user/cooperators_admin/$1';
		$route['admin/user/edit/(:num)'] = 'user/admin/user/edit_admin/index/$1';
		$route['admin/user/delete/(:num)'] = 'user/admin/user/edit_admin/delete/$1';
		$route['admin/user/status/(:num)/(:num)'] = 'user/admin/user/edit_admin/set_status/$1/$2';

		// personal payouts
		$route['admin/ind'] = 'user/admin/user/ind/index';
		$route['admin/ind/delete/(:num)'] = 'user/admin/user/ind/delete/$1';
		$route['admin/ind/goals/(:num)'] = 'user/admin/user/ind/goals/$1';
		
		
		/*
		 * Advertiser
		 */
		$route['advertiser'] = "user/advertiser/home_advertiser";		
		$route['advertiser/offer/my'] = "user/advertiser/offer/my_advertiser";
		$route['advertiser/stat/orders'] = "user/advertiser/stat/orders_advertiser";
		$route['advertiser/stat/requests'] = "user/advertiser/stat/requests_advertiser";
		$route['advertiser/stat/requests/(:any)'] = "user/advertiser/stat/requests_advertiser/$1";
		$route['advertiser/stat/status/(:any)'] = "user/advertiser/stat/change_status_advertiser/$1";
		$route['advertiser/register'] = "user/advertiser/register_advertiser";
		$route['advertiser/getForChart'] = "user/advertiser/home_advertiser/getForChart";
		$route['advertiser/finance'] = "user/advertiser/finance/index_finance";
		$route['advertiser/stat/list'] = "user/advertiser/stat/stat_advertiser";
		$route['advertiser/stat/list/(:any)'] = "user/advertiser/stat/stat_advertiser/$1";
		
		/*
		 * Webmaster
		*/

		// Редирект поток --> лендинг
		// http://overads.ru/*****  -->  http://landing.site.ru
		$route['([A-Za-z0-9]{4,6})'] = "user/webmaster/stat/record/url/$1";
		// Webmaster
		$route['webmaster'] = "user/webmaster/home_webmaster";
		$route['webmaster'] = "default/home/index";
		$route['webmaster/getForChart'] = "user/webmaster/home_webmaster/getForChart";
		$route['webmaster/flow/(:any)'] = "user/webmaster/flow_webmaster/$1";
		$route['webmaster/offer/operation/(:any)'] = "user/webmaster/offer/operation_webmaster/$1";
		$route['webmaster/money'] = 'user/webmaster/money/money';
		$route['webmaster/deposit_funds'] = 'user/webmaster/money/money/deposit_funds';
		$route['webmaster/stat/list'] = 'user/webmaster/stat/stat_list_webmaster';
		$route['webmaster/stat/list/(:any)'] = 'user/webmaster/stat/stat_list_webmaster/$1';


        $route['webmaster/places/(:any)'] = 'user/webmaster/places/places_webmaster/$1';

		$route['webmaster/settings'] = 'user/webmaster/settings/settings_webmaster';
		$route['webmaster/settings/(:any)'] = 'user/webmaster/settings/settings_webmaster/$1';
		$route['webmaster/stat/requests'] = 'user/webmaster/stat/requests_webmaster';
		$route['register'] = 'user/webmaster/register';
		$route['register/check_answer'] = 'user/webmaster/register/check_answer';

		$route['webmaster/register'] = 'user/webmaster/register';
		$route['webmaster/promo/(:any)'] = 'user/webmaster/promo/$1';

		$route['webmaster/register/(:any)'] = 'user/webmaster/register/$1';
	    
    break;
}

/* End of file routes.php */
/* Location: ./application/config/routes.php */
