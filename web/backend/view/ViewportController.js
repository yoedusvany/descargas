/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.view.ViewportController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.viewportController',

    onRender: function (t) {
        if(email !== 'SI'){
            Ext.create('DescargasBackend.view.mail.SetEmail').show();
        }
    }
});
