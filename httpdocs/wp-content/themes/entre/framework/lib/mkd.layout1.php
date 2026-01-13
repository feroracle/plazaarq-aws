<?php

/*
   Interface: iEntreMikadoLayoutNode
   A interface that implements Layout Node methods
*/
interface iEntreMikadoLayoutNode {
	public function hasChidren();
	public function getChild($key);
	public function addChild($key, $value);
}

/*
   Interface: iEntreMikadoRender
   A interface that implements Render methods
*/
interface iEntreMikadoRender {
	public function render($factory);
}

/*
   Class: EntreMikadoPanel
   A class that initializes Mikado Panel
*/
class EntreMikadoPanel implements iEntreMikadoLayoutNode, iEntreMikadoRender {
	public $children;
	public $title;
	public $name;
	public $hidden_property;
	public $hidden_value;
	public $hidden_values;
	public $args;

	function __construct($title_label="",$name="",$hidden_property="",$hidden_value="",$hidden_values=array(),$args=array()) {
		$this->children = array();
		$this->title = $title_label;
		$this->name = $name;
		$this->hidden_property = $hidden_property;
		$this->hidden_value = $hidden_value;
		$this->hidden_values = $hidden_values;
		$this->args = $args;
	}

	public function hasChidren() {
		return (is_array($this->children) && count($this->children) > 0)?true:false;
	}

	public function getChild($key) {
		return $this->children[$key];
	}

	public function addChild($key, $value) {
		$this->children[$key] = $value;
	}

	public function render($factory) {
		$hidden = false;
		
		if(!empty($this->args['use_both_dep']) && !empty($this->hidden_property)) {
			$hidden1 = false;
			$hidden2 = false;
			foreach ($this->hidden_values as $value) {
				if (entre_mikado_option_get_value($this->hidden_property)==$value) {
					$hidden1 = true;
				}
			}
			
			foreach ($this->args['additional_hidden_values'] as $value) {
				if (entre_mikado_option_get_value($this->args['additional_hidden_property'])==$value) {
					$hidden2 = true;
				}
			}
			
			if(($hidden1 && $hidden2) || (!$hidden1 && $hidden2) || ($hidden1 && !$hidden2)) {
				$hidden = true;
			}
			
		} else if (!empty($this->hidden_property)){
			if (entre_mikado_option_get_value($this->hidden_property)==$this->hidden_value) {
				$hidden = true;
			} else {
				foreach ($this->hidden_values as $value) {
					if (entre_mikado_option_get_value($this->hidden_property)==$value) {
						$hidden = true;
					}
				}
			}
		}
		?>
		<div class="mkd-page-form-section-holder" id="mkd_<?php echo esc_attr($this->name); ?>"<?php if ($hidden) { ?> style="display: none"<?php } ?>>
			<h3 class="mkd-page-section-title"><?php echo esc_html($this->title); ?></h3>
			<?php foreach ($this->children as $child) {
				$this->renderChild($child, $factory);
			} ?>
		</div>
	<?php
	}

	public function renderChild(iEntreMikadoRender $child, $factory) {
		$child->render($factory);
	}
}

class EntreMikadoContainer implements iEntreMikadoLayoutNode, iEntreMikadoRender {
	public $children;
	public $name;
	public $hidden_property;
	public $hidden_value;
	public $hidden_values;

	function __construct($name="",$hidden_property="",$hidden_value="",$hidden_values=array()) {
		$this->children = array();
		$this->name = $name;
		$this->hidden_property = $hidden_property;
		$this->hidden_value = $hidden_value;
		$this->hidden_values = $hidden_values;
	}

	public function hasChidren() {
		return (is_array($this->children) && count($this->children) > 0)?true:false;
	}

	public function getChild($key) {
		return $this->children[$key];
	}

	public function addChild($key, $value) {
		$this->children[$key] = $value;
	}

	public function render($factory) {
		$hidden = false;

		if (!empty($this->hidden_property)){
			if (entre_mikado_option_get_value($this->hidden_property)==$this->hidden_value) {
				$hidden = true;
			} else {
				foreach ($this->hidden_values as $value) {
					if (entre_mikado_option_get_value($this->hidden_property)==$value) {
						$hidden = true;
					}
				}
			}
		}
		?>
		<div class="mkd-page-form-container-holder" id="mkd_<?php echo esc_attr($this->name); ?>"<?php if ($hidden) { ?> style="display: none"<?php } ?>>
			<?php foreach ($this->children as $child) {
				$this->renderChild($child, $factory);
			} ?>
		</div>
		<?php
	}

	public function renderChild(iEntreMikadoRender $child, $factory) {
		$child->render($factory);
	}
}

/*
   Class: EntreMikadoContainerNoStyle
   A class that initializes Mikado Container without css classes
*/
class EntreMikadoContainerNoStyle implements iEntreMikadoLayoutNode, iEntreMikadoRender {
	public $children;
	public $name;
	public $hidden_property;
	public $hidden_value;
	public $hidden_values;
	public $args;

	function __construct($name="",$hidden_property="",$hidden_value="",$hidden_values=array(),$args=array()) {
		$this->children = array();
		$this->name = $name;
		$this->hidden_property = $hidden_property;
		$this->hidden_value = $hidden_value;
		$this->hidden_values = $hidden_values;
		$this->args = $args;
	}

