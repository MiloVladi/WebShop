$(document).ready(function(){
    let view = new productsView();
    view.initProductsEvents();
    let cartsView = new cartView();
    cartsView.initCartEvents();
});

