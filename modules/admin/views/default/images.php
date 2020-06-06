<script src="/js/dropzone.js"></script>
<script src="/js/angular.js"></script>
<link type="text/css" rel="stylesheet" href="/css/dropzone.css">

<style>

    .pictable {
        text-align: center;
    }

    .pictable th {
        text-align: center;
        padding: 5px;
    }

    .pic td {
        vertical-align: top;
        padding: 10px 5px;
    }

    .pic td img {
        max-width: 75px;
        max-height: 75px;
    }

    .pic td textarea {
        height: 100%;
        width: 300px;
        min-height: 100px;
    }

    .pic.dirty td {
        background: #ffff9d;
    }

    .pic.active td {
        background: #e8e8e8;
    }

    .pic.new td {
        background: #b6ffb6;
    }

    .pic.error td {
        background: #fdb4b4;
    }

    .tagModal .tagCont {
        float: left;
        margin: 5px 20px 5px 0;
    }

    .tagModal .save {
        display: block;
        margin: 20px 0 0;
    }

    #pictable .badge.btn-success
    {
        background-color: #449d44;
        border-color: #398439;
    }

    #pictable tr .tagBlock .badge
    {
        display: none;
    }

    #pictable tr .tagBlock .badge.btn-success, #pictable tr:hover .tagBlock .badge
    {
        display: inline-block;
    }

    .tagBlock .badge {
        margin: 2px;
    }

    .tagBlock {
        width: 300px;
    }

</style>

<script type="text/javascript">
    Dropzone.autoDiscover = false;
</script>

