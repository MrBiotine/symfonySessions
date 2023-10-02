<div class="form-group row ">
        <div class="col-form-label col-sm-2">&nbsp;</div>
        <div id="programme-fields-list" class="col-sm-10 remove-collection-widget"
            data-prototype="{{ form_widget(form.programmes.vars.prototype)|e }}"
            data-session="{{sessionId}}"
            data-widget-tags="{{ '<p></p>'|e }}"
            data-widget-counter="{{ form.programmes|length }}">
        {% for programmeField in form.programmes %}
            <p>
                {{ form_errors(programmeField) }}
                {{ form_widget(programmeField, {'attr': {'class': 'borders'}}) }}
            </p>
        {% endfor %}
        </div>
    </div>
    <div class="form-group row flex-action">
        <button type="button" 
            class="add-another-collection-widget button"
            data-list-selector="#programme-fields-list">Ajouter un nouveau module</button>
    </div>

 

    {# empêche l'apparition d'une légende "programmes", si la collection est vide (en cas de création d'une nouvelle session) #}
    {% do form.programmes.setRendered %}