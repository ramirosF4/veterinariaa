document.addEventListener('DOMContentLoaded', function() {
    var editorContainer = document.getElementById('editor-container');
    if (!editorContainer) return;

    var quill = new Quill('#editor-container', {
        theme: 'snow',
        placeholder: editorContainer.dataset.placeholder || 'Escriba detalladamente aquí...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['clean']
            ]
        }
    });

    var form = editorContainer.closest('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            var inputTargetId = editorContainer.dataset.inputTarget;
            if (inputTargetId) {
                var input = document.getElementById(inputTargetId);
                if (input) {
                    input.value = quill.root.innerHTML;
                }
            }
        });
    }
});
