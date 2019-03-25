/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.view.reportes.resumenUser.gridResumenUsuariosController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.gridResumenUsuariosController',

    onReset: function () {
        this.getView().down('textfield').reset();
        this.getView().getStore().clearFilter();
        this.getView().down('button[text="Resetear"]').setDisabled(true);
    },
    onAfterRender: function (t) {
        t.getStore().sort('usuario', 'ASC');
    },
    onKeyUp : function(t){
        this.getView().getStore().filter('usuario', t.getValue());
        this.getView().down('button[text="Resetear"]').setDisabled(false);
    }

});
