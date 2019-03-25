Ext.define('Comun.graficas.statsByMonth', {
    extend: 'Ext.chart.CartesianChart',
    alias: 'widget.statsByMonth',
    width: '90%',
    listeners : {
        afterrender :function(t){
            t.setHeight(t.findParentByType('panel').getHeight()-50);
        }
    },
    //theme: 'blue',

    insetPadding: {top: 60, bottom: 20, left: 20, right: 40},
    store: Ext.create("Descargas.store.graficas.StatsByMonth"),
    axes: [{
            type: 'numeric3d',
            position: 'left',
            fields: 'total',
            //maximum: 4000000,
            majorTickSteps: 10,
            label: {
                textAlign: 'right',
                font:'8px sans-serif'
            },
            //renderer: 'onAxisLabelRender',
            title: 'Cant. de bytes',
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
            fields: 'month',
            grid: true,
            label: {
                rotate: {
                    degrees: -45
                },
                font:'8px sans-serif'
            }
        }],
    series: [{
            type: 'bar3d',
            xField: 'month',
            yField: 'total',
            style: {
                minGapWidth: 20
            },
            highlightCfg: {
                saturationFactor: 1.5
            },
            tooltip: {
                trackMouse: true,
                renderer: function (tooltip, record, item) {
                    tooltip.setHtml(record.get('month') + ': ' + Ext.util.Format.number(record.get('total')) + ' (' + record.get('totalConvertido') + ')');
                }
            }
        }]
});