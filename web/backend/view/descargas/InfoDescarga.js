/**
 * Created by root on 19/12/15.
 */
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('DescargasBackend.view.descargas.InfoDescarga', {
    extend: 'Ext.window.Window',
    alias: 'widget.infoDescarga',
    //configuracion
    title: 'Informaci&oacute;n de descarga',
    height: 300,
    width: 300,
    layout: 'fit',
    iconCls: 'icon-infodescarga',
    modal: true, //solo pueda trabajarse en ella hasta tanto no se cierre
    autoShow: true, //se auto muestra
    autoScroll: true,
    closable: true,
    closeAction: 'destroy', //destruye la ventana al cerrarla

    animateTarget: 'idbInfoDes', //efecto q permite q la ventana salga desde un elemento determinado

    //startingMarkup: 'Por favor seleccione a book to see additional details.',
    bookTplMarkup: [
        '<b>Nombre del fichero:</b> {name}<br/>',
        '<b>Extensión:</b> {ext}<br/>',
        '<b>URL:</b> <a href="{url}">{url}</a><br/>',
        '<b>Finalizada?:</b> {finalized}<br/>',
        '<b>Descripción:</b> {desc}<br/><br/>',
        '<b>Fecha registro:</b> {date}<br/>',
        '<b>Fecha inicio de descarga:</b> {date_init}<br/>',
        '<b>Fecha finalizada la descarga:</b> {date_finalized}<br/><br/>',
        '<b><u>Estadísticas:</u></b><br/>',
        '<b>Tamaño:</b> {size}<br/>',
        '<b>Velocidad promedio de descarga:</b> {speed_download}<br/>',
        '<b>Tiempo total:</b> {total_time}<br/>'

    ],
    initComponent: function() {
        this.tpl = Ext.create('Ext.Template', this.bookTplMarkup);
        this.html = this.startingMarkup;
        this.bodyStyle = {
            background: '#ffffff'
        };
        this.callParent(arguments);
    },
    updateDetail: function(data) {
        this.body.hide();
        this.tpl.overwrite(this.body, data);
        this.body.slideIn('t', {
            easing: 'easeOut',
            duration: 500
        });
    }
});