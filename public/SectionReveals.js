(() => {
    if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    const observed = new WeakSet();
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            entry.target.classList.remove('reveal-pending');
            observer.unobserve(entry.target);
        });
    }, { rootMargin: '0px 0px 40px 0px', threshold: 0 });

    function observe(root) {
        root.querySelectorAll('#services, #process, #contact, .ecole-subsection').forEach(section => {
            if (observed.has(section)) return;
            observed.add(section);
            // Visible content stays sharp; animate only sections approached on scroll.
            if (section.getBoundingClientRect().top <= window.innerHeight) return;
            section.classList.add('section-reveal', 'reveal-pending');
            observer.observe(section);
        });
    }
    window.sectionReveals = { observe };
    observe(document);
    // Keyboard navigation and anchor links expose content immediately.
    document.addEventListener('focusin', event => {
        const section = event.target.closest('.reveal-pending');
        if (section) {
            section.classList.remove('reveal-pending');
            observer.unobserve(section);
        }
    });
})();
