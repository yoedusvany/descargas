/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.view.optionesgeneral.OGFormController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.ogFormController',
    onActualizar: function (b) {
        var formWidget = this.getView('optionesGeneralForm');
        var form = formWidget.getForm();

        if (form.isValid()) {
            formWidget.getEl().mask("Actualizando...");
            form.submit({
                success: function (form, action) {
                    Ext.Msg.show(
                            {
                                title: 'Informaci&oacute;n',
                                msg: 'Opciones actualizadas correctamente',
                                buttons: Ext.Msg.OK,
                                icon: Ext.MessageBox.INFO
                            });
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
    },
    onRender: function (t) {
        Ext.Ajax.request({
            url: BASE_PATH + 'descargas/getOpciones/',
            success: function (response, opts) {
                var obj = Ext.decode(response.responseText);

                var og = Ext.create("DescargasBackend.model.OptionesGeneral");
                og.set('size_permitido', obj.data[0].size_permitido);
                og.set('cant_desc_x_user', obj.data[0].cant_desc_x_user);
                og.set('proxy', obj.data[0].proxy);
                og.set('proxy_port', obj.data[0].proxy_port);
                og.set('proxy_user', obj.data[0].proxy_user);
                og.set('proxy_pass', obj.data[0].proxy_pass);
                og.set('proxy_use', obj.data[0].proxy_use);
                t.loadRecord(og);

                if (obj.data[0].proxy_use == false) {
                    t.down('textfield[fieldLabel="Proxy:"]').setDisabled(true);
                    t.down('textfield[fieldLabel="Proxy Port:"]').setDisabled(true);
                    t.down('textfield[fieldLabel="Proxy Usuario:"]').setDisabled(true);
                    t.down('textfield[fieldLabel="Proxy Password:"]').setDisabled(true);
                } else {
                    t.down('textfield[fieldLabel="Proxy:"]').setDisabled(false)
                    t.down('textfield[fieldLabel="Proxy Port:"]').setDisabled(false);
                    t.down('textfield[fieldLabel="Proxy Usuario:"]').setDisabled(false);
                    t.down('textfield[fieldLabel="Proxy Password:"]').setDisabled(false);
                }
            },
            failure: function (response, opts) {
                Ext.Msg.show({
                    title: 'Error',
                    msg: 'No se pudo cargar las opciones generales del sistema',
                    buttons: Ext.Msg.OK,
                    icon: Ext.Msg.ERROR
                });
            }
        });
    }
});
