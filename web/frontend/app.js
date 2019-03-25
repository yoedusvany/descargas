/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.Loader.setConfig({
    enabled: true,
    paths: {
        'Descargas': 'web/',
        'Comun': 'web/comun'
    }
});


Ext.application({
    appFolder: "web/frontend",
    name: 'Descargas',
    
    controllers: [
        'App'
    ],

    launch: function () {
        Ext.create('Descargas.view.ViewportInicio');
    }
});