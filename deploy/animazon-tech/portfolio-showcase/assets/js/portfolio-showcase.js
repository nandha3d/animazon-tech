(function ($) {
    'use strict';

    // Global gallery array for image viewing
    let currentGallery = [];
    let currentGalleryIndex = 0;

    // Modal functions for website/app preview
    window.openPortfolioModal = function (title, url, type) {
        const modal = $('#portfolioModalContainer');
        const overlay = $('#portfolioModalOverlay');
        const modalTitle = $('#portfolioModalTitle');
        const modalBody = $('#portfolioModalBody');
        const externalLink = $('#portfolioExternalLink');

        modalTitle.text(title);
        externalLink.attr('href', url);

        if (type === 'video') {
            // Extract YouTube video ID
            const videoId = extractYouTubeID(url);
            if (videoId) {
                modalBody.html(`
                    <div class="video-container">
                        <iframe 
                            src="https://www.youtube.com/embed/${videoId}?autoplay=1" 
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            title="${title}">
                        </iframe>
                    </div>
                `);
            }
        } else {
            modalBody.html(`
                <div class="video-container type-web">
                    <iframe 
                        src="${url}" 
                        frameborder="0"
                        loading="lazy"
                        sandbox="allow-scripts allow-same-origin allow-forms allow-popups allow-popups-to-escape-sandbox"
                        title="${title}">
                    </iframe>
                </div>
            `);
        }

        modal.addClass('active');
        overlay.addClass('active');
        $('body').css('overflow', 'hidden');
    };

    window.closePortfolioModal = function () {
        const modal = $('#portfolioModalContainer');
        const overlay = $('#portfolioModalOverlay');
        const modalBody = $('#portfolioModalBody');

        modal.removeClass('active');
        overlay.removeClass('active');
        $('body').css('overflow', '');

        setTimeout(function () {
            modalBody.html('<div class="portfolio-loading">Loading preview...</div>');
        }, 300);
    };

    // Open Gallery Modal
    window.openGalleryModal = function (images, startIndex) {
        currentGallery = images;
        currentGalleryIndex = startIndex;

        const galleryModal = $('#portfolioGalleryModal');
        galleryModal.addClass('active');
        $('body').css('overflow', 'hidden');

        showGalleryImage(currentGalleryIndex);
    };

    window.closeGalleryModal = function () {
        $('#portfolioGalleryModal').removeClass('active');
        $('body').css('overflow', '');
        currentGallery = [];
        currentGalleryIndex = 0;
    };

    window.nextGalleryImage = function () {
        currentGalleryIndex = (currentGalleryIndex + 1) % currentGallery.length;
        showGalleryImage(currentGalleryIndex);
    };

    window.prevGalleryImage = function () {
        currentGalleryIndex = (currentGalleryIndex - 1 + currentGallery.length) % currentGallery.length;
        showGalleryImage(currentGalleryIndex);
    };

    function showGalleryImage(index) {
        const img = currentGallery[index];
        $('#galleryModalImage').attr('src', img);
        $('#galleryCounter').text(`${index + 1} / ${currentGallery.length}`);
    }

    // Extract YouTube Video ID
    function extractYouTubeID(url) {
        const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
        const match = url.match(regExp);
        return (match && match[7].length == 11) ? match[7] : false;
    }

    $(document).ready(function () {
        // Category filter
        $('.filter-btn').on('click', function () {
            const filter = $(this).data('filter');
            const filterType = $(this).data('filter-type');

            // Update active state for this filter group
            if (filterType) {
                $(`.filter-btn[data-filter-type="${filterType}"]`).removeClass('active');
            } else {
                $('.filter-btn:not([data-filter-type])').removeClass('active');
            }
            $(this).addClass('active');

            // Get active filters
            const categoryFilter = $('.filter-btn[data-filter-type="category"].active').data('filter') || 'all';
            const typeFilter = $('.filter-btn[data-filter-type="type"].active').data('filter') || 'all';

            // Apply filters
            $('.portfolio-card').each(function () {
                const card = $(this);
                const cardCategories = card.data('category') ? card.data('category').toString().split(' ') : [];
                const cardType = card.data('type');

                let showCard = true;

                // Check category filter
                if (categoryFilter !== 'all') {
                    showCard = cardCategories.includes(categoryFilter);
                }

                // Check type filter
                if (showCard && typeFilter !== 'all') {
                    showCard = (cardType === typeFilter);
                }

                if (showCard) {
                    card.fadeIn(300);
                } else {
                    card.fadeOut(300);
                }
            });
        });

        // Close modal on overlay click
        $('#portfolioModalOverlay').on('click', function () {
            closePortfolioModal();
        });

        // Close modal on Escape key
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') {
                closePortfolioModal();
                closeGalleryModal();
            }

            // Gallery navigation with arrow keys
            if ($('#portfolioGalleryModal').hasClass('active')) {
                if (e.key === 'ArrowRight') {
                    nextGalleryImage();
                } else if (e.key === 'ArrowLeft') {
                    prevGalleryImage();
                }
            }
        });

        // Prevent modal close when clicking inside
        $('#portfolioModalContainer').on('click', function (e) {
            e.stopPropagation();
        });

        // Gallery item click handler
        $('.portfolio-gallery-grid').on('click', '.gallery-thumb', function () {
            const images = [];
            const clickedIndex = $(this).data('index');

            $(this).closest('.portfolio-gallery-grid').find('.gallery-thumb').each(function () {
                images.push($(this).data('full-url'));
            });

            openGalleryModal(images, clickedIndex);
        });

        // View more gallery button
        $('.view-gallery-btn').on('click', function (e) {
            e.preventDefault();
            const images = $(this).data('images');
            if (images && images.length > 0) {
                openGalleryModal(images, 0);
            }
        });

        // Video gallery carousel (if implemented)
        $('.video-carousel-btn').on('click', function () {
            const videos = $(this).closest('.portfolio-info').data('videos');
            const videoIndex = $(this).data('video-index') || 0;

            if (videos && videos[videoIndex]) {
                const video = videos[videoIndex];
                openPortfolioModal(video.title || 'Video Preview', video.url, 'video');
            }
        });

        // Smooth scroll animation for portfolio cards
        $('.portfolio-card').each(function (index) {
            $(this).css({
                'opacity': '0',
                'transform': 'translateY(30px)'
            });

            setTimeout(() => {
                $(this).css({
                    'transition': 'opacity 0.5s ease, transform 0.5s ease',
                    'opacity': '1',
                    'transform': 'translateY(0)'
                });
            }, index * 50);
        });

        // Horizontal Gallery Scroll Navigation
        $('.gallery-arrow').on('click', function () {
            const targetId = $(this).data('target');
            const $gallery = $('#' + targetId);
            const $track = $gallery.find('.portfolio-gallery-track');

            if (!$gallery.length) return;

            const scrollAmount = 300; // Scroll by card width + gap
            const currentScroll = $gallery.scrollLeft();
            const isNext = $(this).hasClass('gallery-arrow-next');

            const newScroll = isNext
                ? currentScroll + scrollAmount
                : currentScroll - scrollAmount;

            $gallery.animate({
                scrollLeft: newScroll
            }, 300);
        });

        // Update arrow states on scroll
        $('.portfolio-gallery-scroll').on('scroll', function () {
            const $this = $(this);
            const scrollLeft = $this.scrollLeft();
            const maxScroll = $this[0].scrollWidth - $this[0].clientWidth;
            const galleryId = $this.attr('id');

            const $prevBtn = $(`.gallery-arrow-prev[data-target="${galleryId}"]`);
            const $nextBtn = $(`.gallery-arrow-next[data-target="${galleryId}"]`);

            $prevBtn.prop('disabled', scrollLeft <= 0);
            $nextBtn.prop('disabled', scrollLeft >= maxScroll - 5);
        });

        // Initialize arrow states
        $('.portfolio-gallery-scroll').trigger('scroll');

        // ===================================
        // IN-CARD APP GALLERY CAROUSEL
        // ===================================

        // Navigate to specific slide
        function goToSlide($carousel, index) {
            const $slides = $carousel.find('.app-gallery-slide');
            const $dots = $carousel.find('.app-gallery-dot');
            const totalSlides = $slides.length;

            // Wrap around
            if (index < 0) index = totalSlides - 1;
            if (index >= totalSlides) index = 0;

            $slides.removeClass('active');
            $dots.removeClass('active');

            $slides.eq(index).addClass('active');
            $dots.eq(index).addClass('active');

            $carousel.data('current-index', index);
        }

        // Previous button click
        $(document).on('click', '.app-gallery-prev', function (e) {
            e.stopPropagation();
            const $carousel = $(this).closest('.app-gallery-carousel');
            const currentIndex = $carousel.data('current-index') || 0;
            goToSlide($carousel, currentIndex - 1);
        });

        // Next button click
        $(document).on('click', '.app-gallery-next', function (e) {
            e.stopPropagation();
            const $carousel = $(this).closest('.app-gallery-carousel');
            const currentIndex = $carousel.data('current-index') || 0;
            goToSlide($carousel, currentIndex + 1);
        });

        // Dot click
        $(document).on('click', '.app-gallery-dot', function (e) {
            e.stopPropagation();
            const $carousel = $(this).closest('.app-gallery-carousel');
            const index = $(this).data('index');
            goToSlide($carousel, index);
        });

        // Initialize carousels
        $('.app-gallery-carousel').each(function () {
            $(this).data('current-index', 0);
        });

        // Auto-play always active (continuous slideshow)
        let autoPlayIntervals = {};

        function startAutoPlay($carousel) {
            const postId = $carousel.data('post-id');
            const $slides = $carousel.find('.app-gallery-slide');

            if ($slides.length > 1 && !autoPlayIntervals[postId]) {
                autoPlayIntervals[postId] = setInterval(function () {
                    const currentIndex = $carousel.data('current-index') || 0;
                    goToSlide($carousel, currentIndex + 1);
                }, 3000);
            }
        }

        function stopAutoPlay($carousel) {
            const postId = $carousel.data('post-id');
            if (autoPlayIntervals[postId]) {
                clearInterval(autoPlayIntervals[postId]);
                delete autoPlayIntervals[postId];
            }
        }

        // Start auto-play for all carousels on page load
        $('.app-gallery-carousel').each(function () {
            startAutoPlay($(this));
        });

        // Pause auto-play on hover (for manual navigation), resume on leave
        $('.portfolio-card.has-gallery').on('mouseenter', function () {
            const $carousel = $(this).find('.app-gallery-carousel');
            stopAutoPlay($carousel);
        }).on('mouseleave', function () {
            const $carousel = $(this).find('.app-gallery-carousel');
            startAutoPlay($carousel);
        });

        // Touch swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        $(document).on('touchstart', '.app-gallery-carousel', function (e) {
            touchStartX = e.originalEvent.touches[0].clientX;
        });

        $(document).on('touchend', '.app-gallery-carousel', function (e) {
            touchEndX = e.originalEvent.changedTouches[0].clientX;
            const $carousel = $(this);
            const swipeDistance = touchStartX - touchEndX;

            if (Math.abs(swipeDistance) > 50) {
                const currentIndex = $carousel.data('current-index') || 0;
                if (swipeDistance > 0) {
                    // Swipe left - next
                    goToSlide($carousel, currentIndex + 1);
                } else {
                    // Swipe right - prev
                    goToSlide($carousel, currentIndex - 1);
                }
            }
        });

        // Lazy load images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        const src = img.dataset.src;

                        if (src) {
                            img.src = src;
                            img.removeAttribute('data-src');
                            observer.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // Stats counter animation
        $('.stat-value[data-count]').each(function () {
            const $this = $(this);
            const countTo = parseInt($this.data('count'));

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter($this, countTo);
                        observer.unobserve(entry.target);
                    }
                });
            });

            observer.observe(this);
        });

        function animateCounter($element, countTo) {
            $({ countNum: 0 }).animate({
                countNum: countTo
            }, {
                duration: 2000,
                easing: 'swing',
                step: function () {
                    $element.text(Math.floor(this.countNum).toLocaleString());
                },
                complete: function () {
                    $element.text(countTo.toLocaleString());
                }
            });
        }

        // Search functionality (if search input exists)
        $('#portfolio-search').on('keyup', function () {
            const searchTerm = $(this).val().toLowerCase();

            $('.portfolio-card').each(function () {
                const card = $(this);
                const title = card.find('h3').text().toLowerCase();
                const description = card.find('p').text().toLowerCase();
                const tags = card.find('.portfolio-tag').map(function () {
                    return $(this).text().toLowerCase();
                }).get().join(' ');

                const searchContent = title + ' ' + description + ' ' + tags;

                if (searchContent.indexOf(searchTerm) > -1) {
                    card.fadeIn(300);
                } else {
                    card.fadeOut(300);
                }
            });
        });

        // Sort functionality
        $('#portfolio-sort').on('change', function () {
            const sortBy = $(this).val();
            const $grid = $('.portfolio-grid');
            const $cards = $grid.find('.portfolio-card').get();

            $cards.sort(function (a, b) {
                let aVal, bVal;

                switch (sortBy) {
                    case 'title':
                        aVal = $(a).find('h3').text();
                        bVal = $(b).find('h3').text();
                        return aVal.localeCompare(bVal);

                    case 'date':
                        aVal = $(a).data('date') || '';
                        bVal = $(b).data('date') || '';
                        return bVal.localeCompare(aVal);

                    case 'price':
                        aVal = parseInt($(a).data('price')) || 0;
                        bVal = parseInt($(b).data('price')) || 0;
                        return bVal - aVal;

                    case 'views':
                        aVal = parseInt($(a).data('views')) || 0;
                        bVal = parseInt($(b).data('views')) || 0;
                        return bVal - aVal;

                    default:
                        return 0;
                }
            });

            $.each($cards, function (index, card) {
                $grid.append(card);
            });
        });

        // Add hover sound effect (optional)
        $('.portfolio-card').on('mouseenter', function () {
            // Optional: Add subtle sound effect
            // new Audio('hover-sound.mp3').play();
        });

        // Track analytics (if needed)
        $('.portfolio-btn, .overlay-btn').on('click', function () {
            const action = $(this).text().trim();
            const projectTitle = $(this).closest('.portfolio-card, .portfolio-modal-container').find('h3').text();

            // Send analytics event
            if (typeof gtag !== 'undefined') {
                gtag('event', 'portfolio_interaction', {
                    'event_category': 'Portfolio',
                    'event_label': projectTitle,
                    'event_action': action
                });
            }
        });

        // Parallax effect on scroll (subtle)
        let lastScrollTop = 0;
        $(window).on('scroll', function () {
            const scrollTop = $(this).scrollTop();
            const scrollDiff = scrollTop - lastScrollTop;

            $('.portfolio-card').each(function () {
                const $card = $(this);
                const offset = $card.offset().top - scrollTop;

                if (offset < window.innerHeight && offset > -$card.height()) {
                    const parallax = scrollDiff * 0.1;
                    $card.css('transform', `translateY(${parallax}px)`);
                }
            });

            lastScrollTop = scrollTop;
        });

        // Copy link functionality
        $('.copy-link-btn').on('click', function (e) {
            e.preventDefault();
            const url = $(this).data('url');

            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(() => {
                    showNotification('Link copied to clipboard!');
                });
            } else {
                // Fallback for older browsers
                const temp = $('<input>');
                $('body').append(temp);
                temp.val(url).select();
                document.execCommand('copy');
                temp.remove();
                showNotification('Link copied to clipboard!');
            }
        });

        // Show notification
        function showNotification(message) {
            const notification = $('<div class="portfolio-notification"></div>')
                .text(message)
                .css({
                    position: 'fixed',
                    bottom: '20px',
                    right: '20px',
                    background: '#00D4FF',
                    color: '#0A0E27',
                    padding: '15px 25px',
                    borderRadius: '8px',
                    fontWeight: '600',
                    zIndex: '100001',
                    boxShadow: '0 4px 12px rgba(0,0,0,0.2)',
                    animation: 'slideInUp 0.3s ease'
                });

            $('body').append(notification);

            setTimeout(() => {
                notification.fadeOut(300, function () {
                    $(this).remove();
                });
            }, 3000);
        }

        // Initialize tooltips (if using a tooltip library)
        if (typeof tippy !== 'undefined') {
            tippy('[data-tippy-content]', {
                arrow: true,
                animation: 'scale',
                theme: 'portfolio'
            });
        }

        // Load more functionality (infinite scroll or button)
        let page = 1;
        let loading = false;

        $('#load-more-portfolio').on('click', function () {
            if (loading) return;

            loading = true;
            const btn = $(this);
            btn.text('Loading...').prop('disabled', true);

            // AJAX call to load more items
            $.ajax({
                url: portfolioAjax.ajaxurl, // Define this in your PHP
                type: 'POST',
                data: {
                    action: 'load_more_portfolio',
                    page: ++page,
                    category: $('.filter-btn.active').data('filter'),
                    type: $('.filter-btn[data-filter-type="type"].active').data('filter')
                },
                success: function (response) {
                    if (response.success && response.data.html) {
                        $('.portfolio-grid').append(response.data.html);

                        // Reinitialize animations for new items
                        $('.portfolio-grid .portfolio-card:hidden').each(function (index) {
                            const $card = $(this);
                            setTimeout(() => {
                                $card.fadeIn(300);
                            }, index * 50);
                        });

                        if (!response.data.has_more) {
                            btn.text('No more items').prop('disabled', true);
                        } else {
                            btn.text('Load More').prop('disabled', false);
                        }
                    } else {
                        btn.text('No more items').prop('disabled', true);
                    }
                    loading = false;
                },
                error: function () {
                    btn.text('Load More').prop('disabled', false);
                    loading = false;
                    showNotification('Error loading more items');
                }
            });
        });

        // Infinite scroll (alternative to load more button)
        if ($('.portfolio-grid').data('infinite-scroll') === true) {
            $(window).on('scroll', function () {
                if (loading) return;

                const scrollTop = $(window).scrollTop();
                const windowHeight = $(window).height();
                const documentHeight = $(document).height();

                if (scrollTop + windowHeight > documentHeight - 500) {
                    $('#load-more-portfolio').trigger('click');
                }
            });
        }

        // Masonry layout (if needed for varied heights)
        if (typeof Masonry !== 'undefined') {
            const grid = document.querySelector('.portfolio-grid');
            if (grid && grid.classList.contains('masonry')) {
                new Masonry(grid, {
                    itemSelector: '.portfolio-card',
                    columnWidth: '.portfolio-card',
                    percentPosition: true,
                    gutter: 30
                });
            }
        }

        // Share functionality
        $('.share-btn').on('click', function (e) {
            e.preventDefault();
            const title = $(this).data('title');
            const url = $(this).data('url');

            if (navigator.share) {
                navigator.share({
                    title: title,
                    url: url
                }).catch(err => console.log('Error sharing:', err));
            } else {
                showNotification('Sharing not supported on this browser');
            }
        });
    });

})(jQuery);