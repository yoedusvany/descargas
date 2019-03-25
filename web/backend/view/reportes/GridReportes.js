Ext.define("DescargasBackend.view.reportes.GridReportes", {
    extend: 'Ext.grid.Panel',
    alias: 'widget.gridReportes',
//    
    requires: [
        'DescargasBackend.view.reportes.gridReportesController'
    ],
    controller: 'gridReportesController',
    scrollable: 'vertical',
    loadMask: true,
    stripeRows: true,
	listeners: {
		afterrender : {fn:'onAfterRender'}	
	},
//    
    initComponent: function () {
        var me = this;
        var s = me.createDescargasStore();
        me.store = s;

        me.columns = [
            {
                xtype: 'rownumberer',
                width: 50
            },
            {
                text: 'Nombre del fichero',
                dataIndex: 'name',
                minWidth: 145,
                flex: 1
            },
            {
                text: 'Ext.',
                dataIndex: 'ext',
                minWidth: 41,
                flex: 0.2
            },
            {
                text: 'Tama&ntilde;o',
                xtype: 'numbercolumn',
                dataIndex: 'size',
                minWidth: 75,
                flex: 0.3,
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
                text: 'Url',
                dataIndex: 'url',
                flex: 1.5
            },
            {
                text: 'Fecha',
                xtype: 'datecolumn',
                dataIndex: 'date',
                format: 'Y-m-d',
                minWidth: 85,
                flex: 0.3
            },
            {
                text: 'Finalizado?',
                dataIndex: 'finalized',
                minWidth: 85,
                flex: 0.3
            }
        ];
        me.dockedItems = [{
                xtype: 'toolbar',
                items: [
                    {
                        xtype: 'combo',
                        fieldLabel: 'Estado',
                        labelWidth: '5',
                        store: Ext.create('Ext.data.Store', {
                            fields: ['estado'],
                            data: [
                                {"estado": "Finalizada"},
                                {"estado": "No finalizada"}
                            ]
                        }),
                        queryMode: 'local',
                        displayField: 'estado',
                        valueField: 'estado',
                        listeners: {
                            select: {fn: 'onSelect'}
                        }
                    },'-',
                    {
                        xtype: 'datefield',
                        anchor: '100%',
                        fieldLabel: 'Fecha',
                        labelWidth: '5',
                        name: 'date',
                        format : 'Y-m-d',
                        maxValue: new Date(),
                        listeners: {
                            select: {fn: 'onSelecFilterFecha'}
                        }
                    },
                    {
                        text: 'Resetear',
                        icon: BASE_PATH+'web/images/reset.png',
                        disabled: true,
                        listeners: {
                            click: 'onReset'
                        }
                    },
                    '->',
                    {
                        xtype: 'button',
                        icon : BASE_PATH +'web/images/rtf.png',
                        text: 'Exportar',
                        listeners: {
                            click: {fn: 'onExportar'}
                        }
                    }
                ]
            }];

        me.callParent();
    },
    createDescargasStore: function () {
		if(rol === "admin"){
	        return Ext.create('Descargas.store.descargas.SearchDescargas');
		}else{
	        return Ext.create('DescargasBackend.store.Descargas');
		}

    }
});

