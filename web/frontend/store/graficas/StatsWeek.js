Ext.define('Descargas.store.graficas.StatsWeek', {
    extend: 'Ext.data.Store', 
    requires: [
        'Descargas.model.StatsWeek',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json'
    ],
    constructor: function (cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
                storeId: 'StatsWeek',
                autoLoad: true,
                model: 'Descargas.model.StatsWeek',
                proxy: {
                    type: 'ajax',
                    url: BASE_PATH+"descargas/getStatsWeek",
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