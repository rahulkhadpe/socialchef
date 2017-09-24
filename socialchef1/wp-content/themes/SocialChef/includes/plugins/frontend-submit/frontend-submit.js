(function($){

	"use strict";
	
	String.prototype.filename=function(extension){
		var s= this.replace(/\\/g, '/');
		s= s.substring(s.lastIndexOf('/')+ 1);
		return extension? s.replace(/[?#].+$/, ''): s.split('.')[0];
	};
	
	String.prototype.rtrim = function(chr) {
	  var rgxtrim = (!chr) ? new RegExp('\\s+$') : new RegExp(chr+'+$');
	  return this.replace(rgxtrim, '');
	};
	
	String.prototype.ltrim = function(chr) {
	  var rgxtrim = (!chr) ? new RegExp('^\\s+') : new RegExp('^'+chr+'+');
	  return this.replace(rgxtrim, '');
	};	

	$(document).ready(function () {
		submit_recipe.init();
	});

	$(window).load(function(){

	});

	var validator = $('#fes-upload-form-recipe').validate({
		onkeyup: false,
		ignore: [],
		rules: {
			post_title: "required",
			recipe_preparation_time: window.enableRecipeMeta ? "required" : "",
			recipe_cooking_time: window.enableRecipeMeta ? "required" : "",
			recipe_serving: window.enableRecipeMeta ? "required" : "",
			recipe_difficulty: window.enableRecipeMeta ? "required" : "",
			recipe_meal_course: window.enableRecipeMeta ? "required" : "",
			post_content: "required",
			instruction_0: window.enableInstructions ? "required" : "",
			ingredient_0_name: window.enableIngredients ? "required" : "",
			ingredient_0_quantity: window.enableIngredients ? "required" : "",
			ingredient_0_unit: window.enableIngredients ? "required" : "",
			featured_image: "required",
			recipe_status: "required",
			recipe_agree: (window.agreeRequired ? "required" : "")
		},
		invalidHandler: function(e, validator) {
		
			var errors = validator.numberOfInvalids();
			if (errors) {
				$("div.alert-danger").show();
			} else {
				$("div.alert-danger").hide();
			}
			
		},
		errorPlacement: function(error, element) {
			if (element[0].tagName == "SELECT") {
				element.parent().addClass('error');
			}
			else if (element[0].type === 'radio') {
				element.parent().parent().addClass('error');
			}
			else if (element[0].type === 'checkbox') {
				element.parent().parent().addClass('error');
			}			
			return true;
		},
		unhighlight: function(element, errorClass, validClass) {
			if (element.type === 'radio') {
				this.findByName(element.name).removeClass(errorClass).addClass(validClass);
			} else {    
				if (element.tagName == "SELECT") {
					$(element).parent().removeClass(errorClass).addClass(validClass);
				} else {
					$(element).removeClass(errorClass).addClass(validClass);
				}
			}
		},
		messages: {	
			post_title: "1",
			recipe_preparation_time: "2",
			recipe_cooking_time: "3",
			recipe_serving: "4",
			recipe_difficulty: "5",
			recipe_meal_course: "6",
			post_content: "7",
			instruction_0: "8",
			ingredient_0_name: "9",
			ingredient_0_quantity: "10",
			ingredient_0_unit: "11",
			featured_image: "12",
			recipe_status: "13",				
			recipe_agree: "14",
		}			
	});
	
	var submit_recipe = {
		
		init : function () {
		
			Dropzone.autoDiscover = false;		
			
			submit_recipe.initializeDropzone('#featured-image-uploader', 'frontend_upload_image', 'frontend_delete_featured_image', '#featured-image-id', window.featuredImageUri, window.featuredImageId);
		
			$('#submit_recipe').on('click', function(e) {
			
				var content = tinyMCE.activeEditor.getContent({format : 'raw'}); // get the content
				$('#fes_post_content').val(content); // put it in the textarea
			
				if ($('#fes-upload-form-recipe').valid()) {
					$('.recipe_saving').show();
					$('form#fes-upload-form-recipe').submit();
				}

				e.preventDefault();
				return false;				
			});
			
			if (window.enableInstructions) {
		
				$('.add_instruction').on('click', function(e) {
				
					e.preventDefault();
					
					var lastInstruction = $('.instructions .f-row.instruction:last');
					var lastInstructionClass = lastInstruction.attr('class');
					lastInstructionClass = lastInstructionClass.replace('f-row', '');
					lastInstructionClass = lastInstructionClass.replace('instruction', '');
					lastInstructionClass = lastInstructionClass.replace('instruction', '');
					lastInstructionClass = lastInstructionClass.replace('_', '');
					var lastInstructionIndex = parseInt(lastInstructionClass);
					var newInstructionIndex = lastInstructionIndex + 1;
					
					var instructionPlaceHolder = window.instructionText;

					var newInstructionRow = '<div class="f-row instruction instruction_' + newInstructionIndex + '">';
					newInstructionRow += '<div class="full">';
					newInstructionRow += '<input type="text" class="instruction_text" placeholder="' + instructionPlaceHolder + '" name="instruction_' + newInstructionIndex + '" id="instruction_' + newInstructionIndex + '">';
					
					if (window.enableInstructionImages) {
						newInstructionRow +=  '<div class="fes-input-wrapper fes-dropzone fes-instruction-dropzone">';
						newInstructionRow +=  '<label>' + window.instructionImageLabel + '</label>';
					
						newInstructionRow += '<div id="instruction-image-uploader-' + newInstructionIndex + '" class="dropzone"></div>';
						newInstructionRow += '<input type="hidden" class="instruction-image-id" id="instruction-image-id-' + newInstructionIndex + '" name="instruction-image-id-' + newInstructionIndex + '" value="">';
						newInstructionRow += '<input type="hidden" class="instruction-image-uri" id="instruction-image-uri-' + newInstructionIndex + '" name="instruction-image-uri-' + newInstructionIndex + '" value="">';
						newInstructionRow += '<input type="hidden" class="instruction-image-index" id="instruction-image-index-' + newInstructionIndex + '" name="instruction-image-index-' + newInstructionIndex + '" value="' + newInstructionIndex + '">';
						newInstructionRow += '</div>'
						newInstructionRow += '</div>'
					}
					newInstructionRow += '</div>'
					newInstructionRow += '<button class="remove remove_instruction">-</button>';
					newInstructionRow += '</div>'
					$( '.instructions .f-row.instruction:last' ).after(newInstructionRow);
					
					submit_recipe.bindInstructionButtons();
					if (window.enableInstructionImages) {
						submit_recipe.bindInstructionDropzones();
					}
				});
							
				submit_recipe.bindInstructionButtons();
				if (window.enableInstructionImages) {
					submit_recipe.bindInstructionDropzones();
				}
			}
			
			if (window.enableIngredients) {
			
				submit_recipe.bindIngredientButtons();
				submit_recipe.configureSuggest('ingredient_0_name', 'ingredient_search_request');

				$('.add_ingredient').on('click', function(e) {
				
					e.preventDefault();
					
					var lastIngredient = $('.ingredients .f-row.ingredient:last');
					var lastIngredientClass = lastIngredient.attr('class');
					lastIngredientClass = lastIngredientClass.replace('f-row', '');
					lastIngredientClass = lastIngredientClass.replace('ingredient', '');
					lastIngredientClass = lastIngredientClass.replace('ingredient', '');
					lastIngredientClass = lastIngredientClass.replace('_', '');
					var lastIngredientIndex = parseInt(lastIngredientClass);
					var newIngredientIndex = lastIngredientIndex + 1;
					
					var ingredientNamePlaceHolder = window.ingredientNameText;
					var ingredientQuantityPlaceHolder = window.ingredientQuantityText;

					var newIngredientRow = '<div class="f-row ingredient ingredient_' + newIngredientIndex + '">';
					newIngredientRow += '<div class="large">';
					newIngredientRow += '<input class="ingredient_name" type="text" placeholder="' + ingredientNamePlaceHolder + '" name="ingredient_' + newIngredientIndex + '_name" class="ingredient_name" id="ingredient_' + newIngredientIndex + '_name">';
					newIngredientRow += '</div>'
					newIngredientRow += '<div class="small">';
					newIngredientRow += '<input class="ingredient_quantity" type="text" placeholder="' + ingredientQuantityPlaceHolder + '" name="ingredient_' + newIngredientIndex + '_quantity" id="ingredient_' + newIngredientIndex + '_quantity">';
					newIngredientRow += '</div>'
					newIngredientRow += '<div class="third">';
					newIngredientRow += '<select class="ingredient_unit" id="ingredient_' + newIngredientIndex + '_unit" name="ingredient_' + newIngredientIndex + '_unit">';
					newIngredientRow += '</select>'
					newIngredientRow += '</div>'
					newIngredientRow += '<button class="remove remove_ingredient">-</button></div>';

					var $ingredient_unit_options = $("select.ingredient_unit:last > option").clone();
					
					$( '.ingredients .f-row.ingredient:last' ).after(newIngredientRow);

					$('select[name=ingredient_' + newIngredientIndex + '_unit]').append($ingredient_unit_options);
					
					$('select[name=ingredient_' + newIngredientIndex + '_unit]').uniform();
					
					submit_recipe.bindIngredientButtons();
					submit_recipe.configureSuggest('ingredient_' + newIngredientIndex + '_name', 'ingredient_search_request');
				});				
			}
			
			if (window.enableNutritionalElements) {
			
				submit_recipe.bindNutritionalElementButtons();			
				submit_recipe.configureSuggest('nutritional_element_0_name', 'nutritional_element_search_request');
					
				$('.add_nutritional_element').on('click', function(e) {
				
					e.preventDefault();
					
					var lastNutritionalElement = $('.nutritional_elements .f-row.nutritional_element:last');
					var lastNutritionalElementClass = lastNutritionalElement.attr('class');
					lastNutritionalElementClass = lastNutritionalElementClass.replace('f-row', '');
					lastNutritionalElementClass = lastNutritionalElementClass.replace('nutritional_element', '');
					lastNutritionalElementClass = lastNutritionalElementClass.replace('nutritional_element', '');
					lastNutritionalElementClass = lastNutritionalElementClass.replace('_', '');
					var lastNutritionalElementIndex = parseInt(lastNutritionalElementClass);
					var newNutritionalElementIndex = lastNutritionalElementIndex + 1;
					
					var nutritionalElementNamePlaceHolder = window.nutritionalElementNameText;
					var nutritionalElementQuantityPlaceHolder = window.nutritionalElementQuantityText;

					var newNutritionalElementRow = '<div class="f-row nutritional_element nutritional_element_' + newNutritionalElementIndex + '">';
					newNutritionalElementRow += '<div class="large">';
					newNutritionalElementRow += '<input class="nutritional_element_name" type="text" placeholder="' + nutritionalElementNamePlaceHolder + '" name="nutritional_element_' + newNutritionalElementIndex + '_name" class="nutritional_element_name" id="nutritional_element_' + newNutritionalElementIndex + '_name">';
					newNutritionalElementRow += '</div>'
					newNutritionalElementRow += '<div class="small">';
					newNutritionalElementRow += '<input class="nutritional_element_quantity" type="text" placeholder="' + nutritionalElementQuantityPlaceHolder + '" name="nutritional_element_' + newNutritionalElementIndex + '_quantity" id="nutritional_element_' + newNutritionalElementIndex + '_quantity">';
					newNutritionalElementRow += '</div>'
					newNutritionalElementRow += '<div class="third">';
					newNutritionalElementRow += '<select class="nutritional_unit" id="nutritional_' + newNutritionalElementIndex + '_unit" name="nutritional_' + newNutritionalElementIndex + '_unit">';
					newNutritionalElementRow += '</select>'
					newNutritionalElementRow += '</div>'
					newNutritionalElementRow += '<button class="remove remove_nutritional_element">-</button></div>';

					var $nutritional_unit_options = $("select.nutritional_unit:last > option").clone();
					
					$( '.nutritional_elements .f-row.nutritional_element:last' ).after(newNutritionalElementRow);

					$('select[name=nutritional_' + newNutritionalElementIndex + '_unit]').append($nutritional_unit_options);
					
					$('select[name=nutritional_' + newNutritionalElementIndex + '_unit]').uniform();
					
					submit_recipe.bindNutritionalElementButtons();
					submit_recipe.configureSuggest('nutritional_element_' + newNutritionalElementIndex + '_name', 'nutritional_element_search_request');
				});				
			}
			
		},
		bindInstructionButtons : function() {
			$('.remove_instruction').unbind('click');
			$('.remove_instruction').on('click', function(e) {
				e.preventDefault();
				if ($('.instruction').length > 1)
					$(this).closest( ".instruction" ).remove();
			});
		},
		bindInstructionDropzones : function() {
			if (window.enableInstructionImages) {
				$.each($(".instruction-image-index"), function(key, field) {
					var index = field.value;
					if (!$("#instruction-image-uploader-" + index).hasClass('dz-clickable')) {
						var image_id = '';
						var image_uri = '';
						if ($('#instruction-image-uri-' + index).length > 0) {
							image_uri = $('#instruction-image-uri-' + index).val();
						}
						if ($('#instruction-image-id-' + index).length > 0) {
							image_id = $('#instruction-image-id-' + index).val();
						}						
					
						submit_recipe.initializeDropzone("#instruction-image-uploader-" + index, 'frontend_upload_image', 'frontend_delete_instruction_image', '#instruction-image-id-' + index, image_uri, image_id);
					}
				});				
			}
		},
		bindIngredientButtons : function() {
			$('.remove_ingredient').unbind('click');
			$('.remove_ingredient').on('click', function(e) {
				e.preventDefault();
				if ($('.ingredient').length > 1)
					$(this).closest( ".ingredient" ).remove();
			});
		},
		bindNutritionalElementButtons : function() {
			$('.remove_nutritional_element').unbind('click');
			$('.remove_nutritional_element').on('click', function(e) {
				e.preventDefault();
				if ($('.nutritional_element').length > 1)
					$(this).closest( ".nutritional_element" ).remove();
			});
		},
		configureSuggest: function (element_name, ajax_method) {
			$('input[name=' + element_name + ']').suggest(SCAjax.ajax_url + '?action=' + ajax_method + '&nonce=' + SCAjax.nonce, {
				multiple     	: false,
				delimiter		: ';',
				multipleSep		: '',
				resultsClass 	: 'suggest-results',
				selectClass  	: 'suggest-over',
				matchClass   	: 'suggest-match'
			});
		},
		initializeDropzone: function(dropzoneSelector, uploadAction, removeAction, elementIdSelector, existingImageUri, existingImageId) {

			var nonce = $('#fes_nonce').val();
			var entryId = $('#fes_entry_id').val();
			var contentType = $('#fes_content_type').val();			
			var theAjaxUrl = window.adminAjaxUrl + '?action=' + uploadAction + '&_wpnonce=' + nonce + '&entry_id=' + entryId + '&content_type=' + contentType;
			
			var theDropzone = $(dropzoneSelector).dropzone({
			
				url: theAjaxUrl,
				acceptedFiles: 'image/*',
				success: function (file, response) {
				
					file.previewElement.classList.add("dz-success");
					file.image_id = response; // push the id for future reference

					$(elementIdSelector).val($.parseJSON(response));
				},
				error: function (file, response) {
					file.previewElement.classList.add("dz-error");
				},
				// update the following section is for removing image from library
				addRemoveLinks: true,
				uploadMultiple: false,
				maxFiles:1,
				removedfile: function(file) {
				
					var imageId = file.image_id;        
					
					$.ajax({
						type: 'POST',
						url: window.adminAjaxUrl + '?action=' + removeAction,
						data: {
							image_id : imageId,
							entry_id : $('#fes_entry_id').val(),
							_wpnonce : $('#fes_nonce').val(),
							content_type : $('#fes_content_type').val()
						},
						success:function(data) {
							$(elementIdSelector).val('');
						},
						error: function(errorThrown){
							console.log(errorThrown);
						}
					});
					var _ref;
					return (_ref = file.previewElement) !== null ? _ref.parentNode.removeChild(file.previewElement) : void 0;        
				},
				init: function() {
					this.on("addedfile", function() {
						if (this.files.length > 1 && this.files[1] !== null && this.files[1] !== undefined){
							this.removeFile(this.files[0]);
						}
					});
					this.on("maxfilesexceeded", function(file){
						this.removeFile(file);
					});
					
					if (existingImageUri) {
					
						var featuredFileName = existingImageUri.filename();
						var myDropzone = this;
						var mockFile = { 
							size: 12345,
							name: featuredFileName,
							status: Dropzone.ADDED, 
							accepted: true,
							url: existingImageUri,
							image_id: existingImageId
						};

						myDropzone.emit("addedfile", mockFile);
						myDropzone.emit("complete", mockFile);
						myDropzone.emit("thumbnail", mockFile, existingImageUri);
						myDropzone.files.push(mockFile);			
					}
				}
			});		
		}
	}

})(jQuery);