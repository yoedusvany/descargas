/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.Loader.setConfig({
    enabled: true,
    paths: {
        'DescargasBackend': 'web/',
        'Descargas': 'web/frontend',
        'Comun': 'web/comun',
        //'Ext.ux': 'ext/packages/ux/classic'
        //'Ext.chart': 'ext/packages/src/chart',
        //'Ext.draw': 'ext/packages/src/draw'
    }
});


Ext.application({
    appFolder: "web/backend",
    name: 'DescargasBackend',
    
    requires: [
        'DescargasBackend.view.ViewportApp'
    ],

    launch: function () {
        Ext.create('DescargasBackend.view.ViewportApp');
    }
});