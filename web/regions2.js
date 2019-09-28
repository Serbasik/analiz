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
var map = undefined;

ymaps.ready(init);

function init() {


    map = new ymaps.Map('map', {
        center: [65, 100],
        zoom: 2,
        type: null,
        controls: ['zoomControl']
    });
    map.controls.get('zoomControl').options.set({size: 'small'});
    // Добавим заливку цветом.
    var pane = new ymaps.pane.StaticPane(map, {
        zIndex: 100, css: {
            width: '100%', height: '100%', backgroundColor: '#ccc'
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
}


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
            feature.properties.hintContent = iso;

            var dat = testData[iso];

            if (dat) {
                feature.options.fillColor = dat.val;
            }

            return feature;
        }));
    map.geoObjects.add(regions);
}
//!!!

function updateData(newData) {
    console.log(regions);
//nhfvjklhkjghjkh
    regions.objects.each(function (feature) {
        console.log(feature);
        feature.options.fillColor = newData;
    });
    map.geoObjects.remove();
    map.geoObjects.add(regions);
}