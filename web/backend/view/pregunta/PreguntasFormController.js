/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.view.pregunta.PreguntasFormController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.preguntasFormController',
    onSubmit: function (b) {
        var formWidget = this.getView();
        var form = formWidget.getForm();

        if (form.isValid()) {
            formWidget.getEl().mask("Insertando pregunta...");
            form.submit({
                success: function (form, action) {
                    Ext.Msg.show({
                        title: 'Informaci&oacute;n',
                        msg: 'Pregunta insertada correctamente', //mensaje de la inserción
                        buttons: Ext.Msg.OK,
                        icon: Ext.MessageBox.INFO,
                        fn: function (btn, text) {//resetear el formulario despues de la inserción
                            form.reset();
                        }
                    });
                    formWidget.up('window').close();
                    var g = Ext.ComponentQuery.query('gridPreguntas');
                    g[0].getStore().reload();

                },
                failure: function (form, action) {
                    obj = Ext.decode(action.response.responseText);
                    Ext.Msg.show({
                        title: 'Error',
                        msg: obj.errors.reason,
                        buttons: Ext.Msg.OK,
                        icon: Ext.Msg.ERROR
                    });

                }
            });
            formWidget.getEl().unmask();
        }
    }
});
