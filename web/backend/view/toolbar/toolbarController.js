/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.view.toolbar.toolbarController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.toolbarController',
    onClick: function () {
        window.location = BASE_PATH + 'login/cerrarSesion';
    },
    onClickSplitButton: function(t){
        t.showMenu();
    }
    
});
