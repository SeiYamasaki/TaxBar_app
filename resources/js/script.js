document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    // 要素が画面内に入ったとき
                    entry.target.classList.add('visible');
                    entry.target.classList.remove('hidden');
                } else {
                    // 要素が画面外に出たとき
                    entry.target.classList.add('hidden');
                    entry.target.classList.remove('visible');
                }
            });
        },
        { threshold: 0.5 } // 50% 表示されたらトリガー
    );

    // 監視対象を設定
    document.querySelectorAll('.animate-item').forEach((item) => {
        observer.observe(item);
    });
});
