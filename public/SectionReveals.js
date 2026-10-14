(() => {
    if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    const observed = new WeakSet();
    function reveal(target) {
        target.classList.remove('reveal-pending');
        target.classList.add('reveal-visible');
        observer.unobserve(target);
        if (target.matches('.process-timeline')) {
            target.querySelectorAll('.process-step').forEach(step => {
                step.classList.remove('reveal-pending');
                step.classList.add('reveal-visible');
            });
        }
    }
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            reveal(entry.target);
        });
    }, { rootMargin: '0px 0px -32px 0px', threshold: 0 });

    function observe(root) {
        root.querySelectorAll('body > section, .ecole-subsection').forEach(section => {
            if (observed.has(section)) return;
            observed.add(section);
            section.classList.add('section-reveal', 'reveal-pending');
            observer.observe(section);
        });
        root.querySelectorAll('.process-timeline').forEach(timeline => {
            if (observed.has(timeline)) return;
            observed.add(timeline);
            timeline.querySelectorAll('.process-step').forEach((step, index) => {
                step.style.setProperty('--reveal-delay', `${250 + index * 850}ms`);
                step.classList.add('reveal-item', 'reveal-pending');
            });
            observer.observe(timeline);
        });
        root.querySelectorAll('.hero-content, .hero-image, section > .section-title, .service-card, .process-next').forEach(item => {
            if (observed.has(item)) return;
            observed.add(item);
            const siblings = [...item.parentElement.children].filter(child => child.matches('.service-card, .process-step'));
            item.style.setProperty('--reveal-delay', `${Math.max(0, siblings.indexOf(item)) * 90}ms`);
            item.classList.add('reveal-item', 'reveal-pending');
            observer.observe(item);
        });
    }
    window.sectionReveals = { observe };
    observe(document);
    // Keyboard navigation and anchor links expose content immediately.
    document.addEventListener('focusin', event => {
        let target = event.target;
        while (target instanceof Element) {
            if (target.classList.contains('reveal-pending')) reveal(target);
            target = target.parentElement;
        }
    });
    window.matchMedia('(prefers-reduced-motion: reduce)').addEventListener('change', event => {
        if (!event.matches) return;
        observer.disconnect();
        document.querySelectorAll('.reveal-pending').forEach(reveal);
    });
})();