	public function hasChidren() {
		return (is_array($this->children) && count($this->children) > 0)?true:false;
	}

	public function getChild($key) {
		return $this->children[$key];
	}

	public function addChild($key, $value) {
		$this->children[$key] = $value;
	}

	public function render($factory) {
		$hidden = false;
		
		if (!empty($this->hidden_property)){
			if (entre_mikado_option_get_value($this->hidden_property)==$this->hidden_value) {
				$hidden = true;
				
				if(!empty($this->args) && $this->args['enable_panels_for_default_value']) {
					$hidden = false;
				}
			} else {
				foreach ($this->hidden_values as $value) {
					if (entre_mikado_option_get_value($this->hidden_property)==$value) {
						$hidden = true;
					}
				}
			}
		}
		?>
		<div id="mkd_<?php echo esc_attr($this->name); ?>"<?php if ($hidden) { ?> style="display: none"<?php } ?>>
			<?php foreach ($this->children as $child) {
				$this->renderChild($child, $factory);
			} ?>
		</div>
	<?php
	}

	public function renderChild(iEntreMikadoRender $child, $factory) {
		$child->render($factory);
	}
}

/*
   Class: EntreMikadoGroup
   A class that initializes Mikado Group
*/
class EntreMikadoGroup implements iEntreMikadoLayoutNode, iEntreMikadoRender {
	public $children;
	public $title;
	public $description;

	function __construct($title_label="",$description="") {
		$this->children = array();
		$this->title = $title_label;
		$this->description = $description;
	}

	public function hasChidren() {
		return (is_array($this->children) && count($this->children) > 0)?true:false;
	}

	public function getChild($key) {
		return $this->children[$key];
	}

	public function addChild($key, $value) {
		$this->children[$key] = $value;
	}

	public function render($factory) { ?>

		<div class="mkd-page-form-section">
			<div class="mkd-field-desc">
				<h4><?php echo esc_html($this->title); ?></h4>
				<p><?php echo esc_html($this->description); ?></p>
			</div>
			<div class="mkd-section-content">
				<div class="container-fluid">
					<?php foreach ($this->children as $child) {
						$this->renderChild($child, $factory);
					} ?>
				</div>
			</div>
		</div>
	<?php
	}

	public function renderChild(iEntreMikadoRender $child, $factory) {
		$child->render($factory);
	}
}

/*
   Class: EntreMikadoNotice
   A class that initializes Mikado Notice
*/
class EntreMikadoNotice implements iEntreMikadoRender {
	public $children;
	public $title;
	public $description;
	public $notice;
	public $hidden_property;
	public $hidden_value;
	public $hidden_values;

	function __construct($title_label="",$description="",$notice="",$hidden_property="",$hidden_value="",$hidden_values=array()) {
		$this->children = array();
		$this->title = $title_label;
		$this->description = $description;
		$this->notice = $notice;
		$this->hidden_property = $hidden_property;
		$this->hidden_value = $hidden_value;
		$this->hidden_values = $hidden_values;
	}

	public function render($factory) {
		$hidden = false;
		if (!empty($this->hidden_property)){
			if (entre_mikado_option_get_value($this->hidden_property)==$this->hidden_value) {
				$hidden = true;
			} else {
				foreach ($this->hidden_values as $value) {
					if (entre_mikado_option_get_value($this->hidden_property)==$value) {
						$hidden = true;
					}
				}
			}
		}
		?>

		<div class="mkd-page-form-section"<?php if ($hidden) { ?> style="display: none"<?php } ?>>
			<div class="mkd-field-desc">
				<h4><?php echo esc_html($this->title); ?></h4>
				<p><?php echo esc_html($this->description); ?></p>
			</div>
			<div class="mkd-section-content">
				<div class="container-fluid">
					<div class="alert alert-warning">
						<?php echo esc_html($this->notice); ?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
}

/*
   Class: EntreMikadoRow
   A class that initializes Mikado Row
*/
class EntreMikadoRow implements iEntreMikadoLayoutNode, iEntreMikadoRender {
	public $children;
	public $next;

	function __construct($next=false) {
		$this->children = array();
		$this->next = $next;
	}

	public function hasChidren() {
		return (is_array($this->children) && count($this->children) > 0)?true:false;
	}

	public function getChild($key) {
		return $this->children[$key];
	}

	public function addChild($key, $value) {
		$this->children[$key] = $value;
	}

	public function render($factory) { ?>
		
		<div class="row<?php if ($this->next) echo " next-row"; ?>">
			<?php foreach ($this->children as $child) {
				$this->renderChild($child, $factory);
			} ?>
		</div>
	<?php
	}

	public function renderChild(iEntreMikadoRender $child, $factory) {
		$child->render($factory);
	}
}

/*
   Class: EntreMikadoTitle
   A class that initializes Mikado Title
*/
class EntreMikadoTitle implements iEntreMikadoRender {
	private $name;
	private $title;
	public $hidden_property;
	public $hidden_value;
	public $hidden_values = array();

