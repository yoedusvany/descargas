/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('DescargasBackend.store.Logs',{
    extend: 'Ext.data.Store',
    requires: [
        'DescargasBackend.model.Logs',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json'
    ],
    constructor: function (cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
                storeId: 'Logs',
                autoLoad: true,
                pageSize : 0,
                model: 'DescargasBackend.model.Logs',
                proxy: {
                    type: 'ajax',
                    url: BASE_PATH+"logs/listar",
                    actionMethods: {read: "POST"},
                    reader: {
                        type: 'json',
                        rootProperty: 'data',
                        successProperty: 'success',
                        totalProperty: 'total'
                    }
                }
            }, cfg)]);
    }
});