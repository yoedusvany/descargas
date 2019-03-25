/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.model.Preguntas', {
    extend: 'Ext.data.Model',

    fields: [
        {name: 'id_pregunta', type: 'int'},
        {name: 'username', type: 'string'},
        {name: 'pregunta', type: 'string'},
        {name: 'fecha', type: 'date', dateFormat: 'Y-m-d'},
        {name: 'resuelta', type: 'string'},
        {name: 'respuesta', type: 'string'},
        {name: 'respuesta_fecha', type: 'date', dateFormat: 'Y-m-d'}
    ]
});