
// (function(window, document, $, undefined) {
   import Tasks from './classes/tasks.js';
   // Define the routes to deffer execution of javascript
   // "all" matches all the pages
   // "bodyId" defines the ID of the body
   var Routes = {
       'all': [ 'all' ],
       'tasks': [ 'tasks' ]
   }
   
   var Mods = {
       all: function() {
         console.log('Hello world');
       },
   
       tasks: function() {
         new Tasks();
       }
   }
   
   function frontbundle() {
       this.bodyId = $('[data-pageid]').data('pageid');
       this.element = $('[data-pageid]');
   }
   
   frontbundle.prototype = {
       init: function() {
           this.run('all');
           this.run(this.bodyId);
       },
       run: function(id) {
           var route = Routes[id];
   
           if (undefined === route) {
               return;
           }
   
           for (var i = 0; i < route.length; i++) {
               Mods[route[i]]();
           }
       }
   }
   
   $(document).ready(function() {
       var app = new frontbundle;
       app.init();
   })
   
   // })(window, document, jQuery)