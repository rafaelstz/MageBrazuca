<?php
/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
?>

<?php $view->extend('AppBundle:Default:layout.html.php'); ?>

<h1>Edição</h1>

<form id="form-user">
    <h2>Informações Gerais</h2>
    <fieldset>
        <div class="field field-one">
            <label>Nome <span class="field-required">*</span></label>
            <div class="field">
                <input type="text" id="firstname" name="firstname" <?php if ($user->getFirstname()) : ?>value="<?php echo $user->getFirstname(); ?>"<?php endif; ?>/>
            </div>
        </div>
        <div class="field field-two">
            <label>Sobrenome <span class="field-required">*</span></label>
            <div class="field">
                <input type="text" id="lastname" name="lastname" <?php if ($user->getLastname()) : ?>value="<?php echo $user->getLastname(); ?>"<?php endif; ?>/>
            </div>
        </div>
        <div class="field field-three">
            <label>Sexo <span class="field-required">*</span></label>
            <div class="field">
                <select name="gender" id="gender">
                    <option value="<?php echo \AppBundle\Entity\User::GENDER_MALE; ?>" <?php if ($user->getGender() == \AppBundle\Entity\User::GENDER_MALE) : ?>selected="selected"<?php endif; ?>>Masculino</option>
                    <option value="<?php echo \AppBundle\Entity\User::GENDER_FEMALE; ?>" <?php if ($user->getGender() == \AppBundle\Entity\User::GENDER_FEMALE) : ?>selected="selected"<?php endif; ?>>Feminino</option>
                </select>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="field field-one">
            <label>Usuário <span class="field-required">*</span></label>
            <div class="field">
                <input type="text" id="username" name="username" <?php if ($user->getUsername()) : ?>value="<?php echo $user->getUsername(); ?>"<?php endif; ?>/>
            </div>
        </div>
        <div class="field field-two">
            <label>Senha (preencha apenas se desejar trocar)</label>
            <div class="field">
                <input type="password" id="password" name="password" />
            </div>
        </div>
        <div class="field field-three">
            <label>Email <span class="field-required">*</span></label>
            <div class="field">
                <input type="text" id="email" name="email" <?php if ($user->getEmail()) : ?>value="<?php echo $user->getEmail(); ?>"<?php endif; ?>/>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="field field-one">
            <label>Localização - Cidade e Estado <span class="field-required">*</span></label>
            <div class="field">
                <input type="text" id="location" name="location" placeholder="" <?php if ($user->getLocation()) : ?>value="<?php echo $user->getLocation(); ?>"<?php endif; ?>/>
                <input type="hidden" name="location_city_short" id="location-city-short-value" <?php if ($user->getLocationCityShort()) : ?>value="<?php echo $user->getLocationCityShort(); ?>"<?php endif; ?>/>
                <input type="hidden" name="location_city_long" id="location-city-long-value" <?php if ($user->getLocationCityLong()) : ?>value="<?php echo $user->getLocationCityLong(); ?>"<?php endif; ?>/>
                <input type="hidden" name="location_state_short" id="location-state-short-value" <?php if ($user->getLocationStateShort()) : ?>value="<?php echo $user->getLocationStateShort(); ?>"<?php endif; ?>/>
                <input type="hidden" name="location_state_long" id="location-state-long-value" <?php if ($user->getLocationStateLong()) : ?>value="<?php echo $user->getLocationStateLong(); ?>"<?php endif; ?>/>
                <input type="hidden" name="location_country_short" id="location-country-short-value" <?php if ($user->getLocationCountryShort()) : ?>value="<?php echo $user->getLocationCountryShort(); ?>"<?php endif; ?>/>
                <input type="hidden" name="location_country_long" id="location-country-long-value" <?php if ($user->getLocationCountryLong()) : ?>value="<?php echo $user->getLocationCountryLong(); ?>"<?php endif; ?>/>
            </div>
        </div>
        <div class="field field-two">
            <label>Empresa</label>
            <div class="field">
                <input type="text" id="company" name="company" <?php if ($user->getCompany()) : ?>value="<?php echo $user->getCompany(); ?>"<?php endif; ?>/>
            </div>
        </div>
        <div class="field field-three">
            <label>Está disponível para contratação? <span class="field-required">*</span></label>
            <div class="field">
                <select name="is_available_to_hiring" id="is-available-to-hiring">
                    <option value="1"<?php if ($user->getGender() == 1) : ?>selected="selected"<?php endif; ?>>Sim</option>
                    <option value="0"<?php if ($user->getGender() == 0) : ?>selected="selected"<?php endif; ?>>Não</option>
                </select>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="field field-one">
            <label>Foto de Perfil<br />(preencha apenas se desejar atualizar)</label>
            <div class="field">
                <input type="file" name="picture" id="picture" />
            </div>
        </div>
        <div id="user-create-field-about">
            <label>Sobre você (140 caracteres)</label>
            <div class="field">
                <textarea name="about" id="about"><?php if ($user->getAbout()) : echo $user->getAbout(); endif; ?></textarea>
            </div>
        </div>
    </fieldset>
    <h2 id="user-create-subtitle-contact-links">Contatos</h2>
    <fieldset>
        <div class="field field-one">
            <label>Site Pessoal / Blog (URL completa)</label>
            <div class="field">
                <input type="text" id="contact-website" name="contact_website" <?php if ($user->getContactWebsite()) : ?>value="<?php echo $user->getContactWebsite(); ?>"<?php endif; ?>/>
            </div>
        </div>
        <div class="field field-two">
            <label>Twitter (apenas @exemplo)</label>
            <div class="field">
                <input type="text" id="contact-twitter" name="contact_twitter" <?php if ($user->getContactTwitter()) : ?>value="<?php echo $user->getContactTwitter(); ?>"<?php endif; ?>/>
            </div>
        </div>
        <div class="field field-three">
            <label>LinkedIn (URL completa)</label>
            <div class="field">
                <input type="text" id="contact-linkedin" name="contact_linkedin" <?php if ($user->getContactLinkedin()) : ?>value="<?php echo $user->getContactLinkedin(); ?>"<?php endif; ?>/>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="field field-one">
            <label>GitHub Account (apenas @exemplo)</label>
            <div class="field">
                <input type="text" id="contact-github" name="contact_github" <?php if ($user->getContactGithub()) : ?>value="<?php echo $user->getContactGithub(); ?>"<?php endif; ?>/>
            </div>
        </div>
        <div class="field field-two">
            <label>StackOverflow (URL completa)</label>
            <div class="field">
                <input type="text" id="contact-stackoverflow" name="contact_stackoverflow" <?php if ($user->getContactStackOverflow()) : ?>value="<?php echo $user->getContactStackOverflow(); ?>"<?php endif; ?>/>
            </div>
        </div>
        <div class="field field-three">
            <label>Certificação (URL completa)</label>
            <div class="field">
                <input type="text" id="contact-certification" name="contact_certification" <?php if ($user->getContactCertification()) : ?>value="<?php echo $user->getContactCertification(); ?>"<?php endif; ?>/>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="field">
            <button type="button" class="button-link" onclick="UserCreateAndEdit.submit(true);">Enviar!</button>
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
