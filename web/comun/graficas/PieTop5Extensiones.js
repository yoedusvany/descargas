Ext.define('Comun.graficas.PieTop5Extensiones', {
    extend: 'Ext.chart.PolarChart',
    alias: 'widget.pieTop5Extensiones',
    width: '90%',
    //height: '100%',
    listeners: {
        afterrender: function (t) {
            t.setHeight(t.findParentByType('panel').getHeight() - 70);
        }
    },
    //theme: 'blue',
    interactions: ['rotate', 'itemhighlight'],
    insetPadding: {
        top: 50,
        left: 25,
        right: 25,
        bottom: 15
    },
    innerPadding: 10,
    highlight: true,
    store: Ext.create("Descargas.store.graficas.Top5Extensiones"),
    /*legend: {
        docked: 'top',
        border: 0,
        style: {borderColor: 'red'},
        tpl: [
            '<tpl for=".">',
            '<div class="myLegendItem" style="float:left;margin:5px;padding:0px;cursor:pointer;">',
            '<div class="" style="float:left;margin:2px;width:10px;height: 10px; background:{mark};opacity:.6"></div><div style="float:left;">{name}</div>',
            '</div>',
            '</tpl>'
        ],
        itemSelector: '.myLegendItem'
    },*/
    series: {
        type: 'pie3d',
        highlight: true,
        angleField: 'cant',
        label: {
            field: 'ext',
            display: 'rotate',
            calloutLine: {
                length: 60,
                width: 3
            }
        },
        donut: 20,
        tooltip: {
            trackMouse: true,
            renderer: function (tooltip, record, item) {
                tooltip.setHtml(record.get('ext') + ': ' + record.get('cant') + ' descargas');
            }
        }
    }

});