/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.view.mail.EmailController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.emailController',
    onEstablecer: function (b) {
        var tfEmail = b.up("window").down('textfield');
        if (tfEmail.isValid()) {
            Ext.Ajax.request({
                url: BASE_PATH + "descargas/setEmail",
                params: {
                    email: tfEmail.getRawValue()
                },
                success: function (response) {
                    Ext.Msg.show(
                            {
                                title: 'Informaci&oacute;n',
                                msg: 'Correo establecido correctamente', //mensaje de la inserción
                                buttons: Ext.Msg.OK,
                                icon: Ext.MessageBox.INFO
                            });
                    b.up('window').close();
                }
            });
        } else {
            b.up('window').hide();
            Ext.Msg.show(
                    {
                        title: 'Error',
                        modal: true,
                        msg: 'Debe establecer un valor para el campo correo', //mensaje de la inserción
                        buttons: Ext.Msg.OK,
                        icon: Ext.MessageBox.ERROR,
                        fn: function (btn, text) {//resetear el formulario despues de la inserción
                            wSetEmail.show();
                        }
                    });
        }
    }
});
