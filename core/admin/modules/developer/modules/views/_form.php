<?php
	namespace BigTree;

	/**
	 * @global string $description
	 * @global Module $module
	 * @global array $options
	 * @global string $preview_url
	 * @global int $related_form
	 * @global string $table
	 * @global string $title
	 * @global string $type
	 */
	
	Extension::initializeCache();
	$forms = ModuleForm::allByModule($module->ID, "title");
?>
<section>
	<div class="left last">
		<fieldset>
			<label class="required"><?=Text::translate('Item Title <small>(for example, "Questions" to make the title "Viewing Questions")</small>')?></label>
			<input type="text" class="required" name="title" value="<?=$title?>" />
		</fieldset>

		<fieldset>
			<label><?=Text::translate("Preview URL <small>(optional, the item's id will be entered as a route)</small>")?></label>
			<input type="text" name="preview_url" value="<?=$preview_url?>" />
		</fieldset>
	</div>
		
	<fieldset class="view_description right last">
		<label><?=Text::translate("Description <small>(instructions for the user)</small>")?></label>
		<textarea name="description" ><?=$description?></textarea>
	</fieldset>			
	<div class="triplets last">
		<fieldset>
			<label class="required"><?=Text::translate("Data Table")?></label>
			<select name="table" id="view_table" class="required" >
				<option></option>
				<?php SQL::drawTableSelectOptions($table); ?>
			</select>
		</fieldset>
		<fieldset>
			<label><?=Text::translate("Related Form")?></label>
			<select name="related_form">
				<option value="">&mdash;</option>
				<?php foreach ($forms as $form) { ?>
				<option value="<?=$form->ID?>"<?php if ($form->ID == $related_form) { ?> selected="selected"<?php } ?>><?=$form->Title?> (<?=$form->Table?>)</option>
				<?php } ?>
			</select>
		</fieldset>
		<fieldset class="view_type">
			<label><?=Text::translate("View Type")?></label>
			<select name="type" id="view_type" class="left">
				<optgroup label="<?=Text::translate("Core", true)?>">
					<?php foreach (ModuleView::$CoreTypes as $key => $t) { ?>
					<option value="<?=$key?>"<?php if ($key == $type) { ?> selected="selected"<?php } ?>><?=$t?></option>
					<?php } ?>
				</optgroup>
				<optgroup label="<?=Text::translate("Extension", true)?>">
					<?php
						foreach (ModuleView::$Plugins as $extension => $extension_types) {
							foreach ($extension_types as $key => $name) {
								$view_key = "$extension*$key";
					?>
					<option value="<?=$view_key?>"<?php if ($view_key == $type) { ?> selected="selected"<?php } ?>><?=$name?></option>
					<?php
							}
						}
					?>
				</optgroup>
			</select>
			&nbsp; <a href="#" class="options icon_settings centered"></a>
			<input type="hidden" name="options" id="view_options" value="<?=htmlspecialchars(json_encode($options))?>" />
		</fieldset>
	</div>
</section>
<section class="sub" id="field_area">
	<?php
		if (!$table) {
	?>
	<p><?=Text::translate("Please choose a table to populate this area.")?></p>
	<?php
		} else {
			include Router::getIncludePath("admin/ajax/developer/load-view-fields.php");
		}
	?>
</section>