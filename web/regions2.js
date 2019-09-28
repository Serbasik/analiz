var testData = {
    "RU-KHA" : {
        id: "RU-KHA",
        val: '#28ff48',
        isOpened : true
    },

    "RU-YAN" :
    {
        id: "RU-YAN",
        val: '#ff1f1a',
        isOpened : true
    }
};

var regions = undefined;

ymaps.ready(init);

function init() {


    var map = new ymaps.Map('map', {
        center: [65, 100],
        zoom: 2,
        type: null,
        controls: ['zoomControl']
    });
    map.controls.get('zoomControl').options.set({size: 'small'});
    // Добавим заливку цветом.
    var pane = new ymaps.pane.StaticPane(map, {
        zIndex: 100, css: {
            width: '100%', height: '100%', backgroundColor: '#f7f7f7'
        }
    });
    map.panes.append('white', pane);



    // Создадим балун.
    // var districtBalloon = new ymaps.Balloon(map);
    // districtBalloon.options.setParent(map.options);

    // Загрузим регионы.
    ymaps.borders.load('RU', {
        lang: 'ru',
        quality: 2
    }).then(onRegionsLoaded);

    function onRegionsLoaded(result) {

        //console.log(result);
        regions = new ymaps.ObjectManager();
        regions
            .add(result.features.map(function (feature) {
                feature.id = feature.properties.iso3166;
                feature.options = {
                    strokeColor: '#ffffff',
                    strokeOpacity: 0.4,
                    fillColor: '#6961b0',
                    fillOpacity: 0.8,
                    hintCloseTimeout: 0,
                    hintOpenTimeout: 0
                };

                var iso = feature.properties.iso3166;
                var name = feature.properties.name;
                feature.properties.hintContent = name;

                var dat = testData[iso];

                if (dat != undefined) {
                    feature.options.fillColor = dat.val;
                }

                return feature;
            }));
        map.geoObjects.add(regions);

        // // Создадим объект, в котором будут храниться коллекции с нашими регионами.
        // //var districtCollections = {};
        //
        //  var districtCollections = new ymaps.GeoObjectCollection(null, {
        //       //  fillColor: '#bac1cc',
        //         strokeColor: '#555964',
        //         strokeOpacity: 0.3,
        //         fillOpacity: 0.3,
        //         hintCloseTimeout: 0,
        //         hintOpenTimeout: 0
        //     });
        //
        //
        // // // Для каждого федерального округа создадим коллекцию.
        // // for (var district in districtColors) {
        // //     districtCollections[district] = new ymaps.GeoObjectCollection(null, {
        // //         fillColor: districtColors[district],
        // //         strokeColor: districtColors[district],
        // //         strokeOpacity: 0.3,
        // //         fillOpacity: 0.3,
        // //         hintCloseTimeout: 0,
        // //         hintOpenTimeout: 0
        // //     });
        // //     // Создадим свойство в коллекции, которое позже наполним названиями субъектов РФ.
        // //     districtCollections[district].properties.districts = [];
        // // }
        //
        //
        //
        // result.features.forEach(function (feature) {
        //     var iso = feature.properties.iso3166;
        //     var name = feature.properties.name;
        //
        //     // Для каждого субъекта РФ зададим подсказку с названием федерального округа, которому он принадлежит.
        //     feature.properties.hintContent = name;
        //
        //     var dat = testData[iso];
        //
        //     feature.options = {
        //         fillColor: '#bac1cc',
        //         strokeColor: '#555964',
        //         strokeOpacity: 0.3,
        //         fillOpacity: 0.3,
        //         hintCloseTimeout: 0,
        //         hintOpenTimeout: 0
        //     };
        //
        //     if(dat != undefined) {
        //         //obj.getParent().options.set({fillColor: dat.val})
        //         //  console.log(feature.options);
        //         feature.options.fillColor = dat.val;
        //         console.log(feature.options);
        //         //obj.options.fillColor = dat.val;
        //     }
        //
        //
        //     var obj = new ymaps.GeoObject(feature);
        //     // Добавим субъект РФ в соответствующую коллекцию.
        //     districtCollections.add(obj);
        //     // Добавим имя субъекта РФ в массив.
        //     //TODO DATA
        //    // districtCollections[district].properties.districts.push(name);
        //
        //
        //

    }

    // map.geoObjects.add(districtCollections);

        // Создадим переменную, в которую будем сохранять выделенный в данный момент федеральный округ.
        // var highlightedDistrict;
        // for (var districtName in districtCollections) {
        //     // Добавим коллекцию на карту.
        //     map.geoObjects.add(districtCollections[districtName]);
        //     // При наведении курсора мыши будем выделять федеральный округ.
        //     districtCollections[districtName].events.add('mouseenter', function (event) {
        //         var district = event.get('target').getParent();
        //         district.options.set({fillOpacity: 1});
        //     });
        //     // При выводе курсора за пределы объекта вернем опции по умолчанию.
        //     districtCollections[districtName].events.add('mouseleave', function (event) {
        //         var district = event.get('target').getParent();
        //         if (district !== highlightedDistrict) {
        //             district.options.set({fillOpacity: 0.3});
        //         }
        //     });
        //     // Подпишемся на событие клика.
        //     districtCollections[districtName].events.add('click', function (event) {
        //         var target = event.get('target');
        //         var district = target.getParent();
        //         // Если на карте выделен федеральный округ, то мы снимаем с него выделение.
        //         if (highlightedDistrict) {
        //             highlightedDistrict.options.set({fillOpacity: 0.3})
        //         }
        //         // Откроем балун в точке клика. В балуне будут перечислены регионы того федерального округа,
        //         // по которому кликнул пользователь.
        //         //districtBalloon.open(event.get('coords'), district.properties.districts.join('<br>'));
        //         // Выделим федеральный округ.
        //         district.options.set({fillOpacity: 1});
        //         // Сохраним ссылку на выделенный федеральный округ.
        //         highlightedDistrict = district;
        //     });
        // }
    // })

}