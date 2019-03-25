Ext.define('Descargas.store.graficas.StatsByMonth', {
    extend: 'Ext.data.Store', 
    requires: [
        'Descargas.model.StatsByMonth',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json'
    ],
    constructor: function (cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
                storeId: 'StatsByMonth',
                autoLoad: true,
                model: 'Descargas.model.StatsByMonth',
                proxy: {
                    type: 'ajax',
                    url: BASE_PATH+"descargas/getEstadisticaInfoxMes",
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