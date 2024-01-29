@section('custom_styles')
    <link rel="stylesheet" href="{{asset('vendor/quill-snow.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/quill-emoji.css')}}">

    <script src="{{asset('vendor/quill.js')}}"></script>
    <script src="{{asset('vendor/quill-emoji.js')}}"></script>

    <script type="text/javascript">
        var Bold = Quill.import('formats/bold');
        Bold.tagName = 'B';   // Quill uses <strong> by default
        Quill.register(Bold, true);

        var Italic = Quill.import('formats/italic');
        Italic.tagName = 'I';   // Quill uses <strong> by default
        Quill.register(Italic, true);

        var Strike = Quill.import('formats/strike');
        Strike.tagName = 'STRIKE';   // Quill uses <strong> by default
        Quill.register(Strike, true);

        var CodeBlock = Quill.import('formats/code-block');
        CodeBlock.tagName = 'CODE';
        CodeBlock.className = false;
        Quill.register(CodeBlock);

        // var Parchment = Quill.import('parchment');
        // var BlockEmbed = Quill.import('blots/block/embed');
        // class SpoilerBlot extends BlockEmbed {
        //     static blotName = 'tg-spoiler';
        //     static tagName = 'tg-spoiler';
        //
        //     static create(value) {
        //         const node = super.create();
        //         if (value) {
        //             node.innerHTML = value; //('data-value', value);
        //         }
        //         // Optionally, set additional attributes or styles for the custom tag
        //         return node;
        //     }
        //
        //     static formats(node) {
        //         // You can handle any custom attributes here
        //         return node.getAttribute('data-value') || true;
        //     }
        //
        //     format(name, value) {
        //         // Handle custom formatting if needed
        //         if (name === 'tg-spoiler' && value) {
        //             this.domNode.setAttribute('data-value', value);
        //         } else {
        //             super.format(name, value);
        //         }
        //     }
        // }

        let Inline = Quill.import('blots/inline');

        class SpoilerBlot extends Inline {}
        SpoilerBlot.blotName = 'tg-spoiler';
        SpoilerBlot.tagName = 'tg-spoiler';
        Quill.register(SpoilerBlot);

        class CustomCode extends Inline { }
        CustomCode.blotName = 'custom-code';
        CustomCode.tagName = 'CODE';

        class CustomPre extends Inline { }
        CustomPre.blotName = 'custom-pre';
        CustomPre.tagName = 'PRE';

        Quill.register(CustomCode);
        Quill.register(CustomPre);

        // var Block = Quill.import('blots/block');
        // Block.tagName = 'span';
        // Quill.register(Block);

        Quill.register(QuillEmoji, true);

        const toolbarOptions = {
            container: [
                ['bold', 'italic', 'underline', 'strike'],
                [ 'link' ,'emoji', 'custom-code', 'custom-pre'],
                ['tg-spoiler'],
                ['clean'],
            ],
            handlers: {
                'emoji': function () {}
            }
        }

        const quillConfig = {
            modules: {
                "toolbar": toolbarOptions,
                "emoji-toolbar": true,
                "emoji-shortname": true,
                "emoji-textarea": false,
                history: {
                    userOnly: true,
                },
                clipboard: {
                    matchVisual: false,
                },
                keyboard: {
                    // bindings: {
                    //     linebreak: {
                    //         key: 13,  // Enter key
                    //         handler: function(range, context) {
                    //             //this.quill.insertText(range.index, '\n', Quill.sources.USER);
                    //             //this.quill.setSelection(range.index + 1, Quill.sources.USER);
                    //         }
                    //     }
                    // }
                },
            },
            //block: 'span',
            placeholder: 'Введите текст...',
            name: 'caption',
            theme: 'snow',
        };
    </script>
@endsection
@section('custom_scripts')
    <script>
        var quill = new Quill('#editor', quillConfig);

        document.querySelector('.ql-tg-spoiler').innerHTML = "tg-spoiler";
        document.querySelector('.ql-custom-pre').innerHTML = "pre";
        document.querySelector('.ql-custom-code').innerHTML = `<svg viewBox="0 0 18 18"> <polyline class="ql-even ql-stroke" points="5 7 3 9 5 11"></polyline> <polyline class="ql-even ql-stroke" points="13 7 15 9 13 11"></polyline> <line class="ql-stroke" x1="10" x2="8" y1="5" y2="13"></line> </svg>`;
        //document.querySelector('.ql-line-break').innerHTML = "br";
    </script>
@endsection
