/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define("DescargasBackend.view.pregunta.GridPreguntas", {
    extend: 'Ext.grid.Panel',
    alias: "widget.gridPreguntas",
    requires: [
        'DescargasBackend.view.pregunta.GridPreguntasController',
        'DescargasBackend.view.pregunta.PreguntasForm'
    ],
    controller: 'gPreguntasController',
//configuracion del grid
    //title: 'Listado de preguntas',
    scrollable: 'vertical',
    loadMask: true,
    stripeRows: true,
    listeners: {
        rowdblclick: {fn: 'onRowDbClick'},
        afterrender: {fn: 'onAfterRender'}
    },
    initComponent: function () {
        var me = this;
        var s = me.createPreguntasStore();
        me.store = s;
        //columnas
        me.columns = [
            {
                xtype: 'rownumberer',
                flex: 0.2
            },
            {
                text: 'Pregunta',
                dataIndex: 'pregunta',
                minWidth: 0.2,
                flex: 3
            },
            {
                text: 'Fecha',
                dataIndex: 'fecha',
                xtype: 'datecolumn',
                format: 'Y-m-d',
                minWidth: 0.3,
                flex: 0.6
            },
            {
                text: 'Resuelta',
                dataIndex: 'resuelta',
                minWidth: 0.3,
                flex: 0.6
            }
        ];

        me.dockedItems = [{
                xtype: 'toolbar',
                items: [
                    {
                        xtype: 'button',
                        icon: BASE_PATH+'web/images/add.png',
                        text: 'Nueva Pregunta',
                        tooltip: 'Clic para a&ntilde;adir nueva pregunta.',
                        listeners: {
                            click: 'onNewPregunta'
                        }
                    }, '-',
                    {
                        xtype: 'textfield',
                        fieldLabel: 'Filtro por pregunta',
                        labelWidth: 120,
                        enableKeyEvents: true,
                        listeners: {
                            keyup: {fn: 'onKeyUp'}
                        }
                    },'-',
                    {
                        xtype: 'checkbox',
                        boxLabel: 'Respondidas',
                        name: 'respondida',
                        inputValue: '1',
                        listeners: {
                            change: {fn: 'onCheck'}
                        }
                        /*handler: function () {
                         me.s.filter('resuelta','SI');
                         }*/
                    }
                ]
            }];

        me.plugins = [{
                ptype: 'rowexpander',
                rowBodyTpl: new Ext.XTemplate(
                        '<p><b>Respuesta:</b> {respuesta}</p>',
                        '<p><b>Fecha:</b> {respuesta_fecha}</p>',
                        '<p><b>usuario:</b> {username}</p>'
                        )
            }];

        me.callParent();
    },
    createPreguntasStore: function () {
        return Ext.create('DescargasBackend.store.Preguntas');
    }
});