	function __construct($name="",$title_label="",$hidden_property="",$hidden_value="") {
		$this->title = $title_label;
		$this->name = $name;
		$this->hidden_property = $hidden_property;
		$this->hidden_value = $hidden_value;
	}

	public function render($factory) {
		$hidden = false;
		if (!empty($this->hidden_property)){
			if (entre_mikado_option_get_value($this->hidden_property)==$this->hidden_value) {
				$hidden = true;
			}
		}
		?>
		<h5 class="mkd-page-section-subtitle" id="mkd_<?php echo esc_attr($this->name); ?>"<?php if ($hidden) { ?> style="display: none"<?php } ?>><?php echo esc_html($this->title); ?></h5>
	<?php
	}
}

/*
   Class: EntreMikadoField
   A class that initializes Mikado Field
*/
class EntreMikadoField implements iEntreMikadoRender {
	private $type;
	private $name;
	private $default_value;
	private $label;
	private $description;
	private $options = array();
	private $args = array();
	public $hidden_property;
	public $hidden_values = array();

	function __construct($type,$name,$default_value="",$label="",$description="", $options = array(), $args = array(),$hidden_property="", $hidden_values = array()) {
		global $entre_mikado_Framework;
		$this->type = $type;
		$this->name = $name;
		$this->default_value = $default_value;
		$this->label = $label;
		$this->description = $description;
		$this->options = $options;
		$this->args = $args;
		$this->hidden_property = $hidden_property;
		$this->hidden_values = $hidden_values;
		$entre_mikado_Framework->mkdOptions->addOption($this->name,$this->default_value, $type);
	}

	public function render($factory) {
		$hidden = false;
		
		if (!empty($this->hidden_property)){
			foreach ($this->hidden_values as $value) {
				if (entre_mikado_option_get_value($this->hidden_property)==$value) {
					$hidden = true;
				}
			}
		}
		
		$factory->render( $this->type, $this->name, $this->label, $this->description, $this->options, $this->args, $hidden );
	}
}

/*
   Class: EntreMikadoMetaField
   A class that initializes Mikado Meta Field
*/
class EntreMikadoMetaField implements iEntreMikadoRender {
	private $type;
	private $name;
	private $default_value;
	private $label;
	private $description;
	private $options = array();
	private $args = array();
	public $hidden_property;
	public $hidden_values = array();
	
	function __construct($type,$name,$default_value="",$label="",$description="", $options = array(), $args = array(),$hidden_property="", $hidden_values = array()) {
		global $entre_mikado_Framework;
		$this->type = $type;
		$this->name = $name;
		$this->default_value = $default_value;
		$this->label = $label;
		$this->description = $description;
		$this->options = $options;
		$this->args = $args;
		$this->hidden_property = $hidden_property;
		$this->hidden_values = $hidden_values;
		$entre_mikado_Framework->mkdMetaBoxes->addOption($this->name, $this->default_value, $type);
	}

	public function render($factory) {
		$hidden = false;
		if (!empty($this->hidden_property)){
			foreach ($this->hidden_values as $value) {
				if (entre_mikado_option_get_value($this->hidden_property)==$value) {
					$hidden = true;
				}
			}
		}
		$factory->render( $this->type, $this->name, $this->label, $this->description, $this->options, $this->args, $hidden );
	}
}

abstract class EntreMikadoFieldType {

	abstract public function render( $name, $label="",$description="", $options = array(), $args = array(), $hidden = false );
}

class EntreMikadoFieldText extends EntreMikadoFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false, $repeat = array() ) {
		$col_width = 12;
		if(isset($args["col_width"])) {
            $col_width = $args["col_width"];
        }

        $suffix = !empty($args['suffix']) ? $args['suffix'] : false;

        $class = '';
        $data_string = '';
        if (!empty($repeat)) {
            if(array_key_exists('index', $repeat)) {
                $id = $name . '-' . $repeat['index'];
            } else {
                $id = $name;
            }
            if(array_key_exists('name', $repeat)) {
                $name = $repeat['name'];
            }
            $name .= '[]';
            $value = $repeat['value'];
            $class = 'mkd-repeater-field';
        } else {
            $id = $name;
            $value = entre_mikado_option_get_value($name);
        }

        if($label === '' && $description === '') {
            $class .= ' mkd-no-description';
        }

        if(isset($args['custom_class']) && $args['custom_class'] != '') {
            $class .= ' '  . $args['custom_class'];
        }

        if(isset($args['input-data']) && $args['input-data'] != '') {
            foreach($args['input-data'] as $data_key => $data_value) {
                $data_string .= $data_key . '=' . $data_value;
                $data_string .= ' ';
            }
        }
		?>

		<div class="mkd-page-form-section <?php echo esc_attr($class); ?>" id="mkd_<?php echo esc_attr($id); ?>"<?php if ($hidden) { ?> style="display: none"<?php } ?>>
			<div class="mkd-field-desc">
				<h4><?php echo esc_html($label); ?></h4>
				<p><?php echo esc_html($description); ?></p>
			</div>
			<div class="mkd-section-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-<?php echo esc_attr($col_width); ?>">
                            <?php if($suffix) : ?>
                            <div class="input-group">
                            <?php endif; ?>
                                <input type="text" <?php echo esc_attr($data_string); ?> class="form-control mkd-input mkd-form-element" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr(htmlspecialchars($value)); ?>" />
                                <?php if($suffix) : ?>
                                    <div class="input-group-addon"><?php echo esc_html($args['suffix']); ?></div>
                                <?php endif; ?>
                            <?php if($suffix) : ?>
                            </div>
                            <?php endif; ?>
                        </div>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
}

