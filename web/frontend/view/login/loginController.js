/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('Descargas.view.login.loginController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.loginController',
    init: function (view) {
    },
    myafterrender: function (t) {
        var c = t.down('combo');
        c.setValue(SEDE);
    },
	onRender: function (t) {
		t.focus(false, 50); 
    },
    onClick: function (t) {
        var form = t.up('form');

        if (form.getForm().isValid()) {
            form.getEl().mask("Insertando descarga...");
            form.getForm().submit({
                success: function (form, action) {
                    var redirect = BASE_PATH + 'welcome';
                    window.location = redirect;
                },
                failure: function (form, action) {
                    Ext.MessageBox.show({
                        title: 'Error',
                        //msg: 'Usuario o contrase&ntilde;a no v&aacute;lido.',
                        msg: 'Sistema en mantenimiento!!!!. En estos momentos no se puede utilizar este servicio, rogamos nos disculpen por las molestias causadas',
                        buttons: Ext.MessageBox.OK,
                        icon: Ext.MessageBox.WARNING
                    });
                    //form.setDisabled(false);
                }
            });
            form.getEl().unmask();
        }
    },
    onKeyPress: function (t,e) {
        if (e.getKey() === e.ENTER) {
            var form = t.up('form');

            if (form.getForm().isValid()) {
                form.getEl().mask("Insertando descarga...");
                form.getForm().submit({
                    
                    success: function (form, action) {
                        var redirect = BASE_PATH + 'welcome';
                        window.location = redirect;
                    },
                    failure: function (form, action) {
                        Ext.MessageBox.show({
                            title: 'Error',
                            //msg: 'Usuario o contrase&ntilde;a no v&aacute;lido.',
                            msg: 'Sistema en mantenimiento!!!!. En estos momentos no se puede utilizar este servicio, rogamos nos disculpen por las molestias causadas',
                            buttons: Ext.MessageBox.OK,
                            icon: Ext.MessageBox.WARNING
                        });
                        //form.setDisabled(false);
                    }
                });
                form.getEl().unmask();
            }
        }

    }
});
