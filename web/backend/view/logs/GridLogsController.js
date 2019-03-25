/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.view.logs.GridLogsController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.gLogsController',
    mySelect: function (f, v) {
        var g = this.getView();
        g.getStore().reload({
            params:{
                fecha : f.getRawValue()
            }
        });
    },
    myReset: function () {
        var g = this.getView();
        
        var df = g.down('dfLogs');
        df.reset();
        
        var tfUsuarios = g.down('textfield[fieldLabel="Usuario"]');
        tfUsuarios.reset();
        
        g.getStore().clearFilter();
        g.getStore().load();
    },
    filterUser: function (t) {
        var g = this.getView();
        g.getStore().filter({
            property : 'usuario',
            value    : t.getValue()
        });
    }
});
