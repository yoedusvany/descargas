/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define("DescargasBackend.view.logs.GridLogs", {
    extend: 'Ext.grid.Panel',
    alias: "widget.gridLogs",
    requires:[
        'DescargasBackend.view.logs.GridLogsController',
        'DescargasBackend.view.logs.FechaLogs'
    ],
    controller: 'gLogsController',
//configuracion del grid
    scrollable: 'vertical',
    loadMask: true,
    stripeRows: true,
    initComponent: function () {
        var me = this;
        var s = me.createLogsStore();
        me.store = s;
        //columnas
        me.columns = [
            {
                xtype: 'rownumberer',
                flex: 0.2
            },
            {
                text: 'Hora',
                dataIndex: 'hora',
                minWidth: 0.2,
                flex: 0.5
            }, {
                text: 'IP',
                dataIndex: 'ip',
                minWidth: 0.3,
                flex: 0.6
            }, {
                text: 'Usuario',
                dataIndex: 'usuario',
                minWidth: 0.3,
                flex: 0.6
            },
            {
                text: 'Mensaje',
                dataIndex: 'mensaje',
                flex: 2.0
            }
        ];
        //toolbars
        me.dockedItems = [
            {
                xtype: 'toolbar',
                items: [
                    {   
                        xtype: 'dfLogs',
                        listeners :{
                            select : {fn:'mySelect'}
                        }
                    },
                    '-',
                    {
                        xtype:'textfield',
                        fieldLabel : 'Usuario',
                        enableKeyEvents : true,
                        labelWidth : 60,
                        listeners :{
                            keyup : {fn:'filterUser'}
                        }
                    },
                    {
                        xtype: 'button',
                        text: 'Resetear',
                        icon:BASE_PATH+'web/images/reset.png',
                        listeners :{
                            click : {fn:'myReset'}
                        }
                    }
                ]
            }];

        me.callParent();
    },
    createLogsStore: function () {
        return Ext.create('DescargasBackend.store.Logs');
    }
});
