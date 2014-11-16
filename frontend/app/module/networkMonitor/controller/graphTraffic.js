angular.module('module_networkMonitor')

.controller('module_networkMonitorGraphTrafficController', function ($scope, NetworkMonitor) {
    
    $scope.data = null;
    $scope.uploadSpeedData = null;
    $scope.downloadSpeedData = null;
    $scope.uploadConsoData = null;
    $scope.downloadConsoData = null;
    $scope.loading = 0;
    
    $scope.getData = function() {
        $scope.loading++;
        NetworkMonitor.getAll().then(function(response) {
            $scope.data = response.data.data;
            
            $scope.uploadSpeedData = [];
            $scope.downloadSpeedData = [];
            $scope.uploadConsoData = [];
            $scope.downloadConsoData = [];
            angular.forEach($scope.data, function(value, key) {
                var d = moment.utc(value.createdAt);
                $scope.uploadSpeedData.push([d.valueOf(), value.uploadConso / 1024 / 60]);
                $scope.downloadSpeedData.push([d.valueOf(), value.downloadConso / 1024 / 60]);
                $scope.uploadConsoData.push([d.valueOf(), value.uploadConso / 1024 / 1024]);
                $scope.downloadConsoData.push([d.valueOf(), value.downloadConso / 1024 / 1024]);
            });
            $scope.initGraph();
            $scope.loading--;
        });
    };
    
    $scope.initGraph = function() {
        $('#graphTrafficContainerUpload').highcharts('StockChart', {
            chart: {
                zoomType: 'x'
            },
            colors: ['#f15c80', '#7cb5ec'], //'#f15c80' '#8085e8'
            rangeSelector: {
                buttons: [{
                    type: 'hour',
                    count: 1,
                    text: '1h'
                }, {
                    type: 'hour',
                    count: 6,
                    text: '6h'
                }, {
                    type: 'hour',
                    count: 12,
                    text: '12h'
                }, {
                    type: 'day',
                    count: 1,
                    text: '1d'
                }, {
                    type: 'day',
                    count: 3,
                    text: '3d'
                }, {
                    type: 'week',
                    count: 1,
                    text: '1w'
                }, {
                    type: 'month',
                    count: 1,
                    text: '1m'
                }, {
                    type: 'month',
                    count: 6,
                    text: '6m'
                }, {
                    type: 'year',
                    count: 1,
                    text: '1y'
                }, {
                    type: 'all',
                    text: 'All'
                }],
                selected: 1
            },
            yAxis: [{
                title: {
                    text: "Speed (kB/s)"
                }
            }, {
                title: {
                    text: "Volume (MB)"
                },
                lineWidth: 1
            }],
            title: {
                text: 'Upload'
            },
            series: [{
                name: 'Speed',
                data: $scope.uploadSpeedData,
                tooltip: {
                    valueDecimals: 2,
                    valueSuffix: 'kB/s'
                },
                dataGrouping: {
                    enabled: true
                },
                zIndex: 100
            }, {
                type: 'column',
                name: 'Volume',
                data: $scope.uploadConsoData,
                tooltip: {
                    valueDecimals: 2,
                    valueSuffix: 'MB'
                },
                yAxis: 1,
                dataGrouping: {
                    enabled: true
                }
            }]

        });
        $('#graphTrafficContainerDownload').highcharts('StockChart', {
            chart: {
                zoomType: 'x'
            },
            colors: ['#f15c80', '#7cb5ec'],
            rangeSelector: {
                buttons: [{
                    type: 'hour',
                    count: 1,
                    text: '1h'
                }, {
                    type: 'hour',
                    count: 6,
                    text: '6h'
                }, {
                    type: 'hour',
                    count: 12,
                    text: '12h'
                }, {
                    type: 'day',
                    count: 1,
                    text: '1d'
                }, {
                    type: 'day',
                    count: 3,
                    text: '3d'
                }, {
                    type: 'week',
                    count: 1,
                    text: '1w'
                }, {
                    type: 'month',
                    count: 1,
                    text: '1m'
                }, {
                    type: 'month',
                    count: 6,
                    text: '6m'
                }, {
                    type: 'year',
                    count: 1,
                    text: '1y'
                }, {
                    type: 'all',
                    text: 'All'
                }],
                selected: 1
            },
            yAxis: [{
                title: {
                    text: "Speed (kB/s)"
                }
            }, {
                title: {
                    text: "Volume (MB)"
                },
                lineWidth: 1
            }],
            title: {
                text: 'Download'
            },
            series: [{
                name: 'Speed',
                data: $scope.downloadSpeedData,
                tooltip: {
                    valueDecimals: 2,
                    valueSuffix: 'kB/s'
                },
                dataGrouping: {
                    enabled: true
                },
                zIndex: 100
            }, {
                type: 'column',
                name: 'Volume',
                data: $scope.downloadConsoData,
                tooltip: {
                    valueDecimals: 2,
                    valueSuffix: 'MB'
                },
                yAxis: 1,
                dataGrouping: {
                    enabled: true
                }
            }]

        });
    }
    
    $scope.getData();
});