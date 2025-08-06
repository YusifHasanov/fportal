// Trix Editor Customization - Hide Image Captions
document.addEventListener('DOMContentLoaded', function() {
    // Trix editor'ları bul ve özelleştir
    const trixEditors = document.querySelectorAll('trix-editor');
    
    trixEditors.forEach(function(editor) {
        // Attachment eklendiğinde
        editor.addEventListener('trix-attachment-add', function(event) {
            const attachment = event.attachment;
            
            // Caption'ı boş yap
            if (attachment) {
                attachment.setAttributes({
                    caption: '',
                    filename: ''
                });
            }
        });
        
        // Editor render olduğunda
        editor.addEventListener('trix-render', function() {
            hideAttachmentCaptions(editor);
        });
        
        // Change event'inde de kontrol et
        editor.addEventListener('trix-change', function() {
            setTimeout(() => hideAttachmentCaptions(editor), 100);
        });
        
        // İlk yüklemede de gizle
        setTimeout(() => hideAttachmentCaptions(editor), 500);
    });
    
    function hideAttachmentCaptions(editor) {
        // Tüm caption elementlerini gizle
        const captions = editor.querySelectorAll('.trix-attachment__caption, .trix-attachment__metadata, .trix-attachment__progress');
        captions.forEach(caption => {
            caption.style.display = 'none';
            caption.style.visibility = 'hidden';
            caption.style.height = '0';
            caption.style.overflow = 'hidden';
        });
        
        // Figcaption elementlerini de gizle
        const figcaptions = editor.querySelectorAll('figcaption');
        figcaptions.forEach(figcaption => {
            figcaption.style.display = 'none';
        });
        
        // Data-trix-attachment olan figure'ların text content'ini temizle
        const figures = editor.querySelectorAll('figure[data-trix-attachment]');
        figures.forEach(figure => {
            const textNodes = [];
            const walker = document.createTreeWalker(
                figure,
                NodeFilter.SHOW_TEXT,
                null,
                false
            );
            
            let node;
            while (node = walker.nextNode()) {
                // Dosya adı pattern'ini kontrol et
                if (node.textContent.match(/\w+\.(jpg|jpeg|png|gif|webp)\s*\d+(\.\d+)?\s*(KB|MB|bytes?)/i)) {
                    textNodes.push(node);
                }
            }
            
            textNodes.forEach(textNode => {
                textNode.textContent = '';
            });
        });
    }
});

// CSS ile de gizle
const style = document.createElement('style');
style.textContent = `
    .fi-fo-rich-editor .trix-attachment__caption,
    .fi-fo-rich-editor .trix-attachment__metadata,
    .fi-fo-rich-editor .trix-attachment__progress,
    .fi-fo-rich-editor figcaption,
    trix-editor .trix-attachment__caption,
    trix-editor .trix-attachment__metadata,
    trix-editor .trix-attachment__progress,
    trix-editor figcaption {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        overflow: hidden !important;
    }
`;
document.head.appendChild(style);