<?php $view->extend('AppBundle:Default:layout.html.php'); ?>

<h1>Novo Post</h1>

<form id="form-post">
    <fieldset>
        <div class="field">
            <label>Título</label>
            <div class="field">
                <input type="text" id="title" name="title" />
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="field">
            <label>URL</label>
            <div class="field">
                <input type="text" id="url" name="url" />
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="field">
            <label>Palavras-chave - Separado por vírgula (Exemplo: magento-2, eventos, boas-praticas, dicas-e-truques)</label>
            <div class="field">
                <input type="text" id="tag" name="tag" />
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="field">
            <button type="button" class="button-link" onclick="PostCreate.submit();">Enviar!</button>
        </div>
    </fieldset>
</form>

<script type="text/javascript" src="/js/post/create.js"></script>
