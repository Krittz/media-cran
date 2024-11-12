<div class="notify" id="notification">
    <span class="notify-icon"><i class="ph ph-bell-simple"></i></span>
    <ul>
        @foreach($errors->all() as $error)
        <li>
            {{ $error }}
        </li>
        @endforeach
    </ul>
    <span class="notify-close"><i class="ph ph-x"></i></span>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timeout = 5000; // Tempo para a notificação sumir automaticamente (5 segundos)
        const notification = document.getElementById('notification');
        const closeIcon = document.querySelector('.notify-close');

        // Função para esconder a notificação com transição
        function hideNotification() {
            if (notification) {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 600); // Remove o elemento após a transição
            }
        }

        // Esconde a notificação automaticamente após o tempo definido
        if (notification) {
            setTimeout(hideNotification, timeout);
        }

        // Esconde a notificação ao clicar no ícone de fechar
        if (closeIcon) {
            closeIcon.addEventListener('click', hideNotification);
        }
    });
</script>