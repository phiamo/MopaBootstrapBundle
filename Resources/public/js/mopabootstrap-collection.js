/* ============================================================
 * bootstrap-collection.js v1.0.0
 * http://bootstrap.mohrenweiserpartner.de/mopa/bootstrap/forms/extended
 * ============================================================
 * Copyright 2012 Mohrenweiser & Partner
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */

!function ($) {

    "use strict";

   /* Collection PUBLIC CLASS DEFINITION
    * ============================== */

    var Collection = function (element, options) {
        this.$element = $(element);
        this.options = $.extend({}, $.fn.collection.defaults, options);

        var embeddedForms = 'div' + this.options.collection_id + ' .collection-item';
        this.options.index = $(embeddedForms).length - 1;
    };

    Collection.prototype = {
        constructor: Collection,
        add: function () {
            this.options.index = this.options.index + 1;
            var index = this.options.index;
            if ($.isFunction(this.options.addcheckfunc) && !this.options.addcheckfunc()) {
                if ($.isFunction(this.options.addfailedfunc)) {
                    this.options.addfailedfunc();
                }
                return;
            }
            this.addPrototype(index);
        },
        addPrototype: function(index) {
            var rowContent = $(this.options.collection_id).attr('data-prototype').replace(/__name__/g, index);            
            var row = $(rowContent);     
            $('div' + this.options.collection_id + '> .controls').append(row);
            $(this.options.collection_id).trigger('add.mopa-collection-item', [row]);
        },
        remove: function () {
                if (this.$element.parents('.collection-item').length !== 0){
                    var row = this.$element.closest('.collection-item');
                    row.remove();
                    $(this.options.collection_id).trigger('remove.mopa-collection-item', [row]);
                }
        }

    };


 /* COLLECTION PLUGIN DEFINITION
  * ======================== */

  $.fn.collection = function ( option ) {
      return this.each(function () {
          var $this = $(this),
            collection_id = $this.data('collection-add-btn'),
            data = $this.data('collection'),
            options = typeof option == 'object' ? option : {};
          if(collection_id){
              options.collection_id = collection_id;
          }
          else if($this.closest(".control-group").attr('id')){
        	  options.collection_id = '#'+$this.closest(".control-group").attr('id');
          }
          else{
        	  options.collection_id = this.id.length === 0 ? '' : '#' + this.id;
          }
          if (!data){
              $this.data('collection', (data = new Collection(this, options)));
          }
          if (option == 'add') {
              data.add();
          }
          if (option == 'remove'){
              data.remove();
          }
      });
  };

  $.fn.collection.defaults = {
    collection_id: null,
    addcheckfunc: false,
    addfailedfunc: false
  };

  $.fn.collection.Constructor = Collection;


 /* COLLECTION DATA-API
  * =============== */

  $(function () {
      $('body').on('click.collection.data-api', '[data-collection-add-btn]', function ( e ) {
        var $btn = $(e.target);
        if (!$btn.hasClass('btn')){
            $btn = $btn.closest('.btn');
        }
        $btn.collection('add');
        e.preventDefault();
      });
      $('body').on('click.collection.data-api', '[data-collection-remove-btn]', function ( e ) {
        var $btn = $(e.target);
        if (!$btn.hasClass('btn')){
            $btn = $btn.closest('.btn');
        }
        $btn.collection('remove');
        e.preventDefault();
      });
  });

} ( window.jQuery );
