/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Ext.define('DescargasBackend.store.ResumenUsuarios', {
    extend: 'Ext.data.Store',
    requires: [
        'DescargasBackend.model.ResumenUsuarios',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json'
    ],
    constructor: function (cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
                storeId: 'ResumenUsuarios',
                autoLoad: true,
                autoSync: true,
                groupField: 'date',
                model: 'DescargasBackend.model.ResumenUsuarios',
                proxy: {
                    type: 'ajax',
                    url: BASE_PATH + "descargas/getResumenusuarios",
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