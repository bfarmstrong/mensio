const SignaturePad = require('signature_pad').default;

const canvas = window.$('canvas.signature-pad');
if (canvas[0]) {
    const signaturePad = new SignaturePad(canvas[0]);

    function onResize() {
        canvas.attr('width', canvas.parent().width());
    }

    window.$(window).resize(onResize);
    onResize();

    canvas.parents('form').on('submit', function () {
        const input = window.$('input[name="signature_base64"]');
        if (!signaturePad.isEmpty()) {
            input.val(signaturePad.toDataURL().split(',')[1]);
        }
        return true;
    });
}
