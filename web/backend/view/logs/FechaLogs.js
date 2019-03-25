/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


Ext.define("DescargasBackend.view.logs.FechaLogs", {
    extend: 'Ext.form.field.Date',
    alias: "widget.dfLogs",
    anchor: '100%',
    fieldLabel: 'Seleccione fecha',
    labelWidth : 120,
    name: 'date',
    maxValue: new Date(),
    format : 'Y-m-d'
});
