$(document).ready(function () {
    const $users = $("#allUser");
    const $addUser = $("#addNewUser");
    const $products = $("#allProducts");
    const $addProduct = $("#addNewProduct");

    const $btnUsers = $("#displayAllUser");
    const $btnAddUser = $("#addUser");
    const $btnProducts = $("#displayProducts");
    const $btnAddProduct = $("#addProduct");

    $users.hide();
    $addUser.hide();
    $products.hide();
    $addProduct.hide();

    function setButtons(enabled) {
        $btnUsers.prop("disabled", !enabled);
        $btnAddUser.prop("disabled", !enabled);
        $btnProducts.prop("disabled", !enabled);
        $btnAddProduct.prop("disabled", !enabled);
    }

    function clearActive() {
        $btnUsers.removeClass("is-active");
        $btnAddUser.removeClass("is-active");
        $btnProducts.removeClass("is-active");
        $btnAddProduct.removeClass("is-active");
    }

    function closeAll() {
        $users.hide();
        $addUser.hide();
        $products.hide();
        $addProduct.hide();
        $("body").removeClass("panel-open");
        setButtons(true);
        clearActive();
    }

    function openPanel($panel, $btn) {
        $users.hide();
        $addUser.hide();
        $products.hide();
        $addProduct.hide();

        $("body").addClass("panel-open");
        $panel.fadeIn(200);

        setButtons(false);
        $btn.prop("disabled", false);
        clearActive();
        $btn.addClass("is-active");
    }

    $btnUsers.on("click", function () {
        if ($users.is(":visible")) closeAll();
        else openPanel($users, $btnUsers);
    });

    $btnAddUser.on("click", function () {
        if ($addUser.is(":visible")) closeAll();
        else openPanel($addUser, $btnAddUser);
    });

    $btnProducts.on("click", function () {
        if ($products.is(":visible")) closeAll();
        else openPanel($products, $btnProducts);
    });

    $btnAddProduct.on("click", function () {
        if ($addProduct.is(":visible")) closeAll();
        else openPanel($addProduct, $btnAddProduct);
    });
});
