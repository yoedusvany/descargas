/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.view.reportes.gridReportesController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.gridReportesController',

    onReset: function () {
        this.getView().down('combo').reset();
        this.getView().down('datefield').reset();
        this.getView().getStore().clearFilter();
    },
    onAfterRender: function () {
        if (rol === "admin") {


        }

    },
    onSelect: function (c, r) {
        var g = this.getView();

        if (r.data.estado === "Finalizada") {
            g.getStore().filter('finalized', 'SI');
        } else {
            g.getStore().filter('finalized', 'NO');
        }
        g.down('button').setDisabled(false);
    },
    onSelecFilterFecha: function (f, v) {
        this.getView().getStore().filter('date', v);
        this.getView().down('button').setDisabled(false);
        //this.getView().down('button[text="Resetear"]').setDisabled(false);
    },

    onExportar: function (t) {
        var g = this.getView();
        var c = g.down('combo').getValue();
        var df = g.down('combo').getValue();

        if (rol === "admin") {
//CASO PARA EL ADMIN            
            if (g.down('combo').getValue() != null) {
                console.log("combo nfinalizadas");
                this.nFinalizadas(g.down('combo'));
            } else {
                if (g.down('datefield').getValue() != null) {
                    this.filterFecha(g.down('datefield'));
                } else {
                    this.todas("");
                }
            }
        } else {
//CASO PARA LOS USUARIOS            
            if (g.down('combo').getValue() != null) {
                this.nFinalizadas(g.down('combo'), usuario);
            } else {
                if (g.down('datefield').getValue() != null) {
                    this.filterFecha(g.down('datefield'));
                } else {
                    this.todas(usuario);
                }
            }
        }

    },
    todas: function (user) {
        window.open(BASE_PATH + "reportedescargas/reportegetDescargas/" + user);
    },
    nFinalizadas: function (c, user) {
        var r = c.getValue();

        if (r === "No finalizada") {
            if (user === undefined) {
                window.open(BASE_PATH + "reportedescargas/reportegetDescargasNOFinalizadas/");
            } else {
                window.open(BASE_PATH + "reportedescargas/reportegetDescargasNOFinalizadas/" + user);
            }

        } else {
            console.log("finalizadas")
            if (user === undefined) {
                window.open(BASE_PATH + "reportedescargas/reportegetDescargasFinalizadas/");
            } else {
                window.open(BASE_PATH + "reportedescargas/reportegetDescargasFinalizadas/" + user);
            }
        }

    },
    filterFecha: function (df) {
        window.open(BASE_PATH + "reportedescargas/reporteDescargasDadaUnaFecha/" + df.getRawValue());
    }

});