class EntreMikadoFieldTextSimple extends EntreMikadoFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false ) {
		$suffix = !empty($args['suffix']) ? $args['suffix'] : false; ?>

		<div class="col-lg-3" id="mkd_<?php echo esc_attr($name); ?>"<?php if ($hidden) { ?> style="display: none"<?php } ?>>
			<em class="mkd-field-description"><?php echo esc_html($label); ?></em>
			<?php if($suffix) : ?>
			<div class="input-group">
            <?php endif; ?>
				<input type="text" class="form-control mkd-input mkd-form-element" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr(htmlspecialchars(entre_mikado_option_get_value($name))); ?>" />
				<?php if($suffix) : ?>
					<div class="input-group-addon"><?php echo esc_html($args['suffix']); ?></div>
				<?php endif; ?>
			<?php if($suffix) : ?>
			</div>
			<?php endif; ?>
		</div>
	<?php
	}
}

class EntreMikadoFieldTextArea extends EntreMikadoFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false, $repeat = array() ) {
		$class = '';

		if ( ! empty( $repeat ) ) {
			if ( array_key_exists( 'index', $repeat ) ) {
				$id = $name . '-' . $repeat['index'];
			} else {
				$id = $name;
			}
			if ( array_key_exists( 'name', $repeat ) ) {
				$name = $repeat['name'];
			}
			$name  .= '[]';
			$value = $repeat['value'];
			$class = 'mkd-repeater-field';
		} else {
			$id    = $name;
			$value = entre_mikado_option_get_value( $name );
		}
		
		if ( $label === '' && $description === '' ) {
			$class .= ' mkd-no-description';
		}
		?>
		
		<div class="mkd-page-form-section <?php echo esc_attr( $class ); ?>" id="mkd_<?php echo esc_attr( $id ); ?>">
			<div class="mkd-field-desc">
				<h4><?php echo esc_html( $label ); ?></h4>
				<p><?php echo esc_html( $description ); ?></p>
			</div>
			<div class="mkd-section-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<textarea class="form-control mkd-form-element" name="<?php echo esc_attr( $name ); ?>" rows="5"><?php echo esc_html( htmlspecialchars( $value ) ); ?></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
}

class EntreMikadoFieldTextAreaSimple extends EntreMikadoFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false ) {	?>
		<div class="col-lg-3">
			<em class="mkd-field-description"><?php echo esc_html($label); ?></em>
			<textarea class="form-control mkd-form-element" name="<?php echo esc_attr($name); ?>" rows="5"><?php echo esc_html(entre_mikado_option_get_value($name)); ?></textarea>
		</div>
	<?php
	}
}

class EntreMikadoFieldTextAreaHtml extends EntreMikadoFieldType {
	
	public function render($name, $label = "", $description = "", $options = array(), $args = array(), $hidden = false, $repeat = array()) {
		
		$class = '';
		if (!empty($repeat)) {
            if(array_key_exists('index', $repeat)) {
                $id = $name . '_' . $repeat['index'];
				$field_id = $name . '_textarea_' . $repeat['index'];
            } else {
                $id = $name;
				$field_id = $name . '_textarea';
            }
            if(array_key_exists('name', $repeat)) {
                $name = $repeat['name'];
            }
            $name .= '[]';
            $value = $repeat['value'];
            $class .= ' mkd-repeater-field';
		} else {
			$id = $field_id = $name;
            $value = entre_mikado_option_get_value($name);
		}

        if($label === '' && $description === '') {
            $class .= ' mkd-no-description';
        }

		?>
		<div class="mkd-page-form-section <?php echo esc_attr($class); ?>" id="mkd_<?php echo esc_attr($id); ?>">
			<div class="mkd-field-desc">
				<h4><?php echo esc_html($label); ?></h4>
				<p><?php echo esc_html($description); ?></p>
			</div>
			<div class="mkd-section-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12 <?php echo esc_attr($class); ?>">
							<?php wp_editor( $value, $field_id, array('textarea_name' => $name, 'height' => '200'));?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

class EntreMikadoFieldColor extends EntreMikadoFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false ) {	?>
		<div class="mkd-page-form-section" id="mkd_<?php echo esc_attr($name); ?>">
			<div class="mkd-field-desc">
				<h4><?php echo esc_html($label); ?></h4>
				<p><?php echo esc_html($description); ?></p>
			</div>
			<div class="mkd-section-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<input type="text" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr(entre_mikado_option_get_value($name)); ?>" class="my-color-field"/>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
}

class EntreMikadoFieldColorSimple extends EntreMikadoFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false ) { ?>
		<div class="col-lg-3" id="mkd_<?php echo esc_attr($name); ?>"<?php if ($hidden) { ?> style="display: none"<?php } ?>>
			<em class="mkd-field-description"><?php echo esc_html($label); ?></em>
			<input type="text" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr(entre_mikado_option_get_value($name)); ?>" class="my-color-field"/>
		</div>
	<?php
	}
}

