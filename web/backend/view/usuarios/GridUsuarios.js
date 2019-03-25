Ext.define("DescargasBackend.view.usuarios.GridUsuarios", {
    extend: 'Ext.grid.Panel',
    alias: 'widget.gridUsuarios',
//    
    requires: [
        'DescargasBackend.view.usuarios.gridUsuariosController'
    ],
    controller: 'gridUsuariosController',
    //autoScroll : true,
    scrollable: 'vertical',
    loadMask: true,
    stripeRows: true,
//    
    listeners: {//step 3
        rowclick: {fn: 'rowclick'},
        beforeload: {fn: 'mybeforeload'},
        rowdblclick: {fn: 'rowdblclick'}
    },

    selType: 'rowmodel',
    plugins: {
        ptype: 'rowediting',
        clicksToEdit: 1,
        listeners: {
            edit: 'onGridEditorEdit'
        }
    },
//    
    initComponent: function () {
        var me = this;
        var s = me.createUsuariosStore();
        me.store = s;

        me.columns = [
            {
                xtype: 'rownumberer',
                width: 40
            },
            {
                text: 'Usuario',
                dataIndex: 'username',
                minWidth: 50,
                flex: 0.5
            },
            {
                text: 'Email.',
                dataIndex: 'email',
                minWidth: 50,
                flex: 0.5
            },

            {
                text: 'Rol',
                dataIndex: 'rol',
                minWidth: 50,
                flex: 1,
                editor: {
                    xtype: 'combobox',
                    store:  Ext.create('Ext.data.Store', {
                        model:  Ext.define('User', {
                                    extend: 'Ext.data.Model',
                                    fields: [
                                        {name: 'rol', type: 'string'}
                                    ]
                                }),
                        data : [
                            {rol: ''},
                            {rol: 'admin'},
                            {rol: 'adminlocal'}
                        ]
                    }),
                    displayField: 'rol',
                    valueField: 'rol',
                    editable: false,
                    queryMode: 'local',
                    forceSelection: true,
                    triggerAction: 'all',
                    allowBlank: false
                }
            }
        ];

        me.callParent();
    },
    createUsuariosStore: function () {
        return Ext.create('DescargasBackend.store.Usuarios');
    }
});

