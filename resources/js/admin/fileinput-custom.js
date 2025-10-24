import $ from 'jquery';

$(function () {
    const $inputs = $('input.file');
    if (!$inputs.length) return;

    $inputs.each(function () {
        const $el = $(this);
        let opts = {};
        const raw = $el.attr('data-fileinput-options');
        if (raw) {
            try {
                opts = JSON.parse(raw);
            } catch (e) {
                console.error('Invalid JSON in data-fileinput-options for', this, e);
            }
        }
        const defaults = {
            showUpload: false,
            showRemove: true
        };

        $el.fileinput(Object.assign({}, defaults, opts));
    });
});
