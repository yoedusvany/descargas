/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.view.usuarios.gridUsuariosController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.gridUsuariosController',
    init: function(view) {
        this.getView().getStore().sort('username', 'ASC');
    },

    onGridEditorEdit: function (editor, ctx, eOpts) {
        var rec = ctx.record;
        ctx.record.commit();

            Ext.Ajax.request({
                url: BASE_PATH + 'usuarios/update',
                params: {
                    username: rec.data.username,
                    rol: rec.data.rol
                },
                success: function (response, opts) {
                    Ext.Msg.show({
                        title: 'Informaci&oacute;n',
                        msg: 'Se ha actualizado correctamente el rol del usuario',
                        buttons: Ext.Msg.OK,
                        icon: Ext.Msg.INFO
                    });
                },
                failure: function (response, opts) {
                    Ext.Msg.show({
                        title: 'Error',
                        msg: "No se ha podido actualizar el rol del usuario.",
                        buttons: Ext.Msg.OK,
                        icon: Ext.Msg.ERROR
                    });
                }
            });

    }

});
