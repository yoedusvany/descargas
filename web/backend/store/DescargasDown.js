/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.store.DescargasDown',{
    extend: 'Ext.data.Store',
    requires: [
        'DescargasBackend.model.DescargasDown',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json'
    ],
    constructor: function (cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
                storeId: 'DescargasDown',
                autoLoad: true,
                pageSize : 0,
                model: 'DescargasBackend.model.DescargasDown',
                proxy: {
                    type: 'ajax',
                    url: BASE_PATH + "descargas/getDescargasDescargandose",
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