class EntreMikadoFieldImage extends EntreMikadoFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false, $repeat = array() ) {

        $class = '';
        if (!empty($repeat)) {
            if(array_key_exists('index', $repeat)) {
                $id = $name . '-' . $repeat['index'];
            } else {
                $id = $name;
            }
            if(array_key_exists('name', $repeat)) {
                $name = $repeat['name'];
            }
            $name .= '[]';
            $value = $repeat['value'];
            $has_image = !empty($value);
            $class = 'mkd-repeater-field';
        } else {
            $id = $name;
            $has_image = entre_mikado_option_has_value($name);
            $value = entre_mikado_option_get_value($name);
        }

        if($label === '' && $description === '') {
            $class .= ' mkd-no-description';
        }
        ?>

		<div class="mkd-page-form-section <?php echo esc_attr($class); ?>" id="mkd_<?php echo esc_attr($id); ?>">
			<div class="mkd-field-desc">
				<h4><?php echo esc_html($label); ?></h4>
				<p><?php echo esc_html($description); ?></p>
			</div>
			<div class="mkd-section-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<div class="mkd-media-uploader">
								<div<?php if (!$has_image) { ?> style="display: none"<?php } ?> class="mkd-media-image-holder">
									<img src="<?php if ($has_image) { echo esc_url(entre_mikado_get_attachment_thumb_url($value)); } ?>" alt="<?php esc_attr_e( 'Image thumbnail', 'entre' ); ?>"  class="mkd-media-image img-thumbnail" />
								</div>
								<div style="display: none" class="mkd-media-meta-fields">
									<input type="hidden" class="mkd-media-upload-url" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($value); ?>"/>
								</div>
								<a class="mkd-media-upload-btn btn btn-sm btn-primary" href="javascript:void(0)" data-frame-title="<?php esc_attr_e('Select Image', 'entre'); ?>" data-frame-button-text="<?php esc_attr_e('Select Image', 'entre'); ?>"><?php esc_html_e('Upload', 'entre'); ?></a>
								<a style="display: none;" href="javascript: void(0)" class="mkd-media-remove-btn btn btn-default btn-sm"><?php esc_html_e('Remove', 'entre'); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
}

class EntreMikadoFieldImageSimple extends EntreMikadoFieldType {
    public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false ) { ?>
        <div class="col-lg-3" id="mkd_<?php echo esc_attr($name); ?>"<?php if ($hidden) { ?> style="display: none"<?php } ?>>
            <em class="mkd-field-description"><?php echo esc_html($label); ?></em>
            <div class="mkd-media-uploader">
                <div<?php if (!entre_mikado_option_has_value($name)) { ?> style="display: none"<?php } ?> class="mkd-media-image-holder">
                    <img src="<?php if (entre_mikado_option_has_value($name)) { echo esc_url(entre_mikado_get_attachment_thumb_url(entre_mikado_option_get_value($name))); } ?>" alt="<?php esc_attr_e( 'Image thumbnail', 'entre' ); ?>" class="mkd-media-image img-thumbnail"/>
                </div>
                <div style="display: none" class="mkd-media-meta-fields">
                    <input type="hidden" class="mkd-media-upload-url" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr(entre_mikado_option_get_value($name)); ?>"/>
                </div>
                <a class="mkd-media-upload-btn btn btn-sm btn-primary" href="javascript:void(0)" data-frame-title="<?php esc_attr_e('Select Image', 'entre'); ?>" data-frame-button-text="<?php esc_attr_e('Select Image', 'entre'); ?>"><?php esc_html_e('Upload', 'entre'); ?></a>
                <a style="display: none;" href="javascript: void(0)" class="mkd-media-remove-btn btn btn-default btn-sm"><?php esc_html_e('Remove', 'entre'); ?></a>
            </div>
        </div>
    <?php
    }
}

class EntreMikadoFieldFont extends EntreMikadoFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false ) {
		global $entre_mikado_fonts_array;
		?>

		<div class="mkd-page-form-section">
			<div class="mkd-field-desc">
				<h4><?php echo esc_html($label); ?></h4>
				<p><?php echo esc_html($description); ?></p>
			</div>
			<div class="mkd-section-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-3">
							<select class="mkd-select2 form-control mkd-form-element" name="<?php echo esc_attr($name); ?>">
								<option value="-1"><?php esc_html_e( 'Default', 'entre' ); ?></option>
								<?php foreach($entre_mikado_fonts_array as $fontArray) { ?>
									<option <?php if (entre_mikado_option_get_value($name) == str_replace(' ', '+', $fontArray["family"])) { echo "selected='selected'"; } ?>  value="<?php echo esc_attr(str_replace(' ', '+', $fontArray["family"])); ?>"><?php echo esc_html($fontArray["family"]); ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
}

class EntreMikadoFieldFontSimple extends EntreMikadoFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false ) {
		global $entre_mikado_fonts_array;
		?>

