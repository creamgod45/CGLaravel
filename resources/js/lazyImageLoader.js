
function lazyImageLoader() {
    /** First we get all the non-loaded image elements **/
    let lazyImages = document.querySelectorAll(".lazy-loaded-image");
    let lazyImg = document.querySelectorAll(".lazyImg");
    /** Then we set up a intersection observer watching over those images and whenever any of those becomes visible on the view then replace the placeholder image with actual one, remove the non-loaded class and then unobserve for that element **/
    let lazyImageObserver = new IntersectionObserver(function (entries, observer) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                let lazyImage = entry.target;
                //console.log(entry);
                //console.log(lazyImage);
                lazyImage.style.backgroundImage = `url(${lazyImage.dataset.src})`;
            }
        });
    });

    for (let lazyImage of lazyImages) {
        lazyImageObserver.observe(lazyImage);
    }

    for (let lazyImgElement of lazyImg) {
        lazyImageObserver.observe(lazyImgElement);
    }
}

document.addEventListener('init', lazyImageLoader);
//document.addEventListener('DOMContentLoaded', lazyImageLoader);
