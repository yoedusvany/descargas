/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.view.descargas.DescargaFormController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.descargasFormController',
    onSubmit: function (b) {
        var formWidget = this.getView('descargaForm');
        var form = formWidget.getForm();

        if (form.isValid()) {
            formWidget.getEl().mask("Insertando descarga...");
            form.submit({
                success: function (form, action) {
                    Ext.Msg.show(
                            {
                                title: 'Informaci&oacute;n',
                                msg: 'Descarga insertada correctamente', //mensaje de la inserción
                                buttons: Ext.Msg.OK,
                                icon: Ext.MessageBox.INFO,
                                fn: function (btn, text) {//resetear el formulario despues de la inserción
                                    form.reset();
                                }
                            });
                            
                    var g = Ext.ComponentQuery.query("gridDescargas");
                    g[0].getStore().reload();
                    var w = b.up('window');
                    w.hide();
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
