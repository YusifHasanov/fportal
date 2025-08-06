import './bootstrap';

// Frontend'de resim dosya adlarını temizle
document.addEventListener('DOMContentLoaded', function() {
    // Article content'deki resim dosya adlarını temizle
    const articleContent = document.querySelector('.article-content');
    if (articleContent) {
        cleanImageCaptions(articleContent);
    }
    
    // Tüm content alanlarını temizle
    const contentAreas = document.querySelectorAll('[data-content], .content, .article-content');
    contentAreas.forEach(area => {
        cleanImageCaptions(area);
    });
});

function cleanImageCaptions(container) {
    // Figcaption elementlerini kaldır
    const captions = container.querySelectorAll('figcaption');
    captions.forEach(caption => caption.remove());
    
    // Trix attachment caption'larını kaldır
    const trixCaptions = container.querySelectorAll('.trix-attachment__caption, .trix-attachment__metadata, .trix-attachment__progress');
    trixCaptions.forEach(caption => caption.remove());
    
    // Figure elementlerindeki text node'ları temizle
    const figures = container.querySelectorAll('figure[data-trix-attachment], figure');
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
            textNode.remove();
        });
    });
    
    // P etiketlerindeki dosya adlarını temizle
    const paragraphs = container.querySelectorAll('p');
    paragraphs.forEach(p => {
        if (p.textContent.match(/^\s*\w+\.(jpg|jpeg|png|gif|webp)\s*\d+(\.\d+)?\s*(KB|MB|bytes?)\s*$/i)) {
            p.remove();
        }
    });
}
