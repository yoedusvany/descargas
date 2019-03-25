/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('DescargasBackend.view.toolbar.TBApp', {
    extend: 'Ext.toolbar.Toolbar',
    alias: 'widget.tbApp',
    
    requires: [
        'Ext.button.Button',
        'Ext.button.Split',
        'Ext.toolbar.Spacer',
        'Ext.toolbar.TextItem',
        'Ext.Img',
        //'Ext.ux.rating.Picker',
        'DescargasBackend.view.toolbar.toolbarController'
    ],
    
    controller: 'toolbarController',
    
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
        /*{
            xtype: 'rating',
            listeners: {
                change: function (picker, value) {
                    console.log('Rating ' + value);
                }
            }
        },*/
        {
            xtype: 'splitbutton',
            text: 'Opciones',
            icon: BASE_PATH + 'web/images/opciones.png',
            scale: 'medium',
            tooltip: 'Opciones del sistema',
            listeners:{
                click : {fn:'onClickSplitButton'}
            },
            menu: new Ext.menu.Menu({
                items: [
                    /*{
                     text: 'Ayuda',
                     iconCls: 'icon-ayuda',
                     disabled: true,
                     id: 'idBTAyuda',
                     tooltip: 'Accede a la ayuda del sistema'
                     },*/
                    {
                        text: 'Acerca de',
                        iconCls: 'icon-acercade',
                        id: 'idBTAcercade',
                        tooltip: 'Informaci&oacute;n sobre el sistema'
                    },
                    {
                        text: 'Cerrar Sesi&oacute;n',
                        iconCls: 'icon-salir',
                        id: 'idBCerrarSesion',
                        tooltip: 'Cerrar la sesi&oacute;n actual',
                        listeners: {
                            click: 'onClick'
                        }
                    }
                ]
            })
        }

    ]
});