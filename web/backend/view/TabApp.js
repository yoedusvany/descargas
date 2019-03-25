/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var items = [];

items[0] = {
    title: 'DESCARGAS',
    tabConfig: {
        tooltip: 'Listado de descargas suyas'
    },
    icon: BASE_PATH + 'web/images/4.png',
    iconCls: 'icon-descargas1',
    layout: 'fit',
    listeners : {
        activate : function(t){
            t.down('grid').getStore().reload()
        }
    },
    items: [
        {
            xtype: 'gridDescargas'
        }
    ]
};
items[1] = {
    title: 'B&Uacute;SQUEDA',
    tabConfig: {
        tooltip: 'B&Uacute;SQUEDA AVANZADA DE DESCARGAS'
    },
    iconCls: 'icon-searchtab',
    layout: 'fit',
    listeners : {
        activate : function(t){
            t.down('grid').getStore().reload()
        }
    },
    items: [
        {
            xtype: 'gridSearch'
        }
    ]
};
items[2] = {
    title: 'PREGUNTAS Y RESPUESTAS',
    tabConfig: {
        tooltip: 'CONSULTE A LOS ADMINISTRADORES DEL SISTEMA.'
    },
    iconCls: 'icon-pregunta',
    layout: 'fit',
    listeners : {
        activate : function(t){
            t.down('grid').getStore().reload()
        }
    },
    items: [
        {
            xtype: 'gridPreguntas'
        }
    ]
};

if (rol === 'admin') {
    items[3] = {
        title: 'LOGS',
        tabConfig: {
            tooltip: 'LOGS DEL SISTEMA'
        },
        iconCls: 'icon-logs',
        layout: 'fit',
        items: [
            {
                xtype: 'gridLogs'
            }
        ]
    };
    items[4] = {
        title: 'OPCIONES GENERALES',
        tabConfig: {
            tooltip: 'MODIFIQUE LAS OPCIONES GENERALES DEL SISTEMA'
        },
        iconCls: 'icon-opciones-gen',
        layout: 'fit',
        items: [
            {
                xtype: 'optionesGeneralForm'
            }
        ]
    };
}

items[5] = {
    title: 'DESCARGANDOSE AHORA',
    tabConfig: {
        tooltip: 'CONSULTE QUE SE EST&Aacute; DESCARGANDO EN ESTE MISMO INSTANTE'
    },
    iconCls: 'icon-descargandoahora',
    layout: 'fit',
    items: [
        {
            xtype: 'gridDescargasDown'
        }
    ]
};

items[6] = {
    title: 'REPORTES',
    tabConfig: {
        tooltip: 'REPORTES DEL SISTEMA'
    },
    iconCls: 'icon-reporteyoe',
    layout: 'fit',
    listeners : {
        activate : function(t){
            t.down('grid').getStore().reload();
            t.down('gridResumenUsuarios').getStore().reload();
        }
    },
    items: [
        {
            xtype: 'tabpanel',
            items: [{
                title: 'GENERALES',
                xtype: 'gridReportes'
            },{
                title: 'RESUMEN POR USUARIO',
                xtype: 'gridResumenUsuarios'
            }
            ]
        }
    ]
};

items[7] = {
    title: 'ESTAD&Iacute;STICAS',
    tabConfig: {
        tooltip: 'ESTAD&Iacute;STICAS DEL SISTEMA'
    },
    //icon: BASE_PATH + 'web/images/stats.png',
    iconCls: 'icon-stats',
    layout: 'fit',
    items: [
        {
            xtype: 'panelStats'
        }
    ]
};

if (rol === 'admin') {
    items[8] = {
        title: 'USUARIOS',
        tabConfig: {
            tooltip: 'ADMINISTRAR USUARIOS'
        },
        //icon: BASE_PATH + 'web/images/usuarios.png',
        iconCls: 'icon-usuarios',
        layout: 'fit',
        items: [
            {
                xtype: 'gridUsuarios'
            }
        ]
    };
}


Ext.define('DescargasBackend.view.TabApp', {
    extend: 'Ext.tab.Panel',
    alias: 'widget.tabApp',
    bodyPadding: 5,
    //ui: 'navigation',
    tabPosition: 'left',
    tabRotation: 0,
    id : 'idTabApp',
    tabBar: {
        border: false,
        defaults: {
            height: 50 //sets the default height of the actual tab
        },
        height: 65, //sets the height of the tabBar component
        listeners: {
            afterrender: function (cmp) {
                // this will set the height of the tabBar body to the height of the tabBar component
                cmp.body.setHeight(cmp.getHeight());
            }
        }
    },
    defaults: {
        textAlign: 'left',
        bodyPadding: 5
    },
    requires: [
        'Comun.search.GridSearch',
        'DescargasBackend.view.descargas.GridDescargas',
        'DescargasBackend.view.logs.GridLogs',
        'DescargasBackend.view.optionesgeneral.OptionesGeneralForm',
        'DescargasBackend.view.pregunta.GridPreguntas',
        'DescargasBackend.view.descargas.GridDescargasDown',
        'DescargasBackend.view.reportes.GridReportes',
        'DescargasBackend.view.reportes.resumenUser.GridResumenUsuarios',
        'DescargasBackend.view.stats.Stats',
        'DescargasBackend.view.usuarios.GridUsuarios'
    ],
    items: items
});