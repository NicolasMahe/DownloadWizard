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
		templateUrl: 'app/page/search/template/search.tpl.html',
		controller: 'SearchController'
	}).
	when('/log', {
		templateUrl: 'app/page/log/template/log.tpl.html',
		controller: 'LogController'
	}).
	when('/watchlist', {
		templateUrl: 'app/page/watchlist/template/watchlist.tpl.html',
		controller: 'Page_WatchlistController'
	}).
	when('/quicksearch', {
		templateUrl: 'app/page/quickSearch/template/quickSearch.tpl.html',
		controller: 'QuickSearchController'
	}).
	when('/downloader', {
		templateUrl: 'app/page/downloader/template/downloader.tpl.html',
		controller: 'Page_DownloaderController'
	}).
	when('/networkMonitor', {
		templateUrl: 'app/page/networkMonitor/template/networkMonitor.tpl.html',
		controller: 'Page_NetworkMonitorController'
	}).
	when('/library', {
		templateUrl: 'app/page/library/template/library.tpl.html',
		controller: 'Page_LibraryController'
	}).
	when('/media', {
		templateUrl: 'app/page/media/template/media.tpl.html',
		controller: 'Page_MediaController'
	}).
	otherwise({
		templateUrl: 'app/page/home/template/home.tpl.html',
		controller: 'HomeController'
	});
}])
.run(function() {
    FastClick.attach(document.body);
});