		<div class="col-lg-3">
			<em class="mkd-field-description"><?php echo esc_html($label); ?></em>
			<select class="mkd-select2 form-control mkd-form-element" name="<?php echo esc_attr($name); ?>">
				<option value="-1"><?php esc_html_e( 'Default', 'entre' ); ?></option>
				<?php foreach($entre_mikado_fonts_array as $fontArray) { ?>
					<option <?php if (entre_mikado_option_get_value($name) == str_replace(' ', '+', $fontArray["family"])) { echo "selected='selected'"; } ?>  value="<?php echo esc_attr(str_replace(' ', '+', $fontArray["family"])); ?>"><?php echo esc_html($fontArray["family"]); ?></option>
				<?php } ?>
			</select>
		</div>
	<?php
	}
}

class EntreMikadoFieldSelect extends EntreMikadoFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false, $repeat= array() ) {
        $class = '';

        if (!empty($repeat)) {
            if(array_key_exists('index', $repeat)) {
                $id = $name . '-' . $repeat['index'];
            } else {
                $id = $name;
            }
            if(array_key_exists('name', $repeat)) {
                $name = $repeat['name'];
            }
            $name .= '[]';
            $rvalue = $repeat['value'];
            $class = 'mkd-repeater-field';
        } else {
            $id = $name;
            $rvalue = entre_mikado_option_get_value($name);
        }
		
		$dependence = false;
		if(isset($args["dependence"])) {
			$dependence = true;
		}
		
		$show = array();
		if(isset($args["show"])) {
			$show = $args["show"];
		}
		
		$hide = array();
		if(isset($args["hide"])) {
			$hide = $args["hide"];
		}

		$select2 = '';
		if (isset($args['select2'])) {
			$select2 = 'mkd-select2';
		}
		$col_width = 3;
		if(isset($args['col_width'])) {
		    $col_width = $args['col_width'];
        }

		$switcher = '';
		$data_switch_type = '';
		$data_switch_property = '';
		$data_switch_enabled = '';
		if(isset($args["use_as_switcher"]))
            $switcher = $args["use_as_switcher"] ? 'mkd-switcher' : "";
		    if(isset($args['switch_type'])) {
                $data_switch_type = $args['switch_type'];
            }
            if(isset($args['switch_property'])) {
                $data_switch_property = $args['switch_property'];
            }
        if(isset($args['switch_enabled'])) {
            $data_switch_enabled = $args['switch_enabled'];
        }

        if($label === '' && $description === '') {
            $class .= ' mkd-no-description';
        }

		?>

		<div class="mkd-page-form-section <?php echo esc_attr($class); ?>" id="mkd_<?php echo esc_attr($id); ?>" <?php if ($hidden) { ?> style="display: none"<?php } ?>>
			<div class="mkd-field-desc">
				<h4><?php echo esc_html($label); ?></h4>
				<p><?php echo esc_html($description); ?></p>
			</div>
			<div class="mkd-section-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-<?php echo esc_attr($col_width); ?>">
							<select class="<?php echo esc_attr($select2) . ' ' . esc_attr($switcher); ?> form-control mkd-form-element<?php if ($dependence) { echo " dependence"; } ?>"
                                data-switch-type="<?php echo esc_attr($data_switch_type); ?>"
                                data-switch-property="<?php echo esc_attr($data_switch_property); ?>"
                                data-switch-enabled="<?php echo esc_attr($data_switch_enabled); ?>"
								<?php foreach($show as $key=>$value) { ?>
									data-show-<?php echo str_replace(' ', '',$key); ?>="<?php echo esc_attr($value); ?>"
								<?php } ?>
								<?php foreach($hide as $key=>$value) { ?>
									data-hide-<?php echo str_replace(' ', '',$key); ?>="<?php echo esc_attr($value); ?>"
								<?php } ?>
									name="<?php echo esc_attr($name); ?>">
								<?php foreach($options as $key=>$value) { if ($key == "-1") $key = ""; ?>
									<option <?php if ($rvalue == $key) { echo "selected='selected'"; } ?>  value="<?php echo esc_attr($key); ?>"><?php echo esc_html($value); ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
}

class EntreMikadoFieldSelectBlank extends EntreMikadoFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false ) {
		$dependence = false;
		if(isset($args["dependence"])) {
			$dependence = true;
		}
		
		$show = array();
		if(isset($args["show"])) {
			$show = $args["show"];
		}
		
		$hide = array();
		if(isset($args["hide"])) {
			$hide = $args["hide"];
		}

		$select2 = '';
		if (isset($args['select2'])) {
			$select2 = ($args['select2']) ? 'mkd-select2' : '';
		}
		?>

		<div class="mkd-page-form-section"<?php if ($hidden) { ?> style="display: none"<?php } ?>>
			<div class="mkd-field-desc">
				<h4><?php echo esc_html($label); ?></h4>
				<p><?php echo esc_html($description); ?></p>
			</div>
			<div class="mkd-section-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-3">
							<select class="<?php echo esc_attr($select2); ?> form-control mkd-form-element<?php if ($dependence) { echo " dependence"; } ?>"
								<?php foreach($show as $key=>$value) { ?>
									data-show-<?php echo str_replace(' ', '',$key); ?>="<?php echo esc_attr($value); ?>"
								<?php } ?>
								<?php foreach($hide as $key=>$value) { ?>
									data-hide-<?php echo str_replace(' ', '',$key); ?>="<?php echo esc_attr($value); ?>"
								<?php } ?>
									name="<?php echo esc_attr($name); ?>">
								<option <?php if (entre_mikado_option_get_value($name) == "") { echo "selected='selected'"; } ?>  value=""></option>
								<?php foreach($options as $key=>$value) { if ($key == "-1") $key = ""; ?>
									<option <?php if (entre_mikado_option_get_value($name) == $key) { echo "selected='selected'"; } ?>  value="<?php echo esc_attr($key); ?>"><?php echo esc_html($value); ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
}

class EntreMikadoFieldSelectSimple extends EntreMikadoFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false ) {
        $dependence = false;
        if(isset($args["dependence"])) {
	        $dependence = true;
        }
        
