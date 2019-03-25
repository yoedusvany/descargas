/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('DescargasBackend.controller.Backend', {
    extend: 'Ext.app.Controller',
    requires: [
//vistas principales del backend
        'DescargasBackend.view.toolbar.TBApp',
        'DescargasBackend.view.TabApp',
        'DescargasBackend.view.ViewportApp',
//para las descargas        
        'DescargasBackend.view.descargas.GridDescargas'
    ],
    
    models:[
        //'Descargas',
    ],
    
    stores: [
        'Descargas'
    ],
    
    init: function () {
        var me = this;

        this.control({

        });
    }
});