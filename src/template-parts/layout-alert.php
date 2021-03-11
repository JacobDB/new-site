<?php
$class       = isset($this->vars["class"]) ? $this->vars["class"] : "";
$block_class = gettype($class) === "array" && key_exists("block", $class) ? " {$class["block"]}" : (gettype($class) === "string" ? " {$class}" : "");
$inner_class = gettype($class) === "array" && key_exists("inner", $class) ? " {$class["inner"]}" : "";
$content     = isset($this->vars["content"]) ? $this->vars["content"] : __gulp_init_namespace___get_field("content", "alert");
?>

<?php if ($content): ?>
    <div class="alert-block<?php echo esc_attr($block_class); ?>">
        <div class="alert__inner<?php echo esc_attr($inner_class); ?>">
            <div class="alert__row row row--padded row--direction-reverse">

                <div class="col-12 col-xs-auto col--grow-0 col--shrink-0 __textright">
                    <button class="alert__button button">
                        <i class="button__icon fa-fw fas fa-times"></i>
                        <span class="__visuallyhidden"><?php _e("Dismiss Alert", "__gulp_init_namespace__"); ?></span>
                    </button>
                </div>

                <div class="col-12 col-xs-0">
                    <div class="alert__user-content user-content user-content--light">
                        <?php echo $content; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php endif; ?>
