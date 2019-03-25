/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('Descargas.store.descargas.Extensiones', {
    extend: 'Ext.data.Store', 
    requires: [
        'Descargas.model.Extensiones',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json'
    ],
    constructor: function (cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
                storeId: 'Extensiones',
                autoLoad: true,
                model: 'Descargas.model.Extensiones',
                proxy: {
                    type: 'ajax',
                    url: BASE_PATH+"descargas/getExtensiones",
                    actionMethods: {read: "POST"},
                    reader: {
                        type: 'json',
                        rootProperty: 'data',
                        successProperty : 'success',
                        totalProperty : 'total'
                    }
                }
            }, cfg)]);
    }
});