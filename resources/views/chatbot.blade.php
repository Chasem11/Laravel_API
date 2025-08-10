<div class="chatbot-container">
    <form id="chatbotForm" onsubmit="sendMessage(); return false;">
        <div class="mb-3">
            <label for="userMessage" class="form-label">Ask a Question</label>
            <input type="text" id="userMessage" class="form-control" placeholder="Ask about due rentals or available items" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Send</button>
    </form>

    <!-- Chatbot response area with defined max height and scrollable overflow -->
    <div id="chatbotResponse" class="mt-3 p-2 border rounded" style="background-color: #f8f9fa; max-height: 250px; overflow-y: auto;">
        <!-- Chatbot responses will appear here -->
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
        .then(response => {
            if (!response.ok) {
                return response.text().then(errorText => {
                    throw new Error(`Error: ${response.status} - ${errorText}`);
                });
            }
            return response.json();
        })
        .then(data => {
            responseDiv.innerHTML += `<p><strong>Bot:</strong> ${data.response}</p>`;
            document.getElementById('userMessage').value = '';  // Clear the input
        })
        .catch(error => {
            responseDiv.innerHTML += `<p class="text-danger">There was an error: ${error.message}</p>`;
        });
    }
</script>
