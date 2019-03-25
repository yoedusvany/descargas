/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('DescargasBackend.store.Usuarios', {
    extend: 'Ext.data.Store',
    requires: [
        'DescargasBackend.model.Usuarios',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json'
    ],
    constructor: function (cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
                storeId: 'Usuarios',
                autoLoad: true,
                autoSync: true,
                groupField: 'date',
                model: 'DescargasBackend.model.Usuarios',
                proxy: {
                    type: 'ajax',
                    url: BASE_PATH + "usuarios/listar",
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