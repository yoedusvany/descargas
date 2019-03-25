Ext.define('Comun.graficas.PieDescargasNacInt', {
    extend: 'Ext.chart.PolarChart',
    alias: 'widget.pieDescargasNacInt',
    width: '90%',
    //height: '100%',
    listeners : {
        afterrender :function(t){
            t.setHeight(t.findParentByType('panel').getHeight()-50);
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
    store: Ext.create("Descargas.store.graficas.DescNacInt"),
    series: {
        type: 'pie3d',
        highlight: true,
        angleField: 'cant',
        label: {
            field: 'tipo',
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
                tooltip.setHtml(record.get('tipo') + ': ' + record.get('cant')+' descargas');
            }
        }
    }

});