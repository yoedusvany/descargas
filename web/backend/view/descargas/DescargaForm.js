/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('DescargasBackend.view.descargas.DescargaForm', {
    extend: 'Ext.form.Panel',
    alias: 'widget.descargaForm',
    requires: [
        'DescargasBackend.view.descargas.DescargaFormController'
    ],
    controller: 'descargasFormController',
    url: BASE_PATH + "descargas/insertar",
    layout: 'anchor',
    defaults: {
        anchor: '100%'
    },
    bodyPadding: 5,
    defaultType: 'textfield',
    initComponent: function () {
        Ext.apply(this, {
            defaults: {
                anchor: '95%',
                allowBlank: false,
                selectOnFocus: true,
                msgTarget: 'side'
            },
            items: [
                {
                    xtype: 'fieldcontainer',
                    fieldLabel: 'URL',
                    labelWidth: 100,
                    items: [
                        {
                            xtype: 'textfield',
                            labelAlign: 'top',
                            width: '100%',
                            fieldLabel: 'FORMATO: http://sitio.dominio/.../fichero.ext',
                            name: 'url',
                            vtype: 'url', //se requiere una url (http://ejemplo.com)
                            emptyText: 'URL...', //aparecer el nombre dentro del texfield
                            allowBlank: false
                        }
                    ]
                },
                {
                    xtype: 'textarea',
                    fieldLabel: 'Descripci&oacute;n',
                    name: 'desc',
                    allowBlank: false
                },
                {
                    fieldLabel: 'Nombre alternativo',
                    name: 'nameAlternativo',
                    anchor: '60%',
                    allowBlank: true,
                    emptyText: 'Nombre del fichero sin la ext.'
                }],
            buttons: [{
                    text: 'Reset',
                    icon: BASE_PATH + 'web/images/reset.png',
                    handler: function () {
                        this.up('form').getForm().reset();
                    }
                }, {
                    text: 'Insertar',
                    icon: BASE_PATH + 'web/images/add.png',
                    formBind: true, //only enabled once the form is valid
                    disabled: true,
                    listeners: {
                        click: {fn: 'onSubmit'}
                    }
                }]
        });

        this.callParent(arguments);
    }

});