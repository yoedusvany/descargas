Ext.define('Descargas.store.graficas.DescNacInt', {
    extend: 'Ext.data.Store', 
    requires: [
        'Descargas.model.DescNacInt',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json'
    ],
    constructor: function (cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
                storeId: 'DescNacInt',
                autoLoad: true,
                model: 'Descargas.model.DescNacInt',
                proxy: {
                    type: 'ajax',
                    url: BASE_PATH+"descargas/getStatsDescargasNacInt",
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