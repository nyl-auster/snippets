@desc Ionic example controller
@tags ionic, controller, js

app.controller('goalsListController', ['$scope', function($scope) {

  $scope.items = [
    {
      title: 'test',
      description: 'description de ce but',

    },
    {
      title: 'goal 2',
      description: 'description de ce but 2'
    }
  ]

}]);