<script>

    /*jshint undef: false, unused: false, indent: 2*/
    /*global angular: false */

    angular.module('admin', []).controller('UploadController', function($scope, $http, $httpParamSerializer, $filter) {

        $scope.images = <?= json_encode($imagesDataProvider->query->asArray()->all(), JSON_NUMERIC_CHECK)?>;
        $scope.tags = <?= json_encode($tags, JSON_NUMERIC_CHECK)?>;

        for (var i in $scope.images) {
            $scope.images[i].publish = !!$scope.images[i].publish;
            $scope.images[i].tags = $scope.images[i].tags.map(function(i) { return i.name; });
        }

        $scope.resetTags = function() {
            for (let i in $scope.tags) {
                $scope.tags[i]['checked'] = false;
            }
        }

        $scope.imageHasTag = function(image, tag) {
            for (let i in image.tags) {
                if (image.tags[i] == tag.name) {
                    return true;
                }
            }
            return false;
        }

        $scope.resetTags();

        $scope.sortImages = function() {
            $scope.images = $filter('orderBy')($scope.images, 'order', false);
        }

        $scope.sortImages();

        $scope.selectedAll = false;

        $scope.selectAll = function() {
            for (let i in $scope.images) {
                $scope.images[i].active = $scope.selectedAll;
            }
        }

        $scope.uploadData = function() {
            $('.pic.dirty').each(function(index, element) {
                let id = element.id;

                let image = $scope.getImageById(id);

                if (!image) { return; }

                $http({
                    method: 'PATCH',
                    url: "/api/images/" + id + "?access-token=<?= \Yii::$app->params['accessToken']; ?>",
                    data: $httpParamSerializer({
                        name: $(element).find('.name').val(),
                        description: $(element).find('.description').val(),
                        order: $(element).find('.order').val()
                    }),
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                }).then(function(data) {

                    PNotify.success("Изображение #" + image.id + " изменено");
                    $(element).removeClass('dirty');

                    image.dirty = false;
                    image.new = false;
                    image.error = false;

                    $scope.sortImages();

                }, function(data) {

                    PNotify.error('Не удалось изменить данные изображения');

                    image.error = true;
                    image.new = false;

                    $scope.sortImages();
                }).catch(function(err) {
                    PNotify.error('Не удалось изменить данные изображения');
                });
            });

        }

        $scope.togglePublish = function(image) {
            image.publishOld = !image.publish;
            $http({
                method: 'PATCH',
                url: "/api/images/" + image.id + "?access-token=<?= \Yii::$app->params['accessToken'];?>",
                data: $httpParamSerializer({publish: image.publish * 1}), // casting bool to int
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(data) {
                if (data.data.publish == 1) {
                    PNotify.success("Изображение #" + image.id + " опубликовано");
                } else {
                    PNotify.success("Изображение #" + image.id + " снято с публикации");
                }
                image.publishOld = image.publish;
            }, function(data) {
                image.publish = image.publishOld;

                PNotify.error('Не удалось изменить статус изображения');

            }).catch(function(err) {
                image.publish = image.publishOld;

                PNotify.error('Не удалось изменить статус изображения');
            });
        }

        $scope.deleteImages = function() {

            if (!confirm("Вы уверены, что хотите удалить изображения?")) { return; }

            $('.pic.active').each(function(index, element) {
                let id = element.id;

                let image = $scope.getImageById(id);

                if (!image) { return; };

                $http({
                    method: 'DELETE',
                    url: "/api/images/" + id + "?access-token=<?= \Yii::$app->params['accessToken'];?>",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                }).then(function(data) {

                    PNotify.success('Изображение удалено');
                    $scope.images = $scope.images.filter(function(i) { return i.id != id; });
                    $scope.sortImages();

                }, function(data) {

                    PNotify.error('Не удалось удалить изображение');
                    image.error = true;
                    image.active = false;

                });

            });

        }

        $scope.getImageById = function(id) {
            for (let i in $scope.images) {
                if ($scope.images[i]['id'] == id) {
                    return $scope.images[i];
                }
            }

            return false;
        }

        $scope.toggle = function($event, image) {
            if ($event.target.localName == 'td' || $event.target.localName == 'tr') {
                image.active = !image.active;
            };
        }

        $scope.toggleTag = function(image, tag, create) {
            $http({
                method: create ? 'POST' : 'DELETE',
                url: "/api/images/" + image.id + "/tags/" + tag.name + "?access-token=<?= \Yii::$app->params['accessToken'];?>",
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(data) {
                if (!create) {
                    image.tags = image.tags.filter(function (i) {
                        return i != tag.name;
                    });
                } else {
                    image.tags.push(tag.name);
                }
                PNotify.success('Статус тэга изменен')
            }, function() {
                PNotify.error('Не удалось изменить статус тэга')
            });
        }

    });

    angular.module('admin').directive('dropzone', function() {
        return {
            restrict: 'C',
            link: function(scope, element, attrs) {

                var config = {
                    url: "/api/images?access-token=<?= \Yii::$app->params['accessToken'] ?>",
                    paramName: "image",
                    parallelUploads: 5,
                    autoProcessQueue: true
                };

                var eventHandlers = {

                    'success': function (file, response) {

                        scope.$apply(function() {

                            for (let i in response) {

                                scope.images.push({
                                    id: response[i]['id'],
                                    name: '',
                                    description: '',
                                    order: 1000,
                                    orig: response[i]['org'],
                                    preview: response[i]['preview'],
                                    thumb: response[i]['thumb'],
                                    publish: false,
                                    new: true
                                });

                                scope.sortImages();

                            }

                        });
                    },

                };

                dropzone = new Dropzone(element[0], config);

                angular.forEach(eventHandlers, function(handler, event) {
                    dropzone.on(event, handler);
                });

                scope.processDropzone = function() {
                    dropzone.processQueue();
                };

                scope.resetDropzone = function() {
                    dropzone.removeAllFiles();
                }
            }
        }
    });
</script>

<div ng-app="admin">

    <div ng-controller="UploadController" ng-cloak>

        <table class="pictable" id="pictable">
            <tbody as-sortable ng-model="images">
            <tr>
                <th></th>
                <th>Название</th>
                <th>Описание</th>
                <th>Опубликовано</th>
            </tr>
            <tr><td></td><td></td><td></td><td></td><td></td><td><input type="checkbox" ng-model="selectedAll" ng-click="selectAll()"></td></tr>
            <tr ng-click="toggle($event, image)" ng-repeat="(index, image) in images" id="{{image.id}}" class="pic draggable" ng-class="{dirty: image.dirty, new: image.new, error: image.error, active: image.active}" ng-cloak as-sortable-item as-sortable-item-handle data-order="{{image.order}}">
                <td>
                    <img ng-src="/img/upload/{{image.thumb}}">
                </td>
                <td>
                    <input type="text" class="name" value="{{image.name}}" ng-model="image.name" ng-change="image.dirty = true">
                </td>
                <td>
                    <textarea ng-model="image.description" class="description" ng-change="image.dirty = true">{{image.description}}</textarea>
                </td>
                <td>
                    <input type="checkbox" ng-model="image.publish" ng-change="togglePublish(image)">
                </td>
                <td>
                    <div class="tagBlock">
                        <a ng-repeat="(index, tag) in tags" ng-click="toggleTag(image, tag, !imageHasTag(image, tag))" class="badge" ng-class="{'btn-success': (imageHasTag(image, tag))}">#{{tag.name}}</a>
                    </div>
                </td>
                <td>
                    <input ng-model="image.active" type="checkbox" ng-checked="image.active">
                </td>
            </tr>
            <tr><td></td><td></td><td></td><td></td><td></td><td><input type="checkbox" ng-model="selectedAll" ng-click="selectAll()"></td></tr>
            </tbody>
        </table>

        <input type="submit" ng-click="uploadData()" ng-show="images.length > 0">

        <input type="button" ng-click="deleteImages()" value="Удалить выбранные" ng-show="images.length > 0" style="float: right">

        <form dropzone="" class="dropzone"></form>
    </div>

</div>