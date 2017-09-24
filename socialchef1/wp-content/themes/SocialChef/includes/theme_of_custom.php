<?php 
/*
 * Custom optionsframework scripts
 */
function of_sc_options_script(){	?>
	<style>
		#optionsframework .to-copy {display: none;}
	</style>
	<script type="text/javascript">
		jQuery(function($){
		
			bindSectionVisibility('enable_nutritional_elements');
			bindSectionVisibility('enable_ingredients');
			bindSectionVisibility('enable_recipe_meta');
			
			function bindSectionVisibility(checkboxId) {
				toggleSectionVisibility($("#" + checkboxId).is(':checked'), checkboxId);
				
				$("#" + checkboxId).change(function() {
					toggleSectionVisibility(this.checked, checkboxId);
				});
			}
			
			function toggleSectionVisibility(show, checkboxId) {
				if (checkboxId == 'enable_nutritional_elements') {
					if (show){
						$("#section-nutritional_element_permalink_slug").children().show();
					} else {
						$("#section-nutritional_element_permalink_slug").children().hide();
					}		
				} else if (checkboxId == 'enable_ingredients') {
					if (show){
						$("#section-ingredient_permalink_slug").children().show();
					} else {
						$("#section-ingredient_permalink_slug").children().hide();
					}						
				} else if (checkboxId == 'enable_recipe_meta') {
					if (show){
						$("#section-meal_course_permalink_slug").children().show();
						$("#section-difficulty_permalink_slug").children().show();
					} else {
						$("#section-meal_course_permalink_slug").children().hide();
						$("#section-difficulty_permalink_slug").children().hide();
					}						
				}
			}
			
		});
	</script>
<?php
}
add_action( 'optionsframework_custom_scripts', 'of_sc_options_script' );