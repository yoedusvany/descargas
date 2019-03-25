/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('Descargas.view.ViewportInicio', {
    extend: 'Ext.container.Viewport',
    alias: 'widget.viewportInicio',
    requires: [
        'Descargas.view.TBInicio',
        'Descargas.view.TabInicio'
    ],
    layout: 'border',
    items: [
        {
            xtype : 'tbInicio',
            region: 'north'
        },
        {
            xtype: 'tabInicio',
            region: 'center'
        },
        {
            region: 'south',
            collapsible: false,
            heigth: 100,
            border: true,
            bodyStyle: 'background-color:#112D41;',
            html: '<font color="white"><center>DESARROLLADO POR:<br> MSc. Yoedusvany Hernandez Mendoza, Ing. Elvis Manuel Martin Jaime, MSc. Maite Mart&iacute;nez Gonz&aacute;lez<center></font>'
        }
    ]
});