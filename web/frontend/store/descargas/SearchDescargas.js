/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('Descargas.store.descargas.SearchDescargas', {
    extend: 'Ext.data.Store',
    requires: [
        'Descargas.model.Descargas',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json'
    ],
    constructor: function (cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
                storeId: 'Descargas',
                autoLoad: true,
                groupField: 'date',
                model: 'Descargas.model.Descargas',
                proxy: {
                    type: 'ajax',
                    url: BASE_PATH + "descargas/listarTodas",
                    actionMethods: {read: "POST"},
                    reader: {
                        type: 'json',
                        rootProperty: 'data',
                        successProperty: 'success',
                        totalProperty: 'total'
                    }
                },
                filters: [
                    {
                        property: 'name'
                    }

                ]
            }, cfg)]);
    }
});