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

!function( $ ){

  "use strict"

 /* Collection PUBLIC CLASS DEFINITION
  * ============================== */

  var Collection = function ( element, options ) {
    this.$element = $(element)
    this.options = $.extend({}, $.fn.collection.defaults, options)

    var embeddedForms = 'div'+this.options.collection_id+'>.collection.controls>.collection-item';
    this.options.index = $( embeddedForms ).length - 1;
  }

  Collection.prototype = {

      constructor: Collection

    , add: function ( ) {
		var index = ++this.options.index;
		if($.isFunction(this.options.addcheckfunc) && !addcheckfunc()){ 
			if($.isFunction(this.options.addfailedfunc)) this.options.addfailedfunc()
			return false;
		}
		var row = $(this.options.collection_id).attr('data-prototype').replace(/\$\$name\$\$/g, index);
		$(this.options.collection_id + ' div.collection.controls').append(row);
		event.preventDefault();
      }
    , remove: function ( ) {
		//this is called for a specific input inside the row...
		
		if(this.$element.parents('.collection-item').length){
			this.$element.parents('.collection-item').remove();
		}
	}

  }


 /* COLLECTION PLUGIN DEFINITION
  * ======================== */

  $.fn.collection = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , collection_id = '#'+$this.data('collection-add-btn')
        , collection = $(collection_id)
        , data = $this.data('collection')
        , options = typeof option == 'object' ? option : {}

      options.collection_id = collection_id;

      if (!data) $this.data('collection', (data = new Collection(this, options)))
      data.options.collection_id = collection_id;
      if (option == 'add') data.add()
      if (option == 'remove') data.remove()
    })
  }

  $.fn.collection.defaults = {
	collection_id: null,
    addcheckfunc: false,
    addfailedfunc: false
  }
  
  $.fn.collection.Constructor = Collection


 /* COLLECTION DATA-API
  * =============== */

  $(function () {
    $('body').on('click.collection.data-api', '[data-collection-add-btn]', function ( e ) {
      var $btn = $(e.target)
      if (!$btn.hasClass('btn')) $btn = $btn.closest('.btn')
      $btn.collection('add')
    })
    $('body').on('click.collection.data-api', '[data-collection-remove-btn]', function ( e ) {
      var $btn = $(e.target)
      if (!$btn.hasClass('btn')) $btn = $btn.closest('.btn')
      $btn.collection('remove')
    })
  })

}( window.jQuery );
