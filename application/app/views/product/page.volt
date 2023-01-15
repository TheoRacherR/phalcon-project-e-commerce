<div class="page-header">
    <div>
        {{ link_to( "product", "Go Back") }}
    </div>
    <div>
        {{ link_to("product/new", "New Product") }}
    </div>
    <div>
        {{ link_to("product/edit/" ~ prod.id, "Edit this Product") }}
    </div>
    <div>
        {{ link_to("product/delete/" ~ prod.id, "Delete this Product") }}
    </div>
    <h1>Product page</h1>
</div>

{{ content() }}

{% block content %}


    <p>Product id : {{ prod.id }}</p>
    <p>Product owner : {{ owner }}</p>
    <p>Product category : {{  category }} </p>
    <p>Product sub_category : {{  sub_category }} </p>
    <p>Product name : {{  prod.name }} </p>
    <p>Product description : {{  prod.description }} </p>
    <p>Product stock : {{  prod.stock }} </p>
    <p>Product photo : </p><img src={{prod.picture_url}} alt="image of the product">


{# Etape VII - B #}
    <h3>Reviews :</h3>
    {%- if reviews|length == 0 -%}
        <p>Soyer le premier à donner votre avis...</p>
    {%- else -%}
        {%- for review in reviews -%}
            <p>De: {{ review.id_account.username }} </p>
            <p>Commentaire: {{ review.comment }} </p>
            <p>{{ review.nb_star }}/5 </p>
            <p>Le: {{ review.created_at }} </p>
        {%- endfor -%}
    {%- endif -%}
{# Etape VII - B #}


{% endblock %}