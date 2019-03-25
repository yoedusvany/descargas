/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.view.descargas.gridDescargasController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.gridDescargasController',
    init: function(view) {
        this.getView().getStore().sort('date', 'DESC');
    },
    rowclick: function (t, r, tr, rowIndex) {
        var b = this.getView().down('button[text=Abrir fichero]');

        if (r.data.finalized === "SI") {
            b.setDisabled(false);
        } else {
            b.setDisabled(true);
        }

        var bInfoDescarga = this.getView().down('button[text=Info]');
        bInfoDescarga.setDisabled(false);
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
    onNewDownload: function (t) {
        Ext.create('Ext.window.Window', {
            title: 'Nueva descarga',
            height: 310,
            width: 650,
            layout: 'fit',
            animateTarget : t,
            icon: BASE_PATH + 'web/images/nueva-descarga.png',
            items: {
                xtype: Ext.create('DescargasBackend.view.descargas.DescargaForm')
            }
        }).show();
    },
    onSelecFilterFecha : function(f,v){
        this.getView().getStore().filter('date',v);
        this.getView().down('button[text="Resetear"]').setDisabled(false);
    },
    onReset : function(t){
        this.getView().getStore().clearFilter();
        this.getView().down('datefield').reset();
        this.getView().down('combo').reset();
        t.setDisabled(true);
    },
    onAfterRender: function(){
        this.getView().getStore().sort('date', 'DESC');
    },
    onSelect : function(t,r){
        var g = this.getView();

        if (r.data.estado === "Finalizada") {
            g.getStore().filter('finalized', 'SI');
        } else {
            g.getStore().filter('finalized', 'NO');
        }
        g.down('button[text="Resetear"]').setDisabled(false);
    },
    onInfo : function(){
        var wInfoDes = Ext.create("DescargasBackend.view.descargas.InfoDescarga");

        Ext.Ajax.request({
            url: BASE_PATH + "descargas/getInfoDescarga",
            params: {
                idDescarga: this.getView().getSelectionModel().getSelection()[0].data.id_file
            },
            success: function(response) {
                var respuesta = Ext.decode(response.responseText);
                wInfoDes.updateDetail(respuesta.data);
                wInfoDes.show();
            }
        });

        wInfoDes.update();
    }
});
