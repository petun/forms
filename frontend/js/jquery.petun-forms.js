$.fn.ptmForm = function (options) {

    function supportAjaxUploadProgressEvents() {
        var xhr = new XMLHttpRequest();
        return !! (xhr && ('upload' in xhr) && ('onprogress' in xhr.upload));
    }

    var settings = $.extend({
        'renderTo': '.form-result',
        'successClass': 'form-result__success',
        'errorClass': 'form-result__error',
        'loadingClass': 'form-result__loading',
        'handler': 'handler.php',
        'onSuccess' : function(form){}
    }, options);

    //console.log(settings);

    return this.each(function () {

        var resultDiv = $(settings.renderTo, this);

        $(this).on('submit', function(e){

            var form = this;

            e.preventDefault();

            resultDiv
                .html("")
                .removeClass(settings.successClass)
                .removeClass(settings.errorClass)
                .addClass(settings.loadingClass);


            $.ajax({
                url: settings.handler,
                method: 'post',
                data: supportAjaxUploadProgressEvents() ? new FormData($(this)[0]) : $(this).serialize(),
                dataType: 'json',
                contentType: supportAjaxUploadProgressEvents() ? false : 'application/x-www-form-urlencoded; charset=UTF-8',
                processData: !supportAjaxUploadProgressEvents(),

                success: function(r) {
                    resultDiv.removeClass(settings.loadingClass);
                    resultDiv.html("<p>" + r.message + "</p>");
                    if (r.r) {
                        resultDiv.addClass(settings.successClass);
                        form.reset();

                        settings.onSuccess(form);

                        if (r.redirect) {
                            window.location.replace(r.redirect);
                        }

                    } else {
                        resultDiv.addClass(settings.errorClass);
                        if (r.errors) {
                            var html = resultDiv.html() + '<ul>';
                            for (i in r.errors) {
                                html += "<li>" + r.errors[i] + "</li>";
                            }
                            html += '</ul>';
                            resultDiv.html(html);
                        }
                    }
                }
            });

            return false;
        });


        // plugin block


    });
};