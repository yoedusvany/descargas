/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.view.optionesgeneral.OptionesGeneralForm', {
    extend: 'Ext.form.Panel',
    alias: 'widget.optionesGeneralForm',
    requires: [
        'DescargasBackend.view.optionesgeneral.OGFormController'
    ],
    controller: 'ogFormController',
    url: BASE_PATH + "descargas/updateOpcionesGenerales",
    layout: 'anchor',
    defaults: {
        anchor: '100%',
        labelWidth: 160,
        selectOnFocus: true,
        msgTarget: 'side'
    },
    bodyPadding: 10,
    listeners: {
        render: {fn: 'onRender'}
    },
    items: [
        /*{
         xtype: 'textfield',
         fieldLabel: 'Camino:',
         name: 'path_to_save',
         allowBlank: false
         },*/ {
            xtype: 'numberfield',
            fieldLabel: 'Tamaño Permitido:',
            minValue: 1, //valor mínimo
            maxValue: 100000000000, //valor máximo
            name: 'size_permitido',
            allowBlank: false
        }, {
            xtype: 'numberfield',
            fieldLabel: 'Cant. URLs x d&iacute;a-Usuario:',
            //labelWidth: 200,
            minValue: 1, //valor mínimo
            maxValue: 10000, //valor máximo
            name: 'cant_desc_x_user',
            allowBlank: false
        },
        {
            xtype: 'fieldset',
            title: 'Proxy',
            id: 'idFieldSetOG',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
            items: [{
                    xtype: 'checkbox',
                    name: 'proxy_use',
                    id: 'idchbProxyUse',
                    boxLabel: 'Desea utilizar proxy?',
                    hideLabel: true,
                    //checked: true,
                    style: 'margin-bottom:5px',
                    handler: function (me,checked) {
                        var Proxy = Ext.ComponentQuery.query('#idProxy');
                        var ProxyPort = Ext.ComponentQuery.query('#idProxyPort');
                        var ProxyUser = Ext.ComponentQuery.query('#idProxyUser');
                        var ProxyPass = Ext.ComponentQuery.query('#idProxyPass');

                        if (checked === true) {
                            Proxy[0].setDisabled(false);
                            ProxyPort[0].setDisabled(false);
                            ProxyUser[0].setDisabled(false);
                            ProxyPass[0].setDisabled(false);
                        } else {
                            Proxy[0].setDisabled(true);
                            ProxyPort[0].setDisabled(true);
                            ProxyUser[0].setDisabled(true);
                            ProxyPass[0].setDisabled(true);
                        }
                    }

                }, {
                    xtype: 'textfield',
                    id: 'idProxy',
                    fieldLabel: 'Proxy:',
                    name: 'proxy',
                    allowBlank: false
                }, {
                    xtype: 'textfield',
                    id: 'idProxyPort',
                    fieldLabel: 'Proxy Port:',
                    name: 'proxy_port',
                    allowBlank: false
                }, {
                    xtype: 'textfield',
                    fieldLabel: 'Proxy Usuario:',
                    id: 'idProxyUser',
                    name: 'proxy_user'//,
                            //allowBlank: false
                }, {
                    xtype: 'textfield',
                    fieldLabel: 'Proxy Password:',
                    id: 'idProxyPass',
                    name: 'proxy_pass',
                    inputType: 'password'//,
                            //allowBlank: false
                }
            ]
        }

    ],
    buttons: [
        {
            text: 'Actualizar',
            formBind: true, //only enabled once the form is valid
            disabled: true,
            scale: 'medium',
            icon: BASE_PATH + 'web/images/actualizar.png',
            listeners: {
                click: {fn: 'onActualizar'}
            }
        }]

});