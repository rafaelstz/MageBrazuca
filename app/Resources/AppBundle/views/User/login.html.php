<?php $view->extend('AppBundle:Default:layout.html.php'); ?>

<h1>Login</h1>

<form id="form-login" action="/user/login" method="post">
    <fieldset>
        <div class="field field-one">
            <label>Usuário</label>
            <div class="field">
                <input type="text" id="username" name="username" />
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="field field-two">
            <label>Senha</label>
            <div class="field">
                <input type="password" id="password" name="password" />
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="field">
            <button type="submit" class="button-link">Entrar!</button>
        </div>
    </fieldset>
</form>
