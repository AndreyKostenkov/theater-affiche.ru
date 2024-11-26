document.querySelectorAll('.add-to-favorites').forEach(button => {
    button.addEventListener('click', function() {
        const showId = this.dataset.showId;
        fetch('add_to_favorites.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ show_id: showId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Добавлено в избранное!');
            } else {
                alert('Ошибка при добавлении в избранное.');
            }
        });
    });
});
