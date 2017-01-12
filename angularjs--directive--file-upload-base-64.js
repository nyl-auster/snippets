/**
 * Champ d'upload en base64 (utilisé pour créer un "attachement" côté
 * salesforce
 */
module.directive("c43FileUploadBase64", ['storeSettings', function(storeSettings){
  return {
    restrict: 'E',
    scope:{
      // les extensions autorisées sous la forme ['jgp', 'png', ...]
      extensions: "=extensions",
      ngModel: "=",
      onError:"&"
    },
    controller:['$scope', function($scope) {

      $scope.file = {};

      $scope.fileValidateExtension = function(event, fileObjects, fileList) {
        if (!fileObjects) {
          $scope.fileExtensionIsValid = false;
        }
        else {
          var file = fileObjects[0];
          $scope.file = file;
          var extension = file.filename.split('.').pop();
          if ($scope.extensions.indexOf(extension) !== -1) {
            $scope.error = true;
            $scope.fileExtensionErrorMessage = "";
          }
          else {
            $scope.fileExtensionIsValid = false;
            $scope.fileExtensionErrorMessage = "Seul les types de fichiers suivants sont autorisés : " + $scope.extensions.join(', ');
            $scope.onError({
              fileExtensionIsValid:$scope.fileExtensionIsValid,
              errorMessage:$scope.fileExtensionErrorMessage
            });
          }
        }
      };
    }],
    template : '\
        <div class="c43-file-upload-base-64">\
          <!-- se positionnera au-dessus de notre bouton normal -->\
          <div class="form-control upload-fake-button">\
            {{file.filename}}\
            <span ng-show="!file.filename">Joindre un fichier</span>\
          </div>\
          <input base-sixty-four-input \
            on-after-validate="fileValidateExtension" \
            class="upload" \
            accept="" \
            type="file" \
            maxsize="10000" \
            ng-model="ngModel" \
            name="file">\
            <div ng-show="fileExtensionErrorMessage" class="error">\
              {{fileExtensionErrorMessage}}\
            </div>\
        </div>'
  }
}]);
