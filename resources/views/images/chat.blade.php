<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat con OpenRouter</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <h1>Chat con OpenRouter</h1>
    <form id="chatForm">
        <input type="text" id="message" placeholder="Escribe un mensaje..." required>
        <button type="submit">Enviar</button>
    </form>
    <div id="response"></div>

    <script>
        document.getElementById('chatForm').addEventListener('submit', function(event) {
            event.preventDefault();
            let message = document.getElementById('message').value;

            axios.post('/chat/send', { message: message })
                .then(response => {
                    document.getElementById('response').innerHTML = '<strong>Respuesta:</strong> ' + response.data.choices[0].message.content;
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
</body>
</html>
