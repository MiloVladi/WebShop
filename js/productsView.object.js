class productsView {

    constructor() {
        this.$categoryListe = $('#categoryliste');
        this.$productsListe = $('#productsliste');
    }

    initProductsEvents() {
        let self = this;
        jQuery(document).ready(function ($) {
            self.getProductCategory();
        });

    }

    getProductCategory() {
        let self = this;

        $.ajax({
            url: "api/?action=listTypes",
            type: "GET",

            success: function (response) {
                self.fillCategoryList(response);

            },
            error: function (errorData) {
                console.log(errorData);
            }
        });

    }

    fillCategoryList(productCategory) {

        let self = this;

        for (let i in productCategory) {
            let productCategoryElement = productCategory[i];
            let $ul = $("<li><a class='dropdown-item' value = '" + productCategoryElement.id + "' href='#'>" + productCategoryElement.name + "</a></li>");

            $($ul).on('click', function () {
                self.loadProducts(productCategoryElement.id);

            });


            this.$categoryListe.append($ul);


        }
    }

    loadProducts(typeId) {
        this.emptyListe(this.$productsListe);

        let self = this;
        $.ajax({
            url: 'api/?action=listProductsByTypeId&typeId=' + typeId,
            type: "GET",

            success: function (response) {
                self.fillProductsList(response);

            },
            error: function (errorData) {
                console.log(errorData);
            }


        });


    }

    fillProductsList(products) {
        let self = this;
        for (let i in products) {
            let product = products[i];
            let $ul = $('<ul></ul>');

            $ul.append("<li>" + product.productName + "<button title='" + product.productName + "' value= '" + product.id + "' class='btn added btn-primary' type='submit' data-bs-toggle='modal' data-bs-target='#addToCartModal'> + </button>" + "</li>");


            this.$productsListe.append($ul);
        }
        $('.added').on('click', function () {
            self.addToCart($(this).attr('value'));
            self.addToModal($(this).attr('title'));
        });

    }

    addToModal(productName) {
        let added = $('#added');
        added.empty();
        added.append(productName + ' wurde bestellt');
    }

    addToCart(articleId) {
        console.log(articleId);
        let self = this;
        $.ajax({
            url: 'api/?action=addArticle&articleId=' + articleId,
            type: "GET",

            success: function (response) {
                console.log(response);

            },
            error: function (errorData) {
                console.log(errorData);
            }

        });

    }

    emptyListe($liste) {
        $liste.empty();
    }

}

