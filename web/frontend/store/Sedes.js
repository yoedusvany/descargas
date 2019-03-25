/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Ext.define('Sede', {
     extend: 'Ext.data.Model',
     fields: [
         {name: 'sede', type: 'string'}
     ]
 });


Ext.define('Descargas.store.Sedes',{
    extend: 'Ext.data.Store',
    model : "Sede",
    
    data : [
        {"sede":"Sede Central"},
        {"sede":"Sede Manuel Ascunce"},    
        {"sede":"Bioplantas"}      
    ]
});