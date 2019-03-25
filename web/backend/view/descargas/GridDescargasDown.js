Ext.define("DescargasBackend.view.descargas.GridDescargasDown", {
    extend: 'Ext.grid.Panel',
    alias: 'widget.gridDescargasDown',
    //autoScroll : true,
    scrollable: 'vertical',
    loadMask: true,
    stripeRows: true,

    requires: [
        'DescargasBackend.view.descargas.gridDescargasDownController'
    ],
    controller: 'gridDescargasDownController',
//    
    initComponent: function () {
        var me = this;
        var s = me.createDescargasStore();
        me.store = s;

        me.columns = [
            {
                xtype: 'rownumberer',
                width: 30
            },
            {
                text: 'Nombre del fichero',
                dataIndex: 'name',
                minWidth: 145,
                flex: 0.5
            }, {
                text: 'Ext.',
                dataIndex: 'ext',
                minWidth: 41,
                flex: 0.25
            },
            {
                text: 'Url',
                dataIndex: 'url',
                flex: 2.0
            },
            {
                text: 'Fecha registro',
                xtype: 'datecolumn',
                dataIndex: 'date',
                format: 'Y-m-d',
                minWidth: 105,
                flex: 0.4
            },
            {
                text: 'Tama&ntilde;o',
                xtype: 'numbercolumn',
                dataIndex: 'size',
                minWidth: 90,
                flex: 0.4,
                renderer: function (size) {
                    if (size >= 1024 * 1024 * 1024) {
                        unidad = "GB";
                        size = size / 1024 / 1024 / 1024;
                        return Ext.Number.toFixed(size, 2) + " " + unidad;
                    } else {
                        if (size >= 1024 * 1024) {
                            unidad = "MB";
                            size = size / 1024 / 1024;
                            //return number_format($size, 2) . " " . $unidad;
                            return Ext.Number.toFixed(size, 2) + " " + unidad;
                        } else {
                            if (size >= 1024) {
                                unidad = "KB";
                                size = size / 1024;
                                //return number_format($size, 2). " " . $unidad;;
                                return Ext.Number.toFixed(size, 2) + " " + unidad;
                            } else {
                                if (size <= 1023) {
                                    unidad = "Bytes";
                                    size = size;
                                    //return number_format($size, 2) . " " . $unidad;
                                    return Ext.Number.toFixed(size, 2) + " " + unidad;
                                }
                            }
                        }

                        //return Ext.String.format('<a href="mailto:{0}">{1}</a>', value, value);
                    }
                }
            }, {
                text: 'Usuario',
                dataIndex: 'username',
                minWidth: 85,
                flex: 0.35
            },
            {
                text: 'Progreso',
                width: 150,
                xtype: 'widgetcolumn',
                dataIndex: 'progreso',
                widget: {
                    xtype: 'progressbarwidget',
                    textTpl: '{value:percent}'
                }
            }
        ];

        me.callParent();
    },
    createDescargasStore: function () {
        return Ext.create('DescargasBackend.store.DescargasDown');
    }
});

