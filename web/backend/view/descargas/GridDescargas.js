Ext.define("DescargasBackend.view.descargas.GridDescargas", {
    extend: 'Ext.grid.Panel',
    alias: 'widget.gridDescargas',
//    
    requires: [
        'DescargasBackend.view.descargas.gridDescargasController',
        'DescargasBackend.view.descargas.InfoDescarga'
    ],
    controller: 'gridDescargasController',
    //autoScroll : true,
    scrollable: 'vertical',
    loadMask: true,
    stripeRows: true,
//    
    listeners: {//step 3
        rowclick: {fn: 'rowclick'},
        beforeload: {fn: 'mybeforeload'},
        rowdblclick: {fn: 'rowdblclick'}
    },
//    
    initComponent: function () {
        var me = this;
        var s = me.createDescargasStore();
        me.store = s;

        me.columns = [
            {
                xtype: 'rownumberer',
                width: 40
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
            },
            {
                xtype: 'actioncolumn',
                width: 50,
                items: [{
                        icon: BASE_PATH + 'web/images/delete.png', // Use a URL in the icon config
                        tooltip: 'Borrar',
                        isDisabled: function (v, r, c, i, record) {
                            if (record.data.finalized === "NO") {
                                return false;
                            } else
                                return true;
                        },
                        handler: function (grid, rowIndex, colIndex) {
                            var rec = grid.getStore().getAt(rowIndex);
                            if (rec.data.finalized != 'SI') {
                                grid.getStore().remove(rec);

                                Ext.Ajax.request({
                                    url: BASE_PATH + 'descargas/borrar',
                                    params: {
                                        id_file: rec.data.id_file
                                    },
                                    success: function (response, opts) {
                                        Ext.Msg.show({
                                            title: 'Informaci&oacute;n',
                                            msg: 'Se ha eliminado satisfactoriamente la descarga',
                                            buttons: Ext.Msg.OK,
                                            icon: Ext.Msg.INFO
                                        });
                                    },
                                    failure: function (response, opts) {
                                        Ext.Msg.show({
                                            title: 'Error',
                                            msg: "Las descargas terminadas no pueden borrarse para que otros usuarios puedan acceder a las mismas.",
                                            buttons: Ext.Msg.OK,
                                            icon: Ext.Msg.ERROR
                                        });
                                    }
                                });
                            }
                        }

                    }]
            }
        ];
        me.dockedItems = [{
                xtype: 'toolbar',
                items: [
                    {
                        xtype: 'button',
                        icon: BASE_PATH + 'web/images/add.png',
                        text: 'Nueva descarga',
                        tooltip: 'Clic para a&ntilde;adir nueva descarga.',
                        listeners: {
                            click: 'onNewDownload'
                        }
                    },
                    '-',
                    {
                        xtype: 'datefield',
                        anchor: '100%',
                        fieldLabel: 'Filtre por fecha',
                        name: 'date',
                        maxValue: new Date(),
                        listeners: {
                            select: {fn: 'onSelecFilterFecha'}
                        }
                    },
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
                    },
                    {
                        text: 'Resetear',
                        iconCls: 'icon-reset',
                        disabled: true,
                        listeners: {
                            click: 'onReset'
                        }
                    },'-',
                    {
                        text: 'Info',
                        icon: BASE_PATH + 'web/images/info1.png',
                        //iconCls: 'icon-infodescarga',
                        id : 'idbInfoDes',
                        disabled: true,
                        listeners: {
                            click: 'onInfo'
                        }
                    },
                    '->',
                    {
                        xtype: 'button',
                        iconCls: 'icon-openFile',
                        text: 'Abrir fichero',
                        disabled: true,
                        tooltip: 'Clic para abrir el adjunto.<br> Puede hacerlo tambi&eacute;n con doble clic en la fila.',
                        listeners: {
                            click: 'onOpenFile'
                        }
                    }
                ]
            }];
        me.features = [{
                ftype: 'grouping',
                startCollapsed: false,
                groupHeaderTpl: [
                    'Fecha: {name:this.formatName} ({rows.length} Descarga{[values.rows.length > 1 ? "s" : ""]})',
                    {
                        formatName: function (name) {
                            return Ext.String.trim(name);
                        }
                    }
                ]
            }
        ],
                me.callParent();
    },
    createDescargasStore: function () {
        return Ext.create('DescargasBackend.store.Descargas');
    }
});

