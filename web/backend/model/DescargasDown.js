/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('DescargasBackend.model.DescargasDown', {
    extend: 'Ext.data.Model',

    fields: [
        {name: 'name', type: 'string'},
        {name: 'ext', type: 'string'},
        {name: 'url', type: 'string'},
        {name: 'date', type: 'date', dateFormat: 'Y-m-d'},
        {name: 'date_init', type: 'date', dateFormat: 'Y-m-d'},
        {name: 'username', type: 'string'},
        {name: 'size', type: 'string'},
        {name: 'progreso', type: 'string'}
    ]
    
});