        $show = array();
        if(isset($args["show"])) {
	        $show = $args["show"];
        }
        
        $hide = array();
        if(isset($args["hide"])) {
	        $hide = $args["hide"];
        }
        ?>
		
		<div class="col-lg-3">
			<em class="mkd-field-description"><?php echo esc_html($label); ?></em>
            <select class="form-control mkd-form-element<?php if ($dependence) { echo " dependence"; } ?>"
                <?php foreach($show as $key=>$value) { ?>
                    data-show-<?php echo str_replace(' ', '',$key); ?>="<?php echo esc_attr($value); ?>"
                <?php } ?>
                <?php foreach($hide as $key=>$value) { ?>
                    data-hide-<?php echo str_replace(' ', '',$key); ?>="<?php echo esc_attr($value); ?>"
                <?php } ?>
                    name="<?php echo esc_attr($name); ?>">
                <option <?php if (entre_mikado_option_get_value($name) == "") { echo "selected='selected'"; } ?>  value=""></option>
                <?php foreach($options as $key=>$value) { if ($key == "-1") $key = ""; ?>
                    <option <?php if (entre_mikado_option_get_value($name) == $key) { echo "selected='selected'"; } ?>  value="<?php echo esc_attr($key); ?>"><?php echo esc_html($value); ?></option>
                <?php } ?>
            </select>
		</div>
	<?php
	}
}

class EntreMikadoFieldSelectBlankSimple extends EntreMikadoFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false ) {
        $dependence = false;
        if(isset($args["dependence"])) {
	        $dependence = true;
        }
        
        $show = array();
        if(isset($args["show"])) {
	        $show = $args["show"];
        }
        
        $hide = array();
        if(isset($args["hide"])) {
	        $hide = $args["hide"];
        }
        ?>

		<div class="col-lg-3">
			<em class="mkd-field-description"><?php echo esc_html($label); ?></em>
            <select class="form-control mkd-form-element<?php if ($dependence) { echo " dependence"; } ?>"
                <?php foreach($show as $key=>$value) { ?>
                    data-show-<?php echo str_replace(' ', '',$key); ?>="<?php echo esc_attr($value); ?>"
                <?php } ?>
                <?php foreach($hide as $key=>$value) { ?>
                    data-hide-<?php echo str_replace(' ', '',$key); ?>="<?php echo esc_attr($value); ?>"
                <?php } ?>
                    name="<?php echo esc_attr($name); ?>">
                <option <?php if (entre_mikado_option_get_value($name) == "") { echo "selected='selected'"; } ?>  value=""></option>
                <?php foreach($options as $key=>$value) { if ($key == "-1") $key = ""; ?>
                    <option <?php if (entre_mikado_option_get_value($name) == $key) { echo "selected='selected'"; } ?>  value="<?php echo esc_attr($key); ?>"><?php echo esc_html($value); ?></option>
                <?php } ?>
            </select>
		</div>
	<?php
	}
}

class EntreMikadoFieldYesNo extends EntreMikadoFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false, $repeat = array() ) {
		$switcher_name = $name;

		$class = '';
		$tname = $name;
		if (!empty($repeat)) {
			if(array_key_exists('index', $repeat)) {
				$id = $name . '-' . $repeat['index'];
			} else {
				$id = $name;
			}
			if(array_key_exists('name', $repeat)) {
				$name = $repeat['name'];
				$tname = $repeat['name'];
			}
			$name .= '[]';
			$tname .= '_yesno[]';
			$rvalue = $repeat['value'];
			$class = 'mkd-repeater-field';
		} else {
			$id = $name;
			$rvalue = entre_mikado_option_get_value($name);
		}

		if($label === '' && $description === '') {
			$class .= ' mkd-no-description';
		}

		$dependence = false;
		if(isset($args["dependence"])) {
			$dependence = true;
		}

		$dependence_hide_on_yes = "";
		if(isset($args["dependence_hide_on_yes"])) {
			$dependence_hide_on_yes = $args["dependence_hide_on_yes"];
		}

		$dependence_show_on_yes = "";
		if(isset($args["dependence_show_on_yes"])) {
			$dependence_show_on_yes = $args["dependence_show_on_yes"];
		}
		?>
		
		<div class="mkd-page-form-section <?php echo esc_attr($class); ?>" id="mkd_<?php echo esc_attr($id); ?>">
			<div class="mkd-field-desc">
				<h4><?php echo esc_html($label); ?></h4>
				<p><?php echo esc_html($description); ?></p>
			</div>
			<div class="mkd-section-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<p class="field switch switch-<?php echo esc_attr($switcher_name); ?>">
								<label data-hide="<?php echo esc_attr($dependence_hide_on_yes); ?>" data-show="<?php echo esc_attr($dependence_show_on_yes); ?>"
								       class="cb-enable<?php if ($rvalue == "yes") { echo " selected"; } ?><?php if ($dependence) { echo " dependence"; } ?>"><span><?php esc_html_e('Yes', 'entre') ?></span></label>
								<label data-hide="<?php echo esc_attr($dependence_show_on_yes); ?>" data-show="<?php echo esc_attr($dependence_hide_on_yes); ?>"
								       class="cb-disable<?php if ($rvalue == "no") { echo " selected"; } ?><?php if ($dependence) { echo " dependence"; } ?>"><span><?php esc_html_e('No', 'entre') ?></span></label>
								<input type="checkbox" id="checkbox" class="checkbox"
								       name="<?php echo esc_attr($tname); ?>" value="yes"<?php if ($rvalue == "yes") { echo " checked"; } ?>/>
								<input type="hidden" class="checkboxhidden_yesno" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($rvalue); ?>"/>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

class EntreMikadoFieldYesNoSimple extends EntreMikadoFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false ) {
		$dependence = false;
		if(isset($args["dependence"])) {
			$dependence = true;
		}
		
		$dependence_hide_on_yes = "";
		if(isset($args["dependence_hide_on_yes"])) {
			$dependence_hide_on_yes = $args["dependence_hide_on_yes"];
		}
		
		$dependence_show_on_yes = "";
		if(isset($args["dependence_show_on_yes"])) {
			$dependence_show_on_yes = $args["dependence_show_on_yes"];
		}
		?>

		<div class="col-lg-3">
			<em class="mkd-field-description"><?php echo esc_html($label); ?></em>
			<p class="field switch">
				<label data-hide="<?php echo esc_attr($dependence_hide_on_yes); ?>" data-show="<?php echo esc_attr($dependence_show_on_yes); ?>"
					   class="cb-enable<?php if (entre_mikado_option_get_value($name) == "yes") { echo " selected"; } ?><?php if ($dependence) { echo " dependence"; } ?>"><span><?php esc_html_e('Yes', 'entre') ?></span></label>
				<label data-hide="<?php echo esc_attr($dependence_show_on_yes); ?>" data-show="<?php echo esc_attr($dependence_hide_on_yes); ?>"
					   class="cb-disable<?php if (entre_mikado_option_get_value($name) == "no") { echo " selected"; } ?><?php if ($dependence) { echo " dependence"; } ?>"><span><?php esc_html_e('No', 'entre') ?></span></label>
				<input type="checkbox" id="checkbox" class="checkbox"
					   name="<?php echo esc_attr($name); ?>_yesno" value="yes"<?php if (entre_mikado_option_get_value($name) == "yes") { echo " selected"; } ?>/>
				<input type="hidden" class="checkboxhidden_yesno" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr(entre_mikado_option_get_value($name)); ?>"/>
			</p>
		</div>
	<?php
	}
}

class EntreMikadoFieldOnOff extends EntreMikadoFieldType {
	public function render( $name, $label="", $description="", $options = array(), $args = array(), $hidden = false ) {
		$dependence = false;
		if(isset($args["dependence"])) {
			$dependence = true;
		}
		
		$dependence_hide_on_yes = "";
		if(isset($args["dependence_hide_on_yes"])) {
			$dependence_hide_on_yes = $args["dependence_hide_on_yes"];
		}
		
		$dependence_show_on_yes = "";
		if(isset($args["dependence_show_on_yes"])) {
			$dependence_show_on_yes = $args["dependence_show_on_yes"];
		}
		?>

		<div class="mkd-page-form-section" id="mkd_<?php echo esc_attr($name); ?>">
			<div class="mkd-field-desc">
				<h4><?php echo esc_html($label); ?></h4>
				<p><?php echo esc_html($description); ?></p>
			</div>
			<div class="mkd-section-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<p class="field switch">
								<label data-hide="<?php echo esc_attr($dependence_hide_on_yes); ?>" data-show="<?php echo esc_attr($dependence_show_on_yes); ?>"
									   class="cb-enable<?php if (entre_mikado_option_get_value($name) == "on") { echo " selected"; } ?><?php if ($dependence) { echo " dependence"; } ?>"><span><?php esc_html_e('On', 'entre') ?></span></label>
								<label data-hide="<?php echo esc_attr($dependence_show_on_yes); ?>" data-show="<?php echo esc_attr($dependence_hide_on_yes); ?>"
									   class="cb-disable<?php if (entre_mikado_option_get_value($name) == "off") { echo " selected"; } ?><?php if ($dependence) { echo " dependence"; } ?>"><span><?php esc_html_e('Off', 'entre') ?></span></label>
								<input type="checkbox" id="checkbox" class="checkbox"
									   name="<?php echo esc_attr($name); ?>_onoff" value="on"<?php if (entre_mikado_option_get_value($name) == "on") { echo " selected"; } ?>/>
								<input type="hidden" class="checkboxhidden_onoff" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr(entre_mikado_option_get_value($name)); ?>"/>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
}