/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define('Descargas.view.TabInicio', {
    extend: 'Ext.tab.Panel',
    alias: 'widget.tabInicio',
    bodyPadding: 5,
    requires: [
        "Ext.panel.Panel",
        "Comun.graficas.PieDescargasNacInt",
        "Comun.graficas.statsByMonth",
        "Comun.graficas.PieTop5Extensiones",
        "Comun.graficas.statsByDomains",
        "Comun.graficas.statsWeek"
    ],
    items: [{
            title: 'GR&Aacute;FICAS',
            //iconCls: 'icon-grafica'
            icon: BASE_PATH + 'web/images/grafica-icon.png',
            layout: 'column',
            autoScroll : true,
            /*layout: {
                type: 'hbox',
                pack: 'start',
                align: 'stretch'
            },*/
            bodyPadding: 10,
            items: [
                {
                    xtype: 'panel',
                    //flex: 1,
                    columnWidth: 0.5,
                    margin: "10 5 0 0",
                    frame: true,
                    autoScroll: true,
                    collapsible: true,
                    title: 'Porciento de descargas Nacionales - Internacionales',
                    tbar: [
                        '->',
                        {
                            text: 'Cambiar tema',
                            handler: function () {
                                var chart = this.up('panel').down('pieDescargasNacInt');
                                currentThemeClass = Ext.getClassName(chart.getTheme());
                                themes = Ext.chart.theme,
                                        themeNames = [],
                                        currentIndex = 0,
                                        name;

                                for (name in themes) {
                                    if (Ext.getClassName(themes[name]) === currentThemeClass) {
                                        currentIndex = themeNames.length;
                                    }
                                    if (name !== 'Base' && name.indexOf('Gradients') < 0) {
                                        themeNames.push(name);
                                    }
                                }
                                chart.setTheme(themes[themeNames[++currentIndex % themeNames.length]]);
                                chart.redraw();
                            }
                        }
                    ],
                    items: [
                        {
                            xtype: 'pieDescargasNacInt',
                            height: 300
                        }
                    ]

                },
                {
                    xtype: 'panel',
                    flex: 1,
                    columnWidth: 0.5,
                    margin: "10 0 0 5",
                    frame: true,
                    autoScroll: true,
                    collapsible: true,

                    title: 'Cantidad de bytes descargados por MES',
                    tbar: [
                        '->',
                        {
                            text: 'Cambiar tema',
                            handler: function () {
                                var chart = this.up('panel').down('statsByMonth');
                                currentThemeClass = Ext.getClassName(chart.getTheme());
                                themes = Ext.chart.theme,
                                        themeNames = [],
                                        currentIndex = 0,
                                        name;

                                for (name in themes) {
                                    if (Ext.getClassName(themes[name]) === currentThemeClass) {
                                        currentIndex = themeNames.length;
                                    }
                                    if (name !== 'Base' && name.indexOf('Gradients') < 0) {
                                        themeNames.push(name);
                                    }
                                }
                                chart.setTheme(themes[themeNames[++currentIndex % themeNames.length]]);
                                chart.redraw();
                            }
                        }
                    ],
                    items: [
                        {
                            xtype: 'statsByMonth',
                            height: 300
                        }
                    ]

                },
                {
                    xtype: 'panel',
                    flex: 1,
                    columnWidth: 0.5,
                    margin: "10 5 0 0",
                    frame: true,
                    autoScroll: true,
                    collapsible: true,
                    title: 'Top-5 descargas por extensi&oacute;n',
                    tbar: [
                        '->',
                        {
                            text: 'Cambiar tema',
                            handler: function () {
                                var chart = this.up('panel').down('pieTop5Extensiones');
                                currentThemeClass = Ext.getClassName(chart.getTheme());
                                themes = Ext.chart.theme,
                                    themeNames = [],
                                    currentIndex = 0,
                                    name;

                                for (name in themes) {
                                    if (Ext.getClassName(themes[name]) === currentThemeClass) {
                                        currentIndex = themeNames.length;
                                    }
                                    if (name !== 'Base' && name.indexOf('Gradients') < 0) {
                                        themeNames.push(name);
                                    }
                                }
                                chart.setTheme(themes[themeNames[++currentIndex % themeNames.length]]);
                                chart.redraw();
                            }
                        }
                    ],
                    items: [
                        {
                            xtype: 'pieTop5Extensiones',
                            height: 300
                        }
                    ]

                },
                {
                    xtype: 'panel',
                    flex: 1,
                    columnWidth: 0.5,
                    margin: "10 0 0 5",
                    frame: true,
                    autoScroll: true,
                    collapsible: true,
                    title: 'Top-10 dominios con m&aacute;s descargas',
                    tbar: [
                        '->',
                        {
                            text: 'Cambiar tema',
                            handler: function () {
                                var chart = this.up('panel').down('statsByDomains');
                                currentThemeClass = Ext.getClassName(chart.getTheme());
                                themes = Ext.chart.theme,
                                    themeNames = [],
                                    currentIndex = 0,
                                    name;

                                for (name in themes) {
                                    if (Ext.getClassName(themes[name]) === currentThemeClass) {
                                        currentIndex = themeNames.length;
                                    }
                                    if (name !== 'Base' && name.indexOf('Gradients') < 0) {
                                        themeNames.push(name);
                                    }
                                }
                                chart.setTheme(themes[themeNames[++currentIndex % themeNames.length]]);
                                chart.redraw();
                            }
                        }
                    ],
                    items: [
                        {
                            xtype: 'statsByDomains',
                            height: 300
                        }
                    ]

                },
                {
                    xtype: 'panel',
                    flex: 1,
                    columnWidth: 0.5,
                    margin: "10 0 0 5",
                    frame: true,
                    autoScroll: true,
                    collapsible: true,
                    title: 'Cant. de descargas por d&iacute;a de la semana',
                    tbar: [
                        '->',
                        {
                            text: 'Cambiar tema',
                            handler: function () {
                                var chart = this.up('panel').down('statsWeek');
                                currentThemeClass = Ext.getClassName(chart.getTheme());
                                themes = Ext.chart.theme,
                                    themeNames = [],
                                    currentIndex = 0,
                                    name;

                                for (name in themes) {
                                    if (Ext.getClassName(themes[name]) === currentThemeClass) {
                                        currentIndex = themeNames.length;
                                    }
                                    if (name !== 'Base' && name.indexOf('Gradients') < 0) {
                                        themeNames.push(name);
                                    }
                                }
                                chart.setTheme(themes[themeNames[++currentIndex % themeNames.length]]);
                                chart.redraw();
                            }
                        }
                    ],
                    items: [
                        {
                            xtype: 'statsWeek',
                            height: 300
                        }
                    ]

                }
            ]

        }, {
            title: 'B&Uacute;SQUEDA',
            icon: BASE_PATH + 'web/images/search2.png',
            layout: 'fit',
            items: [
                {
                    xtype: 'gridSearch'
                }
            ]
        }],
    renderTo: Ext.getBody()
});