/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('Descargas.controller.App', {
    extend: 'Ext.app.Controller',
    requires: [
//vistas principales del frontend        
        'Descargas.view.TBInicio',
        'Descargas.view.TabInicio',
        'Descargas.view.ViewportInicio',
        'Descargas.view.login.Login',
//para la grid de busqueda        
        'Comun.search.GridSearch',
    ],

    
    stores: [
        'Sedes',
    ],
    
    config: {
        refs: {
            myToolbar: {
                selector: 'tbInicio',
                xtype: 'tbInicio',
                autoCreate: false
            }
        }
    },
    
    init: function () {
        var me = this;

        this.control({
            'tbInicio button' :{
                click: me.showFormLogin
            }
        });
    },
    showFormLogin: function (t) {
        Ext.create('Ext.window.Window', {
            title: 'Iniciar sesi&oacute;n',
            icon : BASE_PATH+'web/images/Lock.png',
            height: 220,
            width: 400,
            layout: 'fit',
            animateTarget: t,
            modal : true,
            
            items: {
                xtype: 'fLogin',
                border: false
            }
        }).show();
    }
});
