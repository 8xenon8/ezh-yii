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

    .modalBG {
        position: fixed;
        background: rgba(0,0,0,0.5);
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
    }

    .tagModal {
        z-index: 100;
        margin: 5%;
        background: #fff;
        padding: 20px;
    }

    .tagModal .tagCont {
        float: left;
        margin: 5px 20px 5px 0;
    }

    .tagModal .save {
        display: block;
        margin: 20px 0 0;
    }

    .hiddenTag{
        display: none;
    }

    tr:hover .hiddenTag
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

        $scope.resetTags = function() {
            for (let i in $scope.tags) {
                $scope.tags[i]['checked'] = false;
            }
        }

        $scope.imageForTags = null;

        $scope.resetTags();

        $scope.sortImages = function() {
            $scope.images = $filter('orderBy')($scope.images, 'order', false);
        }

        $scope.sortImages();

        $scope.selectedAll = false;

        $scope.selectAll = function() {

            // $scope.selectedAll = !$scope.selectedAll;

            for (let i in $scope.images) {
                $scope.images[i].active = $scope.selectedAll;
            }
        }

        $scope.uploadData = function() {


            $('.pic.dirty').each(function(index, element) {
                let id = element.id;

                let image = $scope.getImageById(id);

                if (!image) { return; };

                $http({
                    method: 'PATCH',
                    url: "/api/images/" + id + "<?= \Yii::$app->params['accessToken']; ?>",
                    data: $httpParamSerializer({
                        name: $(element).find('.name').val(),
                        description: $(element).find('.description').val(),
                        order: $(element).find('.order').val()
                    }),
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                }).then(function(data) {

                    $(element).removeClass('dirty');

                    image.order = parseInt($(element).find('.order').val());
                    image.dirty = false;
                    image.new = false;
                    image.error = false;

                    $scope.sortImages();

                }, function(data) {

                    image.order = parseInt($(element).find('.order').val());
                    image.error = true;
                    image.new = false;

                    $scope.sortImages();
                });
            });

        }

        $scope.doAction = function() {
            $scope.selectedAction.action();
        };

        $scope.publish = function() {

            $('.pic.active').each(function(index, element) {
                let id = element.id;

                let image = $scope.getImageById(id);

                if (!image) { return; };

                $http({
                    method: 'POST',
                    url: location.href + "/publish/" + id,
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                }).then(function(data) {

                    $(element).removeClass('dirty');

                    image.publish = true;
                    image.active = false;
                    image.error = false;

                }, function(data) {

                    image.error = true;
                    image.active = false;

                });
            });

        }

        $scope.unpublish = function() {

            $('.pic.active').each(function(index, element) {
                let id = element.id;

                let image = $scope.getImageById(id);

                if (!image) { return; };

                $http({
                    method: 'POST',
                    url: location.href + "/unpublish/" + id,
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                }).then(function(data) {

                    $(element).removeClass('dirty');

                    image.publish = false;
                    image.active = false;
                    image.error = false;

                }, function(data) {

                    image.error = true;
                    image.active = false;

                });
            });

        }

        $scope.move = function() {

            $('.pic.active').each(function(index, element) {
                let id = element.id;

                let image = $scope.getImageById(id);

                if (!image) { return; };

                $http({
                    method: 'POST',
                    url: "/admin/move",
                    data: $httpParamSerializer({
                        image_id: image.id
                    }),
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                }).then(function(data) {

                    $scope.images = $scope.images.filter(function(i) { return i.id != id; });
                    $scope.sortImages();

                }, function(data) {

                    image.error = true;
                    image.active = false;

                });
            });

        }

        $scope.deleteImage = function() {

            $('.pic.active').each(function(index, element) {
                let id = element.id;

                let image = $scope.getImageById(id);

                if (!image) { return; };

                $http({
                    method: 'POST',
                    url: location.href + "/deleteImage/" + id,
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                }).then(function(data) {

                    $scope.images = $scope.images.filter(function(i) { return i.id != id; });
                    $scope.sortImages();

                }, function(data) {

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

        $scope.actions = [
            {
                action: $scope.deleteImage,
                label: 'Удалить'
            },
            {
                action: $scope.publish,
                label: 'Опубликовать'
            },
            {
                action: $scope.unpublish,
                label: 'Снять с публикации'
            },
            {
                action: $scope.move,
                label: 'Переместить в...',
                showGalleryList: true
            }
        ];

        $scope.selectedAction = $scope.actions[0];

        $scope.getTags = function(id) {

            $scope.imageForTags = id;

            $http({
                method: 'GET',
                url: location.href + "/get-tags/" + id,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(data) {

                let checked = data.data.tags;

                for (let i in $scope.tags) {
                    let tag = $scope.tags[i];

                    if (checked.indexOf(tag.id) != -1) {
                        tag.checked = true;
                    }
                }

                $scope.showTags = true;

            }, function(data) {



            });

        }

        $scope.saveTags = function() {

            let selected = $scope.tags.filter(function(i) {
                return i.checked;
            }).map(function(i) {
                return i.id;
            });

            $http({
                method: 'POST',
                url: location.href + "/save-tags/" + $scope.imageForTags,
                data: $httpParamSerializer(selected),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(data) {

            }, function(data) {



            });

            $scope.showTags = false;

            $scope.resetTags();
        }

        $scope.saveAllTags = function() {
            var ids = [];
            var tags = [];

            $('.pic.active').each(function(index, element) {
                ids.push(element.id);
            });

            $('.tagBlock input:checked').each(function(index, element) {
                tags.push(element.value);
            });

            $http({
                method: 'POST',
                url: location.href + "/save-tags/" + ids.join(','),
                data: $httpParamSerializer(tags),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(data) {
                $.notify(data.data.success, {
                    className: 'success'
                });
            }, function(data) {
                $.notify(data.data.success, {
                    className: 'fail'
                });
            });
        }

        $scope.toggle = function($event, image) {
            if ($event.target.localName == 'td' || $event.target.localName == 'tr') {
                image.active = !image.active;
            };
        }

        $scope.changeImageOrder = function(item, target) {
            $http({
                method: 'POST',
                url: "/admin/change-image-order",
                data: $httpParamSerializer({'item': item, 'target': target}),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(data) {
                // $('.pic').each(function(i, e) {
                // $(e).attr('data-order', $(e).index() - 2);
                // });
            }, function(data) {
                alert('Failed to sort image');
            });
        }

        $scope.toggleTag = function(image, tagId)
        {
            $http({
                method: 'POST',
                url: "/admin/toggle-tag",
                data: $httpParamSerializer({'tag_id': tagId, 'image_id': image.id}),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(data) {
                if (image.tags.indexOf(tagId) !== -1) {
                    image.tags = image.tags.filter(function (i) {
                        return i != tagId;
                    });
                } else {
                    image.tags.push(tagId);
                }
            }, function() {
                alert('Failed to toggle tag');
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

        <div class="modalBG" ng-show="showTags">

            <div class="tagModal">

                <div ng-repeat="tag in tags" class="tagCont">
                    {{tag.name}}: <input type="checkbox" class="tag" ng-model="tag.checked">
                </div>

                <br />

                <input type="button" ng-click="saveTags()" class="save" value="Сохранить">

            </div>

        </div>

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
                    {{image.publish ? 'Да' : 'Нет'}}
                </td>
                <td>
                    <!--            <input type="button" ng-click="getTags(image.id)" value="Тэги">-->
                    <div class="tagBlock">
                        <a ng-repeat="(index, tag) in tags" ng-click="toggleTag(image, tag.id)" class="badge" ng-class="{'btn-success': (image.tags.indexOf(tag.id) != -1), 'btn-info hiddenTag': (image.tags.indexOf(tag.id) == -1)}">#{{tag.name}}</a>
                    </div>
                </td>
                <td>
                    <input ng-model="image.active" type="checkbox" ng-checked="image.active">
                </td>
            </tr>
            <tr><td></td><td></td><td></td><td></td><td></td><td></td><td><input type="checkbox" ng-model="selectedAll" ng-click="selectAll()"></td></tr>
            </tbody>
        </table>

        <input type="submit" ng-click="uploadData()" ng-show="images.length > 0">

        <select ng-model="selectedAction" ng-options="action as action.label for action in actions track by action.action" ng-show="images.length > 0"></select>

        <form dropzone="" class="dropzone"></form>
    </div>

</div>