/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('Descargas.view.login.Login', {
    extend: 'Ext.form.Panel',
    alias: 'widget.fLogin',
    requires: ['Descargas.view.login.loginController'],
    controller: 'loginController',
    bodyPadding: 5,
    width: 350,
    url: BASE_PATH + 'login/autenticar',
    layout: 'anchor',
    defaults: {
        anchor: '100%'
    },
    defaultType: 'textfield',
    listeners: {
        afterrender: {fn: 'myafterrender'},
    },
    items: [
        {
            xtype: 'combo',
            fieldLabel: 'Seleccione sede',
            store: "Sedes",
            queryMode: 'local',
            name: 'sede',
            displayField: 'sede',
            autoSelect: true,
            forceSelection: true,
            selectOnFocus: true,
            valueField: 'sede'
        },
        {
            fieldLabel: 'Usuario',
            name: 'usuario',
            allowBlank: false,
			id: 'idtfUser'
        }, {
            id: 'idtfPass',
            minLength: 7,
            fieldLabel: 'Contrase&ntilde;a',
            name: 'pass',
            allowBlank: false,
            enableKeyEvents: true,
            inputType: 'password',
            listeners: {
                keypress: {fn: 'onKeyPress'}
            }
        }],
    buttons: [{
            text: 'Resetear',
            icon: BASE_PATH + 'web/images/reset.png',
            handler: function () {
                this.up('form').getForm().reset();
            }
        }, {
            text: 'Iniciar',
            icon: BASE_PATH + 'web/images/inicio.png',
            formBind: true, //only enabled once the form is valid
            disabled: true,
            listeners: {
                click: {fn: 'onClick'}
            }
        }]
});
