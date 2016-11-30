var included_modules = [];
var angularApp = angular.module('product-updating-app', included_modules)

    .config(function($httpProvider, $provide) {
        //alert(angular.element($("#_token")).val());
        $httpProvider.defaults.headers.common['X-XSRF-TOKEN'] = angular.element($("#_token")).val();
    })

    .controller('StoreController', ['$rootScope', '$scope', '$http', 'shopifyApp', function ($rootScope, $scope, $http, shopifyApp) {
        $scope.headerOptions = [];
        $scope.headerOptions.offered = [
            {
                key: "variant_sku",
                value: "Variant Sku",
                mapped_to: ""
            },
            {
                key: "variant_price",
                value: "Variant Price",
                mapped_to: ""
            },
            {
                key: "variant_compare_at_price",
                value: "Compare at Price",
                mapped_to: ""
            },
            {
                key: "variant_inventory_qty",
                value: "Inventory Quantity",
                mapped_to: ""
            }
        ];
        $scope.headerOptions.inCSV = {};
        $scope.csv = {};

        $scope.readCSV = function(csv_data){
            $scope.csv = csv_data.content;
            $scope.headerOptions.inCSV[""] = "Select an option";
            angular.forEach(csv_data.headers, function(value, key){
                $scope.headerOptions.inCSV[value] = value;
            });
        };

        $scope.updateProducts = function(){
            var config = {};
            var params = {
                header_options: $scope.headerOptions,
                csv_content: $scope.csv
            };
            console.log(params);
            /*shopifyApp.Bar.loadingOn();
            $http.post('/update-variants', params, config)
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
                });*/
        }

        $scope.table = [];
        $scope.updateTable = function(headerOption){
            var obj = {};
            var table = [];
            if(headerOption.mapped_to != ""){
                angular.forEach($scope.csv, function(csv_row, key){
                    obj = {};
                    angular.forEach($scope.headerOptions.offered, function(option, k){
                        if( csv_row[option.mapped_to] != undefined ){
                            if(option.mapped_to != ""){
                                console.log(option.mapped_to, csv_row[option.mapped_to]);
                                obj[option.key] = csv_row[option.mapped_to];
                            } else{
                                obj[option.key] = "";
                            }
                        }
                    });
                    table.push(obj);
                });
            }
            $scope.table = table;
            console.log($scope.table)
        }




        $scope.childStore = {};
        $scope.childStore.Url = "";
        $scope.childStore.ApiKey = "";
        $scope.childStore.Password = "";

        $scope.importSettings = {};
        $scope.importSettings.hidden = "no";
        $scope.importSettings.overwriteProducts = "no";

        $scope.products = [];

        /*$http.get('/get-child-store').then(function(value) {
            $scope.childStore = value.data;
        });*/

        /*$http.get('/products').then(function(value) {
            $scope.products = value.data;
        });*/

        $scope.saveChildStoreSettings = function(){
            /*var config = {};
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
                });*/
        }

        $scope.importProducts = function(){

        }

        //init Shopify App
        shopifyApp.init('Product Importer', $scope.updateProducts, []);


    }])

    .directive('csvReader', [function () {

        // Function to convert to JSON
        var convertToJSON = function (content) {

            // Declare our variables
            var lines = content.csv.split('\n'),
                headers = lines[0].split(content.separator),
                columnCount = lines[0].split(content.separator).length,
                results = [];
            results.headers = [];
            results.content = [];

            results.headers = headers;

            // For each row
            for (var i = 1; i < lines.length; i++) {

                // Declare an object
                var obj = {};

                // Get our current line
                var line = lines[i].split(new RegExp(content.separator + '(?![^"]*"(?:(?:[^"]*"){2})*[^"]*$)'));

                // For each header
                for (var j = 0; j < headers.length; j++) {

                    // Populate our object
                    obj[headers[j]] = line[j];
                }

                // Push our object to our result array
                results.content.push(obj);
            }

            // Return our array
            return results;
        };

        return {
            restrict: 'A',
            scope: {
                csv: '&',
                separator: '=',
                callback: '&saveResultsCallback'
            },
            link: function (scope, element, attrs) {

                // Create our data model
                var data = {
                    csv: null,
                    separator: scope.separator || ','
                };

                // When the file input changes
                element.on('change', function (e) {

                    // Get our files
                    var files = e.target.files;

                    // If we have some files
                    if (files && files.length) {

                        // Create our fileReader and get our file
                        var reader = new FileReader();
                        var file = (e.srcElement || e.target).files[0];

                        // Once the fileReader has loaded
                        reader.onload = function (e) {

                            // Get the contents of the reader
                            var contents = e.target.result;

                            // Set our contents to our data model
                            data.csv = contents;

                            // Apply to the scope
                            scope.$apply(function () {

                                // Our data after it has been converted to JSON
                                res = convertToJSON(data);


                                // Call our callback function
                                scope.callback({csv_data: res});
                            });
                        };

                        // Read our file contents
                        reader.readAsText(file);
                    }
                });
            }
        };
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


