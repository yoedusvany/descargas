Ext.define('Descargas.store.graficas.StatsDomains', {
    extend: 'Ext.data.Store', 
    requires: [
        'Descargas.model.StatsDomains',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json'
    ],
    constructor: function (cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
                storeId: 'StatsDomains',
                autoLoad: true,
                model: 'Descargas.model.StatsDomains',
                proxy: {
                    type: 'ajax',
                    url: BASE_PATH+"descargas/getStatsPorDominio",
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