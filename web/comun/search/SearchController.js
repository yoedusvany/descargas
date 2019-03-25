/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('Comun.search.SearchController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.searchController',
    rowclick: function (t, r, tr, rowIndex) {
        var b = this.getView().down('button[text=Abrir fichero]');

        if (r.data.finalized === "SI") {
            b.setDisabled(false);
        } else {
            b.setDisabled(true);
        }
    },
    rowdblclick: function (t, r, tr, rowIndex) {
        var nameFile = r.data.name;
        var extFile = r.data.ext;
        dirFile = BASE_PATH + "FILES/" + extFile + "/" + nameFile + "." + extFile;
        window.open(dirFile);
    },
    onOpenFile: function (s) {
        var r = this.getView().getSelectionModel().getSelection();
        var nameFile = r[0].data.name;
        var extFile = r[0].data.ext;
        dirFile = BASE_PATH + "FILES/" + extFile + "/" + nameFile + "." + extFile;
        window.open(dirFile);
    },
    onReset: function () {
        var g = this.getView();

        var tf = g.down('textfield[fieldLabel="Nombre de fichero"]');
        var tf1 = g.down('textfield[fieldLabel="Descripci&oacute;n"]');
        var combo = g.down('comboExtensiones');

        tf.reset();
        tf1.reset();
        combo.reset();

        g.getStore().clearFilter();
        g.down('button[text="Resetear"]').setDisabled(true);

    },
    onSelect: function (c) {
        var g = this.getView();
        g.getStore().clearFilter();
        g.down('button[text="Resetear"]').setDisabled(false);

        var filters = [];
        var i = 0;

        var t = g.down('textfield[fieldLabel="Nombre de fichero"]');
        var t1 = g.down('textfield[fieldLabel="Descripci&oacute;n"]');

        if (t.getValue() != null) {
            filters[i] = {
                property: 'name',
                value: t.getValue()
            };
            i++;
        }

        if (t1.getValue() != null) {
            filters[i] = {
                property: 'desc',
                value: t1.getValue()
            };
            i++;
        }

        if (c.getValue() != null) {
            filters[i] = {
                property: 'ext',
                value: c.getValue()
            };
            i++;
        }
        g.getStore().filter(filters);
    },
    onKeyPress: function (t, e) {
        var g = this.getView();
        g.getStore().clearFilter();
        g.down('button[text="Resetear"]').setDisabled(false);

        if (e.getKey() === e.ENTER) {
            var filters = [];
            var i = 0;

            if (t.getValue() != null) {
                filters[i] = {
                    anyMatch: true,
                    exactMatch: false,
                    property: 'name',
                    value: t.getValue()
                };
                i++;
            }

            var t1 = g.down('textfield[fieldLabel="Descripci&oacute;n"]');
            if (t1.getValue() != null) {
                filters[i] = {
                    anyMatch: true,
                    exactMatch: false,
                    property: 'desc',
                    value: t1.getValue()
                };
                i++;
            }

            var c = g.down('comboExtensiones');
            if (c.getValue() != null) {
                filters[i] = {
                    property: 'ext',
                    value: c.getValue()
                };
                i++;
            }
            g.getStore().filter(filters);
        }
    },
    onKeyPressDesc: function (t, e) {
        this.getView().down('button[text="Resetear"]').setDisabled(false);

        var store = this.getView().getStore();
        store.clearFilter();

        if (e.getKey() === e.ENTER) {
            var filters = [];
            var i = 0;

            if (t.getValue() != null) {
                filters[i] = {
                    anyMatch: true,
                    exactMatch: false,
                    property: 'desc',
                    value: t.getValue()
                };
                i++;
            }

            var t1 = this.getView().down('textfield[fieldLabel="Nombre de fichero"]');

            if (t1.getValue() != null) {
                filters[i] = {
                    anyMatch: true,
                    exactMatch: false,
                    property: 'name',
                    value: t1.getValue()
                };
                i++;
            }

            var c = this.getView().down('comboExtensiones');
            if (c.getValue() != null) {
                filters[i] = {
                    property: 'ext',
                    value: c.getValue()
                };
                i++;
            }
            store.filter(filters);
        }
    }
});
