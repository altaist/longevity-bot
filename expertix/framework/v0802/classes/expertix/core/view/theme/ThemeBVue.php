<?php

namespace Expertix\Core\View\Theme;

class ThemeBVue extends ThemeBootstrap
{
	public function input($key, $label, $props = "size='lg'", $required = "", $placeholder = "")
	{
		$field = $key;
		$labelHtml = empty($label) ? "" : "label = '$label'";
		return $this->process(<<<EOT
		<b-form-group id="input-group-$key" $labelHtml label-for="input-$key">
			<b-form-input id="input-$key" v-model="$field" $props $required placeholder="$placeholder"></b-form-input>
		</b-form-group>			
EOT);
	}

	public function textarea($key, $label, $props = "size='lg'", $rows = 3, $maxrows = 5, $required = "", $placeholder = "")
	{
		$field = $key;
		return $this->process(<<<EOT
<b-form-group id="input-group-$key" label="$label" label-for="input-$key">
	<b-form-textarea id="input-$key" v-model="$field" rows="$rows" $props max-rows="$maxrows" $required placeholder="$placeholder"></b-form-textarea>
</b-form-group>			
EOT);
	}
	public function textarea_copy($key, $label, $rows = 3, $maxrows = 5, $props = "", $required = "", $placeholder = "")
	{
		$field = $key;
		return $this->process(<<<EOT
<b-form-group id="input-group-$key" label="$label" label-for="input-$key">
	<a href="#" @click.prevent="copyClipboard($key)">Copy</a>
	<b-form-textarea id="input-$key" v-model="$field" rows="$rows" $props max-rows="$maxrows" $required placeholder="$placeholder"></b-form-textarea>
	
</b-form-group>			
EOT);
	}

	public function select($key, $label, $selectOptions, $tagParams = "", $required = "", $placeholder = "")
	{
		$field = $key;
		return $this->process(<<<EOT
<b-form-group id="input-group-$key" label="$label" label-for="input-$key">
	<b-form-select id="input-$key" size="lg" v-model="$field" :options="$selectOptions" $tagParams $required placeholder="$placeholder"></b-form-select>
</b-form-group>			
EOT);
	}

	public function checkbox($key, $label, $labelGroup)
	{
		return $this->process(<<<EOT
<b-form-group id="input-group-$key" label="$labelGroup" label-for="input-$key">
<b-form-checkbox
      id="$key"
      v-model="$key"
      name="$key"
      value="1"
      unchecked-value="0"
    >$label</b-form-checkbox>
</b-form-group>
EOT);
	}

	public function spinbutton($key, $label, $min, $max, $props = "", $required = "", $placeholder = "")
	{
		$field = $key;
		return $this->process(<<<EOT
<b-form-group id="input-group-$key" label="$label" label-for="input-$key">
	<b-form-spinbutton id="input-$key" v-model="$field" $props, $required  min="$min" max="$max"></b-form-spinbutton>
</b-form-group>			
EOT);
	}

	public function button($action, $label, $variant = "primary", $tagParams = "")
	{
		return $this->process(<<<EOT
<b-button @click.prevent="$action" size="lg" variant="$variant" $tagParams>$label</b-button>
EOT);
	}
	public function aclick($label, $href, $tagParams = "")
	{
		return $this->process(<<<EOT
<a href="#" @click.prevent="$href" $tagParams>$label</a>		
EOT);
	}
}
