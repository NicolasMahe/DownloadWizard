angular.module('downloadWizard', [
  'ngRoute',
  'ngSanitize',
  'page',
  'webservice',
  'module'
])
.config(['$routeProvider', function($routeProvider) {
	
	$routeProvider.
	when('/search', {
		templateUrl: 'frontend/app/page/search/template/search.tpl.html',
		controller: 'SearchController'
	}).
	when('/log', {
		templateUrl: 'frontend/app/page/log/template/log.tpl.html',
		controller: 'LogController'
	}).
	when('/watchlist', {
		templateUrl: 'frontend/app/page/watchlist/template/watchlist.tpl.html',
		controller: 'Page_WatchlistController'
	}).
	when('/quicksearch', {
		templateUrl: 'frontend/app/page/quickSearch/template/quickSearch.tpl.html',
		controller: 'QuickSearchController'
	}).
	when('/downloader', {
		templateUrl: 'frontend/app/page/downloader/template/downloader.tpl.html',
		controller: 'Page_DownloaderController'
	}).
	when('/networkMonitor', {
		templateUrl: 'frontend/app/page/networkMonitor/template/networkMonitor.tpl.html',
		controller: 'Page_NetworkMonitorController'
	}).
	when('/library', {
		templateUrl: 'frontend/app/page/library/template/library.tpl.html',
		controller: 'Page_LibraryController'
	}).
	when('/media', {
		templateUrl: 'frontend/app/page/media/template/media.tpl.html',
		controller: 'Page_MediaController'
	}).
	otherwise({
		templateUrl: 'frontend/app/page/home/template/home.tpl.html',
		controller: 'HomeController'
	});
}])
.run(function() {
    FastClick.attach(document.body);
});