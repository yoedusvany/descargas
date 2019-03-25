Ext.define("DescargasBackend.view.reportes.resumenUser.GridResumenUsuarios", {
    extend: 'Ext.grid.Panel',
    alias: 'widget.gridResumenUsuarios',
//    
    requires: [
        'DescargasBackend.view.reportes.resumenUser.gridResumenUsuariosController'
    ],
    controller: 'gridResumenUsuariosController',

    listeners: {
        afterrender : {fn:'onAfterRender'}
    },

    scrollable: 'vertical',
    loadMask: true,
    stripeRows: true,
//    
    initComponent: function () {
        var me = this;
        var s = me.createResumenUsuariosStore();
        me.store = s;

        me.columns = [
            {
                xtype: 'rownumberer',
                width: 50
            },
            {
                text: 'Usuario',
                dataIndex: 'usuario',
                minWidth: 145,
                flex: 1
            },
            {
                text: 'Cant. de descargas',
                //xtype: 'numbercolumn',
                dataIndex: 'cantDescargas',
                minWidth: 41,
                flex: 1
            },
            {
                text: 'Total descargado',
                xtype: 'numbercolumn',
                dataIndex: 'size',
                minWidth: 75,
                flex: 0.7,
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
            },
            {
                text: '% nacionales',
                dataIndex: 'nacionales',
                flex: 1,
                xtype: 'widgetcolumn',
                widget: {
                    xtype: 'progressbarwidget',
                    textTpl: '{value:percent}'
                }
            },
            {
                text: '% Internacionales',
                dataIndex: 'internacionales',
                minWidth: 85,
                flex: 1,
                xtype: 'widgetcolumn',
                widget: {
                    xtype: 'progressbarwidget',
                    textTpl: '{value:percent}'
                }
            }
        ];

        me.dockedItems = [{
            xtype: 'toolbar',
            items: [
                {
                    xtype:'textfield',
                    fieldLabel : 'Filtrar por usuario',
                    labelWidth:120,
                    enableKeyEvents: true,
                    listeners : {
                        keyup : {fn:"onKeyUp"}
                    }
                },
                {
                    text: 'Resetear',
                    icon: BASE_PATH+'web/images/reset.png',
                    disabled: true,
                    listeners: {
                        click: 'onReset'
                    }
                }
            ]
        }];

        me.callParent();
    },
    createResumenUsuariosStore: function () {
        return Ext.create('DescargasBackend.store.ResumenUsuarios');
    }
});

