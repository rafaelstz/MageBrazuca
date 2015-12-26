<?php
/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
?>

<?php $view->extend('AppBundle:Default:layout.html.php'); ?>

<h1>Cadastro</h1>

<form id="form-user">
    <h2>Informações Gerais</h2>
    <fieldset>
        <div class="field field-one">
            <label>Nome <span class="field-required">*</span></label>
            <div class="field">
                <input type="text" id="firstname" name="firstname" />
            </div>
        </div>
        <div class="field field-two">
            <label>Sobrenome <span class="field-required">*</span></label>
            <div class="field">
                <input type="text" id="lastname" name="lastname" />
            </div>
        </div>
        <div class="field field-three">
            <label>Sexo <span class="field-required">*</span></label>
            <div class="field">
                <select name="gender" id="gender">
                    <option value="<?php echo \AppBundle\Entity\User::GENDER_MALE; ?>">Masculino</option>
                    <option value="<?php echo \AppBundle\Entity\User::GENDER_FEMALE; ?>">Feminino</option>
                </select>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="field field-one">
            <label>Usuário <span class="field-required">*</span></label>
            <div class="field">
                <input type="text" id="username" name="username" />
            </div>
        </div>
        <div class="field field-two">
            <label>Senha <span class="field-required">*</span></label>
            <div class="field">
                <input type="password" id="password" name="password" />
            </div>
        </div>
        <div class="field field-three">
            <label>Email <span class="field-required">*</span></label>
            <div class="field">
                <input type="text" id="email" name="email" />
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="field field-one">
            <label>Localização - Cidade e Estado <span class="field-required">*</span></label>
            <div class="field">
                <input type="text" id="location" name="location" placeholder="" />
                <input type="hidden" name="location_city_short" id="location-city-short-value" />
                <input type="hidden" name="location_city_long" id="location-city-long-value" />
                <input type="hidden" name="location_state_short" id="location-state-short-value" />
                <input type="hidden" name="location_state_long" id="location-state-long-value" />
                <input type="hidden" name="location_country_short" id="location-country-short-value" />
                <input type="hidden" name="location_country_long" id="location-country-long-value" />
            </div>
        </div>
        <div class="field field-two">
            <label>Empresa</label>
            <div class="field">
                <input type="text" id="company" name="company" />
            </div>
        </div>
        <div class="field field-three">
            <label>Está disponível para contratação? <span class="field-required">*</span></label>
            <div class="field">
                <select name="is_available_to_hiring" id="is-available-to-hiring">
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="field field-one">
            <label>Foto de Perfil</label>
            <div class="field">
                <input type="file" name="picture" id="picture" />
            </div>
        </div>
        <div id="user-create-field-about">
            <label>Sobre você (140 caracteres)</label>
            <div class="field">
                <textarea name="about" id="about"></textarea>
            </div>
        </div>
    </fieldset>
    <h2 id="user-create-subtitle-contact-links">Contatos</h2>
    <fieldset>
        <div class="field field-one">
            <label>Site Pessoal / Blog (URL completa)</label>
            <div class="field">
                <input type="text" id="contact-website" name="contact_website" />
            </div>
        </div>
        <div class="field field-two">
            <label>Twitter (apenas @exemplo)</label>
            <div class="field">
                <input type="text" id="contact-twitter" name="contact_twitter" />
            </div>
        </div>
        <div class="field field-three">
            <label>LinkedIn (URL completa)</label>
            <div class="field">
                <input type="text" id="contact-linkedin" name="contact_linkedin" />
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="field field-one">
            <label>GitHub Account (apenas @exemplo)</label>
            <div class="field">
                <input type="text" id="contact-github" name="contact_github" />
            </div>
        </div>
        <div class="field field-two">
            <label>StackOverflow (URL completa)</label>
            <div class="field">
                <input type="text" id="contact-stackoverflow" name="contact_stackoverflow" />
            </div>
        </div>
        <div class="field field-three">
            <label>Certificação (URL completa)</label>
            <div class="field">
                <input type="text" id="contact-certification" name="contact_certification" />
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="field">
            <button type="button" class="button-link" onclick="UserCreateAndEdit.submit();">Enviar!</button>
        </div>
    </fieldset>
</form>

<script type="text/javascript" src="/js/user/create-and-edit.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places&language=pt"></script>

<script>
    $(document).ready(function(){
        UserCreateAndEdit.addGoogleMapsAutoComplete();
    });
</script>
