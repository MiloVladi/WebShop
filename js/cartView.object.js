class cartView {

    constructor() {
        this.$shoppingCart = $('#shoppingCart');
    }

    initCartEvents() {
        let self = this;
        $('#cart').on('click', function () {
            $('#productsliste').empty();
            self.getProductsFromCart();
        });
    }

    getProductsFromCart() {
        this.$shoppingCart.empty()
        let self = this;

        $.ajax({
            url: "api/?action=listCart",
            type: "GET",

            success: function (response) {
                self.fillListCart(response);
                console.log(response);
            },
            error: function (errorData) {
                console.log(errorData);
            }
        });
    }

    fillListCart(products) {

        let $totalListe = '';
        let totalPrice = 0;
        let self = this;
        for (let i in products) {

            let product = products[i];
            let productPrice = product.price * product.amount;
            $totalListe = ("<li>" + "Total Price: " + (Math.round(totalPrice += productPrice) / 100) + "€" + "</li>");
            let $productsListe = ("<ul><li>" + "Name: " + product.name + " " + "Price: " + productPrice + " " + "Amount: " + product.amount + " " + "<button value= '" + product.id + "' class='btn added btn-primary' type='submit'> + </button>" +
                "<button value= '" + product.id + "' class='btn removed btn-primary' type='submit'> - </button>" + "</li></ul>");
            this.$shoppingCart.append($productsListe);

        }
        this.$shoppingCart.append($totalListe);


        $('.removed').on('click', function () {
            self.removeFromCart($(this).attr('value'));
        });
        $('.added').on('click', function () {
            self.addToCart($(this).attr('value'));
        });
    }

    addToCart(articleId) {
        console.log(articleId);
        let self = this;
        $.ajax({
            url: 'api/?action=addArticle&articleId=' + articleId,
            type: "GET",

            success: function (response) {
                self.getProductsFromCart();
                console.log(response);

            },
            error: function (errorData) {
                console.log(errorData);
            }

        });
    }

    removeFromCart(articleId) {
        console.log(articleId);
        let self = this;
        $.ajax({
            url: 'api/?action=removeArticle&articleId=' + articleId,
            type: "GET",

            success: function (response) {
                self.getProductsFromCart();
                console.log(response);

            },
            error: function (errorData) {
                console.log(errorData);
            }

        });
    }


}