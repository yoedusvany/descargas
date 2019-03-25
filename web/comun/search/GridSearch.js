/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define("Comun.search.GridSearch", {
    extend: 'Ext.grid.Panel',
    alias: 'widget.gridSearch',
//    
    requires: [
        'Comun.search.SearchController',
        'Comun.ComboExtensiones'
    ],
    controller: 'searchController',
//    
    listeners: {//step 3
        rowclick: {fn: 'rowclick'},
        beforeload: {fn: 'mybeforeload'},
        rowdblclick: {fn: 'rowdblclick'}        
    },
    stripeRows: true,
    //autoScroll: true,
    //scrollable: true,
    loadMask: true,
//    
    initComponent: function () {
        var me = this;
        var s = me.createSearchDescargasStore();
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
            }
        ];
        me.dockedItems = [{
                xtype: 'toolbar',
                items: [
                    {
                        xtype: 'textfield',
                        fieldLabel : 'Nombre de fichero',
                        labelWidth : 120,
                        enableKeyEvents: true,
                        listeners: {
                            keypress: 'onKeyPress'
                        }
                    }, '-',
                    {
                        xtype: 'comboExtensiones',
                        listeners: {
                            select: 'onSelect'
                        }
                    }, '-',
                    {
                        xtype: 'textfield',
                        fieldLabel : 'Descripci&oacute;n',
                        labelWidth : 75,
                        enableKeyEvents: true,
                        listeners: {
                            keypress: 'onKeyPressDesc'
                        }
                    }, '-',
                    {
                        text: 'Resetear',
                        iconCls: 'icon-reset',
                        disabled: true,
                        listeners: {
                            click: 'onReset'
                        }
                    }, '->',
                    {
                        xtype: 'button',
                        iconCls: 'icon-openFile',
                        text: 'Abrir fichero',
                        disabled: true,
                        tooltip:'Clic para abrir el adjunto.<br> Puede hacerlo tambi&eacute;n con doble clic en la fila.',
                        listeners: {
                            click: 'onOpenFile'
                        }
                    }
                ]
            }];
        me.features = [Ext.create('Ext.grid.feature.Grouping', {
                startCollapsed: false,
                groupers: [{
                        property: 'ext',
                        groupHeaderTpl: [
                            'Fecha: {name:this.formatName} ({rows.length} Descarga{[values.rows.length > 1 ? "s" : ""]})',
                            {
                                formatName: function (name) {
                                    return Ext.Date.format(name, 'Y-m-d');
                                }
                            }
                        ]
                    }]
            })];

        me.callParent();
    },
    createSearchDescargasStore: function () {
        return Ext.create('Descargas.store.descargas.SearchDescargas');
    }
});

