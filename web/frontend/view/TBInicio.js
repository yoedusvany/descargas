/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('Descargas.view.TBInicio', {
    extend: 'Ext.toolbar.Toolbar',
    alias: 'widget.tbInicio',
    requires: [
        'Ext.button.Button',
        'Ext.button.Split',
        'Ext.toolbar.Spacer',
        'Ext.toolbar.TextItem',
        'Ext.Img'
    ],
    cls: 'app-header',
    height : 80,
    
    items: [
        {
            xtype: 'image',
            src: BASE_PATH+'web/images/descargas.png',
            width: 70,
            height: 70
        },
        '<span style="font-size:23px;color:#FFFFFF">GESTOR DE DESCARGAS CENTRALIZADAS</span>',
        '->', // same as { xtype: 'tbfill' }
        {
            // xtype: 'button', // default for Toolbars
            text: 'Iniciar Sesi&oacute;n',
            icon : BASE_PATH+'web/images/Lock.png',
            scale:'large',
            tooltip:'Clic para iniciar sesi&oacute;n en el sistema'
        }

    ]
});