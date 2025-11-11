// js/point_tracker.js
async function awardPoints(contentId, contentType, progress) {
    const formData = new FormData();
    formData.append('content_id', contentId);
    formData.append('content_type', contentType);
    formData.append('progress', progress);

    const res = await fetch('includes/award_points.php', {
        method: 'POST',
        body: formData
    });
    const data = await res.json();

    if (data.success && data.points) {
        if (typeof showPointPopup === 'function') {
            showPointPopup(data.points);
        }
    }
}

// === SCROLL ARTIKEL ===
document.addEventListener('DOMContentLoaded', () => {
    const article = document.getElementById('article-content');
    if (!article) return;

    let maxScroll = 0;
    const articleId = article.dataset.contentId;

    window.addEventListener('scroll', () => {
        const rect = article.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        const visible = windowHeight - rect.top;
        const total = rect.height + windowHeight;
        const scrolled = (visible / total) * 100;
        maxScroll = Math.max(maxScroll, scrolled);

        if (maxScroll >= 98 && !localStorage.getItem(`article_${articleId}`)) {
            localStorage.setItem(`article_${articleId}`, 'true');
            awardPoints(articleId, 'article', 100);
        }
    });
});

// === VIDEO YouTube ===
let player;
function onYouTubeIframeAPIReady() {
    const iframe = document.getElementById('youtube-video');
    if (!iframe) return;

    player = new YT.Player('youtube-video', {
        events: {
            'onStateChange': (event) => {
                if (event.data === YT.PlayerState.ENDED) {
                    const videoId = document.querySelector('.video').dataset.contentId;
                    if (!localStorage.getItem(`video_${videoId}`)) {
                        localStorage.setItem(`video_${videoId}`, 'true');
                        awardPoints(videoId, 'video', 100);
                    }
                }
            }
        }
    });
}

// Load YouTube API
const tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
const firstScript = document.getElementsByTagName('script')[0];
firstScript.parentNode.insertBefore(tag, firstScript);