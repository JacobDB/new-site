<!--removeIf(login_html)--><div class="login-block -overlay _noncritical" data-overlay="login" tabindex="0" aria-hidden="true">
    <div class="login_inner">
        <form class="login_login-form login-form" action="<?php echo get_option("home"); ?>/wp-login.php" method="post">
            <h6 class="login-form_title title _textcenter"><?php _e("Already have an account", "@@namespace"); ?>:</h6>

            <div class="login-form_input-container input-container">
                <label class="login-form_text text -label" for="log">
                    <?php _e("Username", "@@namespace"); ?>:
                </label><!--./login-form_text.text.-label-->
                <input class="login-form_input input" type="text" id="log" name="log" />
            </div><!--/.login-form_input-container.input-container-->

            <div class="login-form_input-container input-container">
                <label class="login-form_text text -label" for="pwd">
                    <?php _e("Password", "@@namespace"); ?>:
                </label><!--./login-form_text.text.-label-->
                <input class="login-form_input input" type="password" id="pwd" name="pwd" />
                <p class="login-form_text text -small _textright">
                    <?php if (!empty($_GET["issue"])): ?>
                    <strong class="_bold"><?php _e("Incorrect password. Please try again.", "@@namespace"); ?></strong><br />
                    <?php endif; ?>
                    <a class="login-form_link link" href="<?php echo wp_lostpassword_url(); ?> "><?php _e("Forgot your password?", "@@namespace"); ?></a>
                </p><!--/.login-form_text.text.-small._textright-->
            </div><!--/.login-form_input-container.input-container-->

            <input type="hidden" name="redirect_to" value="<?php echo $_SERVER["REQUEST_URI"]; ?>" />

            <div class="_textcenter">
                <button class="login-form_button button" type="submit"><icon class="arrow-right" /> <?php _e("Sign in", "@@namespace"); ?></button>
            </div><!--/._textcenter-->
        </form><!--/.login_login-form.login-form-->

        <?php if (get_option("users_can_register")): ?>
        <div class="login_login-form login-form -register">
            <h6 class="login-form_title title _textcenter"><?php _e("Interested in Signing Up?", "@@namespace"); ?></h6>

            <div class="_textcenter">
                <a class="login-form_button button" href="<?php echo wp_registration_url(); ?>"><icon class="arrow-right" /> <?php _e("Create your account", "@@namespace"); ?></a>
            </div><!--/._textcenter-->
        </div><!--/.login-form_login-form.login-form.-register-->
        <?php endif; // if (get_option("users_can_register")) ?>

        <button class="login_button button -close" data-overlay="login"><span class="_visuallyhidden"><?php _e("Close the sign in form", "@@namespace"); ?></span></button>
    </div><!--/.login_inner-->
</div><!--/.login-block.-overlay._noncritical--><!--endRemoveIf(login_html)-->
