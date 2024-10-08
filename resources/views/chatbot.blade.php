<!-- chatbot.blade.php -->
<div class="modal fade" id="chatbotModal" tabindex="-1" aria-labelledby="chatbotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="chatbotModalLabel">Chatbot Assistant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="chatbotForm" onsubmit="sendMessage(); return false;">
                    <div class="mb-3">
                        <label for="userMessage" class="form-label">Ask a Question</label>
                        <input type="text" id="userMessage" class="form-control" placeholder="Ask about due rentals or available items" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send</button>
                </form>
                <div id="chatbotResponse" class="mt-3 p-2 border rounded" style="background-color: #f8f9fa;"></div>
            </div>
        </div>
    </div>
</div>

<script>
    function sendMessage() {
        const message = document.getElementById('userMessage').value;
        const responseDiv = document.getElementById('chatbotResponse');

        fetch('/chatbot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            responseDiv.innerHTML = `<p><strong>Bot:</strong> ${data.response}</p>`;
            document.getElementById('userMessage').value = '';  // Clear the input
        })
        .catch(error => {
            responseDiv.innerHTML = `<p class="text-danger">There was an error: ${error}</p>`;
        });
    }
</script>
