document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener('click', function (e) {
        let target = e.target;
        if (target.classList.contains('nav_arrow')) {
            switchNav(target);
        }
    })

    function switchNav(element) {
        let parent = element.closest('.nav-container');
        if (element.classList.contains('next')) {
            loadNext(parent, element);
            return;
        }
        loadPrev(parent, element);
    }

    function loadNext(container, navEl) {
        let totalPages = container.dataset.totalPages,
            curPage    = container.dataset.curpage,
            params     = {
                action   : 'k0d_navigate_posts',
                per_page : container.dataset.perpage,
                post_type: container.dataset.postType,
                cur_page : curPage,
                sort     : container.dataset.sort,
				helper 	 : 'next'
            };
        curPage++;
        runAjax(params);
        container.dataset.curpage = curPage;
        if (curPage == totalPages) {
            navEl.classList.add('hidden');
        }

        if (curPage > 1) {
            let navPrev = container.querySelector('.nav_arrow.prev');
            navPrev.classList.remove('hidden');
        }
    }

    function loadPrev(container, navEl) {
        let totalPages = container.dataset.totalPages,
            curPage    = container.dataset.curpage,
            params     = {
                action   : 'k0d_navigate_posts',
                per_page : container.dataset.perpage,
                post_type: container.dataset.postType,
                cur_page : curPage,
                sort     : container.dataset.sort,
				helper 	 : 'prev'
            };
        curPage--;
        runAjax(params);
        container.dataset.curpage = curPage;
        if (curPage === 1) {
            navEl.classList.add('hidden');
        }

        if (curPage < totalPages) {
            let navNext = container.querySelector('.nav_arrow.next');
            navNext.classList.remove('hidden');
        }
    }

    function runAjax(params) {
        fetch(k0d.ajaxurl, {
            method     : 'POST',
            headers    : {
                'Content-Type': `application/x-www-form-urlencoded; charset=utf-8`
            },
            body       : new URLSearchParams(params),
            credentials: 'same-origin'
        })
            .then(response => {
                return response.json();
            })
            .then(response => {
                if (response) {
                    let contentInner = document.querySelector('#shortcode-k0d .shortcode-content');
                    if (contentInner) {
                        contentInner.innerHTML = response;
                    }
                }
            })
    }
})
