angular.module('monogram-app', ['ui.router', 'ui.bootstrap'])

    .config(function($stateProvider, $urlRouterProvider){

        $urlRouterProvider.otherwise("/");
        $stateProvider.state('/', {
            url: "",
            views: {
                "tab1": { templateUrl: "/app-settings/simple-text" },
                "tab2": { templateUrl: "/app-settings/monogram" },
                "tab3": { templateUrl: "/app-settings/logo" }
            }
        });
    })

    .controller('TabsCtrl', function ($rootScope, $scope, $http) {
        $scope.tabs = [
            { heading: "Text", route:"tab1", active:true },
            { heading: "Monogram", route:"tab2", active:false },
            { heading: "Logo", route:"tab3", active:false }
        ];

        $scope.fonts = [];
        $scope.textFonts = [];
        $scope.monogramFonts = [];

        $scope.simpleTextSettings = {
            text_length: 10,
            selectedFontsIds: []
        };

        $scope.monogramSettings = {
            monogram_text_length: 10,
            selectedFontsIds: []
        };

        $scope.$on("$stateChangeSuccess", function(event, viewConfig) {
            //console.log(viewConfig);
            $http.get('/app-settings/fonts').then(function(value) {
                $scope.fonts = value.data;
                angular.forEach($scope.fonts, function(fontObj, key){
                    fontObj.checked = false;
                    if( fontObj.font_type == 'monogram' ){
                        $scope.monogramFonts.push(fontObj);
                    } else{
                        $scope.textFonts.push(fontObj);
                    }
                });
            });

            $http.get('/app-settings/saved-text-settings').then(function(value) {
                console.log(value);
                var settings = value.data;
                var selected_fonts = settings.selected_fonts;
                var text_length = settings.text_length;
                if( text_length.value )
                    $scope.simpleTextSettings.text_length = text_length.value;

                angular.forEach($scope.textFonts, function(fontObj, key){
                    angular.forEach(selected_fonts, function(selectedFontObj, key){
                        if( selectedFontObj.key == fontObj.font_css_class ){
                            $scope.simpleTextSettings.selectedFontsIds.push(fontObj.id);
                            fontObj.checked = true;
                        }
                    });
                });
            });

            $http.get('/app-settings/saved-monogram-settings').then(function(value) {
                console.log(value);
                var settings = value.data;
                var selected_fonts = settings.selected_monogram_fonts;
                var monogram_text_length = settings.monogram_text_length;
                if( monogram_text_length.value )
                    $scope.monogramSettings.monogram_text_length = monogram_text_length.value;

                angular.forEach($scope.monogramFonts, function(fontObj, key){
                    angular.forEach(selected_fonts, function(selectedFontObj, key){
                        if( selectedFontObj.key == fontObj.font_css_class ){
                            $scope.monogramSettings.selectedFontsIds.push(fontObj.id);
                            fontObj.checked = true;
                        }
                    });
                });
            });
        });

        $scope.textFontCheckboxClick = function(font){
            font.checked = !font.checked;
            //console.log($scope.textFonts);
            var idx = $scope.simpleTextSettings.selectedFontsIds.indexOf(font.id);

            if (idx > -1) {
                $scope.simpleTextSettings.selectedFontsIds.splice(idx, 1);
            } else {
                $scope.simpleTextSettings.selectedFontsIds.push(font.id);
            }
            console.log($scope.simpleTextSettings.selectedFontsIds, $scope.simpleTextSettings.text_length);
        }

        $scope.monogramFontCheckboxClick = function(font){
            font.checked = !font.checked;
            //console.log($scope.textFonts);
            var idx = $scope.monogramSettings.selectedFontsIds.indexOf(font.id);

            if (idx > -1) {
                $scope.monogramSettings.selectedFontsIds.splice(idx, 1);
            } else {
                $scope.monogramSettings.selectedFontsIds.push(font.id);
            }
            console.log($scope.monogramSettings.selectedFontsIds, $scope.monogramSettings.monogram_text_length);
        }

        $scope.saveTextSettings = function(){
            var data = {
                "font_ids": $scope.simpleTextSettings.selectedFontsIds,
                "text_length": $scope.simpleTextSettings.text_length
            };
            var config = {};
            $http.post('/app-settings/save-text-settings', data, config)
                .then(function (data, status, headers, config) {

                }, function (data, status, header, config) {
                    var e = "Data: " + data +
                        "<hr />status: " + status +
                        "<hr />headers: " + header +
                        "<hr />config: " + config;
                });
        }

        $scope.saveMonogramSettings = function(){
            var data = {
                "font_ids": $scope.monogramSettings.selectedFontsIds,
                "monogram_text_length": $scope.monogramSettings.monogram_text_length
            };
            var config = {};
            $http.post('/app-settings/save-monogram-settings', data, config)
                .then(function (data, status, headers, config) {

                }, function (data, status, header, config) {
                    var e = "Data: " + data +
                        "<hr />status: " + status +
                        "<hr />headers: " + header +
                        "<hr />config: " + config;
                });
        }
    });