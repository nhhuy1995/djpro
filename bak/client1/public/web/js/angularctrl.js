var app = angular.module('myApp', []);
app.controller('ViewTopMedia', function($scope,$http) {
    $scope.listviewtopmedia = [];
    $scope.sorttype = 'view';
    $scope.getTopArticle= function(a,b,c,d){
        if ((d == 'view') || (d == 'down')) $scope.sorttype = d;
        $http({
            method: 'GET',
            url: '/service/viewTopMedia&key=topnhacsan&type='+b+'&date='+a +'&sort='+$scope.sorttype,
            cache: true
        }).
            success(function(data, status, headers, config) {
                $scope.listviewtopmedia = data.data;
                $('.selecttopviewmedia a').removeClass('active');
                $(".selecttopviewmedia a:nth-child("+d+")").addClass('active');
                // mai hoan thien trang play nhe. 2 ae lam nhah thoi :D, vang :D. giao dien van sida qua :D
            });
    }
    $scope.getTopArticle('w','audio','audio',1);

    $scope.changeSort = function(sorttype, elem) {
        $scope.sorttype = sorttype;
        $scope.getTopArticle('w','audio','audio',1);
    }

});

app.controller('ViewTopUser', function($scope,$http) {
    $scope.listviewtopuser = [];
    $scope.sorttype = 'like';

    $scope.getTopUser = function (period, positional) {
        $http({
            method: 'GET',
            url: '/service/viewTopUser&key=topnhacsan&date=' + period + '&sort=' + $scope.sorttype
            //cache: true
        }).success(function (data, status, headers, config) {
            $scope.listviewtopuser = data.data;
            $('.selecttopviewuser a').removeClass('active');
            $('.selecttopviewuser a:nth-child(' + positional + ')').addClass('active');
        });
    }

    $scope.getTopUser('w', 1);

    $scope.changeSort = function(sorttype) {
        $scope.sorttype = sorttype;
        $scope.getTopUser('w', 1);
    }
});

app.controller('ViewTopMediaWithImage', function($scope,$http) {
    $scope.listviewtopuser = [];
    $scope.sorttype = 'view';
    $scope.getTopMedia = function (type, period, positional) {
        $http({
            method: 'GET',
            url: '/service/viewTopMedia?act=viewtopmedia&type=' + type + '&date=' + period + '&sort=' + $scope.sorttype
            //cache: true
        }).success(function (data, status, headers, config) {
            $scope.listMedia = data.data;
            $('.selecttopothermedia a').removeClass('active');
            $('.selecttopothermedia a:nth-child(' + positional + ')').addClass('active');
        });
    }

    $scope.changeSort = function(mediaType, sorttype) {
        $scope.sorttype = sorttype;
        $scope.getTopMedia(mediaType, 'w', 1);
    }
});

app.controller('EditPlaylist', function($scope, $rootScope, $compile, $http) {
    $scope.isInject = false;

    $scope.injectModal = function() {
        if (!$scope.isInject) {
            $scope.isInject = true;
            $("#list-playlist-article").sortable();
            $("#list-playlist-article" ).disableSelection();
            $compile($("#tuoigiAlert"))($scope);
            $scope.$apply();
        }
        $("#loading").hide();
        $("#tuoigiAlert").modal("show");
    }

    $scope.loadPlaylistDetail = function() {
        $scope.playlistId = $("#playlistIdInEdit").attr('data-plid');
        $("#loading").show();
        $http({
            method: 'GET',
            url: '/service/loadPlayListDetail',
            params: {act: 'loadplaylistdetail','id' : $scope.playlistId}
        }).success(function (re, status, headers, config) {
            var data = re.data;
            if (re.status == 1) {
                $scope.playlistName = data.name;
                $scope.priavatar = data.priavatar;
                $scope.description = data.description;
                $scope.listsong = data.song;
                var displayModal = setInterval(
                    function(){
                        if (!$scope.$$phase) {
                            $scope.injectModal();
                            clearInterval(displayModal);
                        }
                    }, 1000);

            } else {
                alert(re.message);
            }
        }).error(function(  data,status,headers,cfg) {
            alert('Đã có lỗi xảy ra. Vui lòng thử lại sau');
        });
    }

    $scope.deleteSong = function(index) {
        $scope.listsong.splice(index, 1);
    }
});	