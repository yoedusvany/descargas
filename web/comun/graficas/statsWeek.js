Ext.define('Comun.graficas.statsWeek', {
    extend: 'Ext.chart.CartesianChart',
    alias: 'widget.statsWeek',
    width: '90%',
    listeners : {
        afterrender :function(t){
            t.setHeight(t.findParentByType('panel').getHeight()-50);
        }
    },
    //theme: 'blue',

    insetPadding: {top: 60, bottom: 20, left: 20, right: 40},
    store: Ext.create("Descargas.store.graficas.StatsWeek"),
    axes: [{
            type: 'numeric3d',
            minimum : 0,
            position: 'left',
            fields: 'cant',
            //maximum: 4000000,
            //majorTickSteps: 10,
            label: {
                textAlign: 'right'
            },
            //renderer: 'onAxisLabelRender',
            title: 'Cant. de descargas',
            grid: {
                odd: {
                    fillStyle: 'rgba(255, 255, 255, 0.06)'
                },
                even: {
                    fillStyle: 'rgba(0, 0, 0, 0.03)'
                }
            }
        }, {
            type: 'category3d',
            position: 'bottom',
            fields: 'dia',
            grid: true,
            renderer: function(axis, label, layoutContext){
                if(label == 0){
                    return "Domingo";
                }
                if(label == 1){
                    return "Lunes";
                }
                if(label == 2){
                    return "Martes";
                }
                if(label == 3){
                    return "Miercoles";
                }
                if(label == 4){
                    return "Jueves";
                }
                if(label == 5){
                    return "Viernes";
                }
                if(label == 6){
                    return "Sabado";
                }
            },
            label: {
                rotate: {
                    degrees: -45
                },
                font:'10px sans-serif'
            }
        }],
    series: [{
            type: 'bar3d',
            xField: 'dia',
            yField: 'cant',
            style: {
                minGapWidth: 20
            },
            highlightCfg: {
                saturationFactor: 1.5
            },
            tooltip: {
                trackMouse: true,
                renderer: function (tooltip, record, item) {
                    var dia = '';

                    if(record.get('dia') == 0){
                         dia = "Domingo";
                    }
                    if(record.get('dia') == 1){
                        dia =  "Lunes";
                    }
                    if(record.get('dia') == 2){
                        dia = "Martes";
                    }
                    if(record.get('dia') == 3){
                        dia = "Miercoles";
                    }
                    if(record.get('dia') == 4){
                        dia = "Jueves";
                    }
                    if(record.get('dia') == 5){
                        dia =  "Viernes";
                    }
                    if(record.get('dia') == 6){
                        dia = "Sabado";
                    }

                    tooltip.setHtml(dia + ': ' + Ext.util.Format.number(record.get('cant')) + ' descargas.');
                }
            }
        }]
});