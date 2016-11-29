var included_modules = [];
var angularApp = angular.module('customer-tagging-app', included_modules)

    .config(function($httpProvider, $provide) {
        //alert(angular.element($("#_token")).val());
        $httpProvider.defaults.headers.common['X-XSRF-TOKEN'] = angular.element($("#_token")).val();
    })

    .controller('StoreController', ['$rootScope', '$scope', '$http', 'shopifyApp', function ($rootScope, $scope, $http, shopifyApp) {

        $scope.childStore = {};
        $scope.childStore.Url = "";
        $scope.childStore.ApiKey = "";
        $scope.childStore.Password = "";

        $scope.importSettings = {};
        $scope.importSettings.hidden = "no";
        $scope.importSettings.overwriteProducts = "no";

        $scope.products = [];

        $http.get('/get-child-store').then(function(value) {
            $scope.childStore = value.data;
        });

        /*$http.get('/products').then(function(value) {
            $scope.products = value.data;
        });*/

        $scope.saveChildStoreSettings = function(){
            var config = {};
            shopifyApp.Bar.loadingOn();
            $http.post('/save-child-store', $scope.childStore, config)
                .then(function (data, status, headers, config) {
                    shopifyApp.flashNotice("Successfully Updated.");
                    shopifyApp.Bar.loadingOff();
                }, function (data, status, header, config) {
                    var e = "Data: " + data +
                        "<hr />status: " + status +
                        "<hr />headers: " + header +
                        "<hr />config: " + config;
                    shopifyApp.flashError("An error occurred while saving.");
                    shopifyApp.Bar.loadingOff();
                });
        }

        $scope.importProducts = function(){
            $http.post('/products/import', $scope.importSettings).then(function(value) {

            });
        }

        //init Shopify App
        shopifyApp.init('Product Importer', $scope.saveChildStoreSettings, []);


    }])

    .service('shopifyApp', function(){
        this.init = function(page_title, callbackFunction, secondaryButtons){
            ShopifyApp.ready(function(){
                var config = {
                    title: page_title,
                    buttons: {
                        primary: {
                            label: 'Save',
                            callback: callbackFunction
                        }
                    }
                };
                if(secondaryButtons && secondaryButtons.length){
                    config.buttons.secondary = secondaryButtons;
                }
                ShopifyApp.Bar.initialize(config);
            });
        }

        this.Bar = {
            loadingOn: function(){
                ShopifyApp.Bar.loadingOn();
            },
            loadingOff: function(){
                ShopifyApp.Bar.loadingOff();
            },
            setTitle: function(title){
                ShopifyApp.Bar.setTitle(title);
            }
        }

        this.Modal = {
            confirm: function (message, callback) {
                ShopifyApp.Modal.confirm(message, function (result) {
                    if (result) {
                        callback();
                    }
                });
            }
        }

        this.flashError = function(message){
            ShopifyApp.flashError(message);
        }

        this.flashNotice = function(message){
            ShopifyApp.flashNotice(message);
        }
    });


