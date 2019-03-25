/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('DescargasBackend.view.ViewportApp', {
    extend: 'Ext.container.Viewport',
    alias: 'widget.viewportApp',
    requires: [
        'DescargasBackend.view.TabApp',
        'DescargasBackend.view.toolbar.TBApp',
        'DescargasBackend.view.ViewportController',
        'DescargasBackend.view.mail.SetEmail'
    ],
    controller : 'viewportController',
    listeners : {
        afterrender:{fn:'onRender'}
    },
    layout: 'border',
    renderTo: Ext.getBody(),
    items: [
        {
            xtype: 'tbApp',
            region: 'north'
        },
        {
            xtype: 'tabApp',
            region: 'center'
        },
        {
            region: 'south',
            collapsible: false,
            heigth: 100,
            border: true,
            bodyStyle: 'background-color:#112D41;',
            html: '<font color="white"><center>DESARROLLADO POR:<br> MSc. Yoedusvany Hernandez Mendoza, Ing. Elvis Manuel Martin Jaime, MSc. Maite Mart&iacute;nez Gonz&aacute;lez<center></font>'
        }]
});