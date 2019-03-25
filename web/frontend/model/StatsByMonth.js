/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('Descargas.model.StatsByMonth', {
    extend: 'Ext.data.Model',

    fields: [
        {name: 'month', type: 'string'},
        {name: 'total', type: 'int'}
    ]
    
});