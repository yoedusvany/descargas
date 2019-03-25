/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.view.stats.Stats', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.panelStats',
    requires : [
        'Comun.graficas.PieDescargasNacInt',
        'Comun.graficas.statsByMonth',
        'Comun.graficas.PieTop5Extensiones',
        'Comun.graficas.statsByDomains'
    ],
    layout: 'column',
    autoScroll : true,
    defaults: {
        bodyPadding: 0,
        height: 300,
        scrollable: true
    },
    initComponent: function () {

        this.bodyStyle = "background: transparent";

        this.items = [
            {
                columnWidth: 0.5,
                margin: "10 5 0 0",
                title: 'Descargas Nacionales-Internacionales',
                frame: true,
                icon: null,
                items: [
                    {
                        xtype:'pieDescargasNacInt'
                    }
                ]
                
            }, 
            {
                columnWidth: 0.5,
                margin: "10 0 0 5",
                frame: true,
                title: 'Cantidad de bytes descargados por MES',
                icon: null,
                items : [{
                       xtype: 'statsByMonth'
                }]
            },
            {
                columnWidth: 0.5,
                margin: "10 5 0 0",
                frame: true,
                title: 'Top-5 descargas por extensi&oacute;n',
                icon: null,
                items : [{
                       xtype: 'pieTop5Extensiones'
                }]
            },
            {
                columnWidth: 0.5,
                margin: "10 0 0 5",
                frame: true,
                title: 'Top-10 dominios con m&aacute;s descargas',
                icon: null,
                items : [{
                       xtype: 'statsByDomains'
                }]
            }
        ];

        this.callParent();
    }
});