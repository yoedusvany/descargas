/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.view.pregunta.GridPreguntasController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.gPreguntasController',
    onRowDbClick: function (t, record, tr, rowIndex, e) {
        if (record.data.resuelta === 'NO') {
            Ext.Msg.show({
                title: 'Error',
                msg: 'Esta pregunta no posee respuesta todav&iacute;a',
                buttons: Ext.Msg.OK,
                icon: Ext.Msg.ERROR
            });
        } else {
            Ext.Ajax.request({
                url: BASE_PATH + 'respuesta/getRespuesta',
                params: {
                    id_pregunta: record.data.id_pregunta
                },
                success: function (response, opts) {
                    var obj = Ext.decode(response.responseText);

                    record.set('respuesta', obj.data[0].respuesta);
                    record.set('respuesta_fecha', obj.data[0].fecha);
                },
                failure: function (response, opts) {
                    console.log('server-side failure with status code ' + response.status);
                }
            });
        }
    },
    onAfterRender: function (me) {
        me.getView().on('expandbody', this.onRowExpand);
    },
    onRowExpand: function (rowNode, record, expandRow) {
        if (record.data.resuelta === 'NO') {
            Ext.Msg.show({
                title: 'Error',
                msg: 'Esta pregunta no posee respuesta todav&iacute;a',
                buttons: Ext.Msg.OK,
                icon: Ext.Msg.ERROR
            });
        } else {
            Ext.Ajax.request({
                url: BASE_PATH + 'respuesta/getRespuesta',
                params: {
                    id_pregunta: record.data.id_pregunta
                },
                success: function (response, opts) {
                    var obj = Ext.decode(response.responseText);

                    record.set('respuesta', obj.data[0].respuesta);
                    record.set('respuesta_fecha', obj.data[0].fecha);
                },
                failure: function (response, opts) {
                    console.log('server-side failure with status code ' + response.status);
                }
            });
        }
    },
    onNewPregunta: function () {
        Ext.create('Ext.window.Window', {
            title: 'Nueva Pregunta',
            icon: BASE_PATH + 'web/images/pregunta.png',
            height: 200,
            width: 400,
            modal: true,
            layout: 'anchor',
            items: [{
                    xtype: 'preguntasForm'
                }]
        }).show();
    },
    onKeyUp: function (t, e) {
        if (e.keyCode == 27) {
            t.reset();
            this.getView().getStore().clearFilter();
        } else {
            this.getView().getStore().filter('pregunta', t.getValue());
        }
    },
    onCheck: function (t, newVal, oldVal) {
        if(newVal == true){
            this.getView().getStore().filter('resuelta', 'SI');
        }else{
            this.getView().getStore().clearFilter();
        }
        
    }

});
