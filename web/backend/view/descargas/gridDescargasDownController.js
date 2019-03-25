/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.view.descargas.gridDescargasDownController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.gridDescargasDownController',
    init: function(view) {
        var task = Ext.TaskManager.start({
            run: function() {
                view.getStore().removeAll();
                view.getStore().reload();
            },
            interval: 3000
        });
    },
    rowclick: function (t, r, tr, rowIndex) {

    }
});
