function initQuillEditor(selector, options = {}) {
    const defaultOptions = {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ header: [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ align: [] }],
                ['link', 'code-block'],
                ['clean']
            ]
        }
    };

    const mergedOptions = Object.assign({}, defaultOptions, options);
    return new Quill(selector, mergedOptions);
}

