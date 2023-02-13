<div class="page-header">
	<h1>Welcome to this eShop</h1>

    <h5>Latest product :</h5>
    <div class="d-flex" style="overflow-x: auto !important">
        {% for p in prod %}
            <div class="m-2 p-4  border border-dark" style="min-width: 12rem, background-image: url("/images/"{{p.picture_url}})">
                {{ link_to("product/page/" ~ p.id, p.name) }}
                <div>{{ link_to("cart/add/" ~ p.id, "Ajouter", "class": "btn btn-success", 'style': 'margin-top: 10em') }}</div>
            </div>

        {% endfor %}
	</div>

</div>
