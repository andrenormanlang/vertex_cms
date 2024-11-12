document.addEventListener("DOMContentLoaded", () => {
    const postItems = document.querySelectorAll("li");

    postItems.forEach((item) => {
        item.classList.add("hidden"); // Start hidden
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("fade-in");
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });

    postItems.forEach((item) => {
        observer.observe(item);
    });
});
