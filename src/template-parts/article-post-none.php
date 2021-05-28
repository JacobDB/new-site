<?php
$class = isset($this->vars["class"]) ? " {$this->vars["class"]}" : "";
$light = isset($this->vars["light"]) ? $this->vars["light"] : false;
$error = isset($this->vars["error"]) ? $this->vars["error"] : false;
?>

<?php if ($error): ?>
    <article class="article article--post-none<?php echo $class; ?>">
        <div class="article__content">
            <p class="article__text text<?php if ($light): ?> __light<?php endif; ?>"><?php echo $error; ?></p>
        </div>
    </article>
<?php endif; ?>
