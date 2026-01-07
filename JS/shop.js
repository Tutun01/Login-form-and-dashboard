$(document).ready(function () {

    $('#category').on('change', function () {
        const selectedCategory = $(this).val();

        $('.blog-card').each(function () {
            const productCategory = $(this).data('category');

            if (selectedCategory === '' || productCategory === selectedCategory) {
                $(this).fadeIn(200);
            } else {
                $(this).fadeOut(200);
            }
        });
    });

});