function showReplyCard(button) {
    // Check if a reply card is already displayed
    var existingReplyCard = document.querySelector('.reply-card-visible');
    if (existingReplyCard) {
        existingReplyCard.remove();
    }

    // Get the card body of the clicked reply button
    var cardBody = button.closest('.card-body');

    // Clone the reply card template
    var replyCard = document.getElementById('replyCardTemplate').cloneNode(true);
    replyCard.style.display = 'block';
    replyCard.classList.add('reply-card-visible'); // Add a class to identify it
    replyCard.id = ''; // Remove the ID to avoid duplicates

    // Insert the reply card after the card body
    cardBody.parentNode.insertBefore(replyCard, cardBody.nextSibling);
}
