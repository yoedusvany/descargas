/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('DescargasBackend.store.Preguntas', {
    extend: 'Ext.data.Store',
    requires: [
        'DescargasBackend.model.Preguntas',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json'
    ],
    constructor: function (cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
                storeId: 'Preguntas',
                autoLoad: true,
                model: 'DescargasBackend.model.Preguntas',
                proxy: {
                    type: 'ajax',
                    url: BASE_PATH + "preguntas/listar",
                    //destroy : BASE_PATH+"preguntas/borrar",
                    actionMethods: {read: "POST"},
                    reader: {
                        type: 'json',
                        rootProperty: 'data',
                        successProperty: 'success',
                        totalProperty: 'total'
                    }
                    /*writer: {
                        type: 'json',
                        encode: true,
                        writeAllFields: false,
                        root: 'data'
                    }*/
                }
            }, cfg)]);
    }
});