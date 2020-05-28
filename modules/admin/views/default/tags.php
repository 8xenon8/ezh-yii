<script src="/js/angular.js"></script>

<script>

    angular.module('tags', []).controller('TagContoller', function($scope, $http, $httpParamSerializer, $filter) {

        /** @var \yii\data\ActiveDataProvider $dataProvider **/
        $scope.tags = <?= json_encode($dataProvider->query->asArray()->all(), JSON_NUMERIC_CHECK); ?>;

        $scope.addTag = function() {

            let name = $scope.newTagName;

            $http({
                method: 'POST',
                url: "/api/tags/" + name + "?access-token=<?= \Yii::$app->params["accessToken"]; ?>",
                data: $httpParamSerializer({name: $scope.newTagName}),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(response) {
                if (response.status == 200) {
                    $scope.tags.push({
                        id: response.data.id,
                        name: response.data.name
                    });
                    $scope.newTagName = '';
                    PNotify.success("Тэг " + name + " создан");
                }
            }).catch(function(response) {
                PNotify.error({
                    title: response.data.name,
                    text: response.data.message
                });
            });
        }

        $scope.deleteTag = function(name) {

            if (confirm("Вы уверены?"))
            {

                $http({
                    method: 'DELETE',
                    url: "/api/tags/" + name + "?access-token=<?= \Yii::$app->params["accessToken"]; ?>"
                }).then(function(response) {
                    if (response.status == 204) {
                        $scope.tags = $scope.tags.filter(function (i) { return i.name != name; });
                        PNotify.success("Тэг " + name + " удален");
                    }
                }).catch(function(response) {
                    PNotify.error({
                        title: response.data.name,
                        text: response.data.message
                    });
                });;

            }
        }

    })
</script>

<div ng-app="tags" class="col-md-8">
    <div ng-controller="TagContoller">
        <div class="tags">
            <div ng-repeat="tag in tags" id="{{tag.id}}" class="btn-group btn-group-lg">
                <div class="btn btn-default">{{tag.name}} <span ng-click="deleteTag(tag.name)" class="label label-danger">Удалить</span></div>
            </div>
        </div>

        <form class="form-inline" method="POST">

            <h3>Добавить тэг</h3>

            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Название тэга" ng-model="newTagName">
            </div>

            <input type="submit" ng-click="addTag()" value="OK" class="btn btn-primary">
        </form>
    </div>
</div>
