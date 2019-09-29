var testData;
var color_nodata = '#555964';


var regions = undefined;
var map = undefined;

ymaps.ready(init);

function init() {


    map = new ymaps.Map('map', {
        center: [65, 100],
        zoom: 3,
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
                fillColor: '#d2d2d2',
                fillOpacity: 0.8,
                hintCloseTimeout: 0,
                hintOpenTimeout: 0
            };

            var iso = feature.properties.iso3166;
            var name = feature.properties.name;
            feature.properties.hintContent = name;

           var dat;

            if (dat) {
                feature.options.fillColor = dat.val;
            }

            return feature;
        }));
    map.geoObjects.add(regions);
}

// var color1 = '#ff1f1a';
// var color2 = '#28ff48';


var color1 = '#8c92a1';
var color2 = '#ab4343';
var color3 = '#7a2424';

// #ff9999
// #ab4343
// #7a2424



function updateData(newData) {

    // var mapObj = new Map();
    // $.each(newData, function(itm) {
    //         console.log(itm.RegionId);
    //         console.log(itm);
    //     }
    // );

    var mp = newData.reduce(function(map, obj) {
        map[obj.RegionId] = obj;
        return map;
    }, {});

    console.log(mp);
    //console.log("sssss");
    regions.objects.each(function (feature) {
        var itm = mp[feature.id];
        //console.log(itm.value);
       //console.log(itm);

        if(!itm) {
            feature.options.fillColor = '#555964'
            feature.properties.hintContent = feature.properties.name;
        } else {
            var v = itm.value;
            var c;
            if(v >= 6.5) {
                c = color3;
            } else if(v >= 5.8) {
                c = color2;
            } else {
                c = color1;
            }

//console.log(itm.info)
            //var gr  = gradColor(color1, color2, v / 10);
            //console.log(gr);
            feature.options.fillColor = c;

            if(itm.info == null) {
                feature.properties.hintContent = feature.properties.name;
            } else {
                if(itm.an == null ) {
                    feature.properties.hintContent = itm.info;
                } else {
                    feature.properties.hintContent = itm.info +  "<br/>" + itm.an;
                }
            }
        }

    });
    map.geoObjects.remove();
    map.geoObjects.add(regions);
}