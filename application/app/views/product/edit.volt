<div class="page-header">
    <h1>Edit product</h1>
</div>

{{ form('product/save', 'method': 'post') }}

    <div>
        <label for='name'>Name</label>
        {{ text_field('name', 'size': 32) }}
    </div>

    <div>
        <label for='description'>Description</label>
        {{ text_field('description', 'size': 32) }}
    </div>

    <div>
        <label for='stock'>Stock</label>
        {{ text_field('stock', 'size': 32) }}
    </div>

    <div>
        <label for='picture_url'>Picture url</label>
        {{ text_field('picture_url', 'size': 32) }}
    </div>

    <div>
        <label for='id_sub_category'>Categories</label>
        {{ 
            select([
                    'id_sub_category', 
                    id_sub_category, 
                    'using': ['id', 'name'], 
                    'useEmpty': true, 
                    'emptyText': '...', 
                    'emptyValue': ''
                ]
            ) 
        }}
    </div>
        
    <div>
        {{ submit_button('Send') }}
    </div>

{{ end_form() }}
