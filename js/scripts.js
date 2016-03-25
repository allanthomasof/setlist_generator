var app = angular.module("SetlistGenerator", []);
var host = "localhost";

app.controller("SetlistGeneratorController", function($scope, $http) {
    window.scrollTo(0,1);
    
	$scope.carregarSetlist = function() {
		$http.get("http://" + host + "/api/fullSetlist/").success(function (data){
			$scope.setList = data;
			$scope.index = 0;
		});
        $scope.carregarLetras();
	};

	$scope.adicionarMusica = function(music) {
		$http.post("http://" + host + "/api/addMusic/", music).success(function (data){ 
			$scope.result = data + " Successfully Registered!";
			delete $scope.music;
		});
	};
    
    $scope.excluirMusica = function(id, name) {
        if(confirm("Deseja excluir "+ name +" ?")) {
            $http.delete("http://" + host + "/api/deleteMusic/" + id['0']).success(function (data){
                $scope.carregarSetlist();
                console.log(data);
            });
        }
    };
    
    $scope.carregarLetras = function(song, artist) {
        $http.get("https://api.vagalume.com.br/search.php"
                + "?art=" + artist
                + "&mus=" + song,
                + "&apikey={key}").success(function (data){
            
            $scope.letra = data.mus[0].name;
            $scope.nomeMusica = data.mus[0].text;
			//alert(data.mus[0].text);
            console.log(data);
		});
    };


	$scope.message = "Setlist Generator";
});