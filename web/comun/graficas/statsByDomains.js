Ext.define('Comun.graficas.statsByDomains', {
    extend: 'Ext.chart.CartesianChart',
    alias: 'widget.statsByDomains',
    width: '90%',
    listeners : {
        afterrender :function(t){
            t.setHeight(t.findParentByType('panel').getHeight()-50);
        }
    },
    //theme: 'blue',

    insetPadding: {top: 60, bottom: 20, left: 20, right: 40},
    store: Ext.create("Descargas.store.graficas.StatsDomains"),
    axes: [{
            type: 'numeric3d',
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
            fields: 'dominio',
            grid: true,
            label: {
                rotate: {
                    degrees: -45
                },
                font:'10px sans-serif'
            }
        }],
    series: [{
            type: 'bar3d',
            xField: 'dominio',
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
                    tooltip.setHtml(record.get('dominio') + ': ' + Ext.util.Format.number(record.get('cant')));
                }
            }
        }]
});