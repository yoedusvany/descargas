/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('DescargasBackend.view.mail.SetEmail', {
    extend: 'Ext.window.Window',
    alias: 'widget.winSetEmail',
    requires :[
        'DescargasBackend.view.mail.EmailController'
    ],
    controller : 'emailController',
    closable: false,
    resizable: false,
    modal: true, //solo pueda trabajarse en ella hasta tanto no se cierre
    autoShow: true, //se auto muestra
    closeAction: 'destroy', //destruye la ventana al cerrarla
    //animateTarget: 'idViewport',
    height: 300,
    width: 325,
    title: 'Establecer Correo...',
    bodyStyle: {
        background: '#FFFFF',
        padding: '3px'
    },
    items: [{
            xtype: 'fieldset',
            title: 'Informaci&oacute;n',
            items: [{
                    xtype: 'label',
                    margin: '0 0 0 0',
                    text: 'Usted debe suministrar su correo para poder informarle sobre el estado de sus descargas, esta operación es necesaria debido a que en el servidor LDAP del centro usted no tiene el campo email establecido en su usuario.'
                }]
        }, {
            xtype: 'textfield',
            id: 'idtfEmail',
            name: 'email',
            vtype: 'email',
            labelWidth: 120,
            fieldLabel: 'Correo electr&oacute;nico',
            allowBlank: false
        }],
    buttons: [
        {
            text: 'Establecer',
            formBind: true,
            listeners: {
                click : {fn:'onEstablecer'}
            }
            //id: 'idbActualizarEmail'
        